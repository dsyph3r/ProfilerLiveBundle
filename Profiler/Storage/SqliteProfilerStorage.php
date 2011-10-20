<?php

namespace Profiler\LiveBundle\Profiler\Storage;

use Symfony\Component\HttpKernel\Profiler\SqliteProfilerStorage as BaseSqliteProfilerStorage;

class SqliteProfilerStorage extends BaseSqliteProfilerStorage
{
    /**
     * Get the profiles since a token
     *
     * @param string   $token   Token to retrieve from
     * @return array            Tokens
     */
    public function fetchProfilesSince($token)
    {
        $criteria   = array();
        $args       = array();

        // Get latest tokens, exclude tokens to live profiler URL's
        $criteria[]     = 'token > :token';
        $criteria[]     = 'url NOT LIKE :profilerUrl';
        $criteria[]     = 'parent = :parent';

        $args[':token']         = $token;
        $args[':profilerUrl']   = '%/_live_profiler%';
        $args[':parent']        = '';

        $criteria = $criteria ? 'WHERE '.implode(' AND ', $criteria) : '';

        $db = $this->initDb();
        $sql = 'SELECT token, data, ip, url, time, parent
                FROM sf_profiler_data '.$criteria.'
                ORDER BY token ASC';
        $rawProfiles = $this->fetch($db, $sql, $args);
        $this->close($db);

        $profiles = array();
        foreach ($rawProfiles as $rawProfile)
        {
            $profiles[] = $this->createProfileFromData($rawProfile['token'], $rawProfile);
        }
        return $profiles;
    }
}
