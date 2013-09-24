<?php

/**
 *
 * CMongoDbAuthManager
 *
 * A quick hack that extends CPhpAuthManager
 * and overrides loadFromFile, saveToFile
 * The file on disk is replaced by a collection in a mongodb
 *
 *
 * PHP version 5.2+
 * required extensions: YiiMongoDbSuite
 *
 * @author Joe Blocher <yii@myticket.at>
 * @copyright 2011 myticket it-solutions gmbh
 * @license New BSD License
 * @category Database
 * @version	0.6 alpha
 *
 */

class CMongoDbAuthManager extends CPhpAuthManager {
    const DEFAULT_CONFIG = 'default';

	public $mongoConnectionId = 'mongodb';
	//The authFile property is the collection name
    public $authFile = 'mongodb_authmanager';

	private $_id;  //the MongoId
	private $_configId;

    protected static $_emongoDb;
    protected static $_mongocollections = array();


	/**
	 * MongoCmsAuthManager::__construct()
	 *
	 * @param mixed $configId
	 */
	public function __construct($configId = null)
	{
		$this->configId = $configId;
	}

	/**
	 * Set the configId
	 * Set configId to 'default' if is empty
	 *
	 * @param string $configId
	 */
	public function setConfigId($configId)
	{
		$this->_configId = empty($configId) ? self::DEFAULT_CONFIG : $configId;
	}

	/**
	 * Get the configId
	 *
	 * @return string
	 */
	public function getConfigId()
	{
		return $this->_configId;
	}

	/**
	 * Switch to another config
	 *
	 * @param mixed $configId
	 */
	public function switchConfig($configId = null, $loadData = false)
	{
	   $this->configId = $configId;
	   $this->_id = null;

	   if ($loadData)
	       $this->init(); //load from mongodb
	}

    /**
     * Get raw MongoDB instance
     *
     * @return MongoDB
     */
    public function getDb()
    {
        if (self::$_emongoDb === null)
            self::$_emongoDb = Yii::app()->getComponent($this->mongoConnectionId);
        return self::$_emongoDb;
    }

    /**
     * Returns current MongoCollection object
     * By default this method use {@see authFile}
     *
     * @return MongoCollection
     */
    public function getCollection($name = null)
    {
        if (!isset($name))
            $name = $this->authFile;

        if (!isset(self::$_mongocollections[$name]))
            self::$_mongocollections[$name] = $this->getDb()->selectCollection($name);

        return self::$_mongocollections[$name];
    }

    /**
     * Loads the authorization data from mongo db
     *
     * @param string $file is the collection name
     * @return array the authorization data
     * @see saveToFile
     */
    protected function loadFromFile($file)
    {
        $collection = $this->getCollection($file);
    	$criteria = array('configId' => $this->configId);
    	$data = $collection->findOne($criteria);

        if (empty($data))
            return array();

        // remove _id from data, because it's not an AuthItem
		if (isset($data['_id']))
        {
            $this->_id = $data['_id'];
            unset($data['_id']);
        }

    	// remove configId from data, because it's not an AuthItem
    	if (isset($data['configId']))
    	{
    		$this->configId = $data['configId'];
    		unset($data['configId']);
    	}

        return $data;
    }

    /**
     * Saves the authorization data from the collection 'file'
     *
     * @param array $data the authorization data
     * @param string $file the collection name
     * @see loadFromFile
     */
    protected function saveToFile($data, $file)
    {
        $collection = $this->getCollection($file);

        //have to set the _id for scenario update
		if (isset($this->_id))
            $data['_id'] = new MongoId($this->_id);

    	$data['configId'] = $this->configId;

        $collection->save($data);

    	//if this is a new record the _id value is created
    	//assign $this->_id is important when authManager->save() is called more than once
        $this->_id = $data['_id'];
    }
}

?>
