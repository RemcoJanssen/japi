<?php
/**
 * @version     Tools/QuotaManager.php 2014-07-22 13:43:00 UTC zanardi
 */
namespace Tools;
class QuotaManager
{

    /**
     * Check the quota of today API calls for the logged user
     * 
     * @return void
     */
    public function checkQuota()
    {
        $app = \Slim\Slim::getInstance();
        if ($this->skipCheckQuota($app))
        {
            return true;
        }

        $todayApiCalls = $this->getTodayNumberOfCall($app);
        $quotaDailyLimit = $this->getQuotaDailyLimit();
        if ($todayApiCalls >= $quotaDailyLimit)
        {
            throw new \Exception('You have reached your daily quota for API calls (' . $quotaDailyLimit . '). You already made ' . $todayApiCalls . ' calls today', 429);
        }
        $this->incrementCall($app);
        
        return true;
    }

    /**
     * Check the number of call for the current day for the logged user
     * Warning: currently, to avoid breaking the API, if we are unable to get 
     * the result we just return 0. When the API is out of its BETA stage it 
     * would probably be better to throw an exception and stop the API execution
     * 
     * @param $app the Slim application
     * @return int
     */
    public function getTodayNumberOfCall($app)
    {
        $app->_db->setQuery("SELECT apiCall FROM #__users WHERE id = " . $app->user->id);
        try
        {
            return $app->_db->loadResult();
        }
        catch (Exception $e)
        {
            return 0;
        }
    }

    /**
     * Increment the number of call for the logged user
     * 
     * @param $app the Slim application
     */
    private function incrementCall($app)
    {
        $app->_db->setQuery("UPDATE #__users SET  apiCall=apiCall+1 WHERE id = " . $app->user->id);
        $app->_db->query();
    }

    /**
     * Get daily quota for the logged user. Currently is a fixed number for all 
     * users, lately it may be specific for each user in the db.
     * 
     * @return int
     */
    private function getQuotaDailyLimit()
    {
        return 2000;
    }
    
    /**
     * Check if there are some reasons to skip the quota check, e.g. a special
     * system user 
     * 
     * @param $app the Slim application
     * @return bool
     */
    private function skipCheckQuota($app)
    {
        if ($app->user->username == 'uptimerobot')
        {
            return true; // no quota for UptimeRobot notifications
        }
        if ($app->request->getIp() == $_SERVER['SERVER_ADDR'])
        {
            return true; // no quota for internal API use
        }
        return false;
    }

}
