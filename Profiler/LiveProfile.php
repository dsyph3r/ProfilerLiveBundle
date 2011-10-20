<?php

namespace Profiler\LiveBundle\Profiler;

use Symfony\Component\HttpKernel\Profiler\Profile;

/**
 * LiveProfile
 *
 * Provides functionality to retrieve the required data from an Profile instance
 * ready to be returned in the response
 */
class LiveProfile
{
    /**
     * @var Profile
     */
    protected $profile;

    /**
     * List of collectors to get data from
     *
     * @var array
     */
    protected $collectors;

    /**
     * @param Profile   $profile        Profile object
     * @param array     $collectors     List of collectors to retrieve data for
     */
    public function __construct(Profile $profile, $collectors = array())
    {
        $this->profile = $profile;

        if (count($collectors))
        {
            // At the very least we need the request data
            $this->collectors = array_merge(array('request'), $collectors);
        }
        else
        {
            // Set the default collectors. No need to get them all we dont need them
            $this->collectors = array(
                'request', 'timer', 'memory', 'exception', 'swiftmailer', 'db',
            );
        }
    }

    /**
     * Get the data from the various DataCollectors
     *
     * @return array        The formatted Profile data
     */
    public function getProfileData()
    {
        $data = array();
        $data['children']    = array();
        $data['token']       = $this->profile->getToken();

        foreach ($this->collectors as $collectorName)
        {
            if ($this->profile->hasCollector($collectorName))
            {
                $data = array_merge($data, $this->profile->getCollector($collectorName)->getLiveData());
            }
        }

        return $data;
    }
}
