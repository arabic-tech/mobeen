<?php
class Solr extends CApplicationComponent {
	public $baseUrl;
	protected $_solr;

	public function init() {
		$this->_solr = new LiteSolr($this->baseUrl);
	}

    public static __call($method, $args)
    {
        return call_user_func_array(array($_solr, $method), $args);
    }

}
