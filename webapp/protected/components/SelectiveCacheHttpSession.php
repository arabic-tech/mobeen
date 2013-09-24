<?php

class SelectiveCacheHttpSession extends CCacheHttpSession{

    protected $_s_cache; // used because we can't access _cache here

    protected function calculateKey($id)
    {
          return self::CACHE_KEY_PREFIX.$id;
    }

    public function init()
    {
        $this->_s_cache=Yii::app()->getComponent($this->cacheID);
        parent::init();
    }


  protected function isBot() {
        if ( !isset($_SERVER['HTTP_USER_AGENT']) || $_SERVER['HTTP_USER_AGENT']=='-' ) return true;
        if (preg_match('/bot|index|spider|crawl|wget|slurp|Mediapartners-Google/i', $_SERVER['HTTP_USER_AGENT'])) return true;
        return false;
    }

        /**
         * Session write handler,
         * changed so that we don't really save if we have no data or if it belongs to a bot
         * Do not call this method directly.
         * @param string $id session ID
         * @param string $data session data
         * @return boolean whether session write is successful
         */

        public function writeSession($id, $data)
        {
            if ($this->isBot()) return true;
            $key=$this->calculateKey($id);
            if (!$data) {
                // an empty data can result after deleting a flash message from a session
                // we delete it instead of saving empty record
                $this->_s_cache->delete($key);
                return true;
            }
            // next line is not used since we already calcuated the key
            // return parent::writeSession($id,$data); 
            return $this->_s_cache->set($key, $data, $this->getTimeout());
        }

}
