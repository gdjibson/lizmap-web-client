<?php
/**
 * app context informations inside a Jelix environment.
 *
 * @author    3liz
 * @copyright 2020 3liz
 *
 * @see      https://3liz.com
 *
 * @license Mozilla Public License : http://www.mozilla.org/MPL/
 */

namespace Lizmap\App;

class JelixContext implements AppContextInterface
{
    /**
     * call and return jApp::config.
     */
    public function appConfig()
    {
        return \jApp::config();
    }

    /**
     * says if the current user has the given right. Call jAcl2::check().
     *
     * @param string $right    the key of the right to check
     * @param string $resource the id of a resource if any
     * @param mixed  $role
     *
     * @return bool The result of jAcl2::check()
     */
    public function aclCheck($role, $resource = null)
    {
        return \jAcl2::check($role, $resource);
    }

    /**
     * Retrieve the list of groups id, the current user is member of,
     * in the acl system.
     *
     * @return array list of group id (jAcl2DbUserGroup::getGroups() result)
     */
    public function aclUserGroupsId()
    {
        return \jAcl2dbUserGroup::getGroups();
    }

    /**
     * Retrieve the list of groups properties, the current user is member of,
     * in the acl system.
     *
     * @param string $login login of the user. if not given, the current user
     *                      is taken account
     *
     * @return \Iterator a list of groups objects (dao records)
     */
    public function aclUserGroupsInfo($login = '')
    {
        return \jAcl2DbUserGroup::getGroupList($login);
    }

    /**
     * Indicate if the current user is authenticated.
     *
     * @return bool return the result of jAuth::isConnected()
     */
    public function UserIsConnected()
    {
        return \jAuth::IsConnected();
    }

    /**
     * Informations of the current authenticated user.
     *
     * @return object the result of jAuth::getUserSession()
     */
    public function getUserSession()
    {
        return \jAuth::getUserSession();
    }

    /**
     * get the cached value of the given key.
     *
     * @param string $key     the cache key
     * @param string $profile the name of the cache type
     *
     * @return mixed the result given by jCache
     */
    public function getCache($key, $profile = '')
    {
        return \jCache::get($key, $profile);
    }

    /**
     * Set a data in the cache.
     *
     * @param string $key     The cache key
     * @param mixed  $value   The data to store in the cache
     * @param mixed  $ttl     data time expiration
     * @param string $profile the cache profile to use
     */
    public function setCache($key, $value, $ttl = null, $profile = '')
    {
        \jCache::set($key, $value, $ttl, $profile);
    }

    /**
     * Deletes data from cache.
     *
     * @param string $key     The cache key
     * @param string $profile The cache profile
     */
    public function clearCache($key, $profile = '')
    {
        \jCache::delete($key, $profile);
    }

    /**
     * Log a message.
     *
     * @param mixed  $message The message to log
     * @param string $cat     The category of the logged message
     */
    public function logMessage($message, $cat = 'default')
    {
        \jLog::log($message, $cat);
    }

    /**
     * Log an Exception.
     *
     * @param \Exception $exception The exception to log
     * @param string The category of the logged Exception
     * @param mixed $cat
     */
    public function logException($exception, $cat = 'default')
    {
        \jLog::logEx($exception, $cat);
    }

    /**
     * return the normalized value of a cache key, to be used with getCache.
     *
     * @param string $key
     *
     * @return string
     */
    public function normalizeCacheKey($key)
    {
        return \jCache::normalizeKey($key);
    }

    /**
     * Return the result of jProfile::createVirtualProfile.
     *
     * @param string $category The profile category to create
     * @param string $name     The profile name
     * @param array  $params   The parameters of the profile
     *
     * @throws \Exception
     */
    public function createVirtualProfile($category, $name, $params)
    {
        \jProfiles::createVirtualProfile($category, $name, $params);
    }

    /**
     * Return the properties of a profile by calling jProfile::get().
     *
     * @param string The profile category
     * @param string the profile name
     * @param bool If true and if the profile doesn't exist, throw an error
     * instead of getting the default profile
     * @param mixed $category
     * @param mixed $name
     * @param mixed $noDefault
     *
     * @return array properties
     */
    public function getProfile($category, $name = '', $noDefault = false)
    {
        return \jProfiles::get($category, $name, $noDefault);
    }

    /**
     * Call jEvent::notify().
     *
     * @param string The name of the event
     * @param array the parameters of the event
     * @param mixed $name
     * @param mixed $params
     *
     * @return \jEvent
     */
    public function eventNotify($name, $params = array())
    {
        return \jEvent::notify($name, $params);
    }

    /**
     * Return the connection to a Db by calling jDb::getConnection().
     *
     * @param string $profile The profile to use, if empty, use the default one
     *
     * @return \jDbConnection
     */
    public function getDbConnection($profile = '')
    {
        return \jDb::getConnection($profile);
    }

    /**
     * Get a string in a specific language.
     *
     * @param string $key The Jelix selector corresponding to the string
     *                    you want to get
     *
     * @return string the translated string
     */
    public function getLocale($key)
    {
        return \jLocale::get($key);
    }

    /**
     * Return the result of a jDao method.
     *
     * @param string $jSelector
     * @param string $profile   the profile name for the db connection
     *
     * @return \jDaoFactoryBase
     */
    public function getJelixDao($jSelector, $profile = '')
    {
        return \jDao::get($jSelector, $profile);
    }

    /**
     * {@inheritdoc}
     */
    public function createJelixForm($formSel, $formId = null)
    {
        return \jForms::create($formSel, $formId);
    }

    public function getUrl($selector)
    {
        return \jUrl::get($selector);
    }

    public function getFullUrl($selector, $params = array())
    {
        return \jUrl::getFull($selector, $params);
    }

    /**
     * Stores a json encoded object in a file located in var/log
     * Not really a Jelix Context but I'm using it a lot and it seems like a goos place for it.
     *
     * @param string $file   The name of the file where to put the json
     * @param mixed  $object The object to encode
     */
    public function debugObject($file, $object)
    {
        file_put_contents(\jApp::varPath().'/log/'.$file.'.log', json_encode($object, JSON_PRETTY_PRINT));
    }
}
