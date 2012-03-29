<?php

namespace Profiler\LiveBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Profiler\LiveBundle\Profiler\LiveProfile;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag;

class ProfilerController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProfilerLiveBundle:Profiler:index.html.twig');
    }

    /**
     * Handle update requests from Live Profiler
     */
    public function updateAction($token = '')
    {
        $request = $this->container->get('request');
        
        if (version_compare(Kernel::VERSION, '2.1.0-dev', '<')) {
            if (null !== $session = $request->getSession()) {
                // keep current flashes for one more request
                $session->setFlashes($session->getFlashes());
            }
        } else {
            $session = $request->getSession();
            
            if (null !== $session && $session->getFlashBag() instanceof AutoExpireFlashBag) {
                // keep current flashes for one more request if using AutoExpireFlashBag
                $session->getFlashBag()->setAll($session->getFlashBag()->peekAll());
            }
        }

        // We use the profile token for the client to indicate the last token they
        // retrieved. The token is simple a uniqid(). If a token is not present
        // we just create one
        if (strlen($token) === 0) {
            $token = uniqid();
        }

        // Get the latest tokens
        $profilerStorage = $this->container->get('profiler.storage');
        $profiles        = $profilerStorage->fetchProfilesSince($token);

        // This will form the JSON response
        $profiler = array();
        $profiler['last_token'] = $token;
        $profiler['profiles']   = array();
        foreach ($profiles as $profile) {
            // Update the last token
            $profiler['last_token'] = $profile->getToken();

            $liveProfile = new LiveProfile($profile);
            $profiler['profiles'][$profile->getToken()] = $liveProfile->getProfileData();

            // Each profile can have a number of child profiles
            foreach ($profile->getChildren() as $child) {
                $liveProfile = new LiveProfile($child);
                $profiler['profiles'][$profile->getToken()]['children'][] = $liveProfile->getProfileData();
            }
        }

        return new Response(json_encode($profiler));
    }
}
