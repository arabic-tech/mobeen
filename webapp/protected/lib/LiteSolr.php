<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * LiteSolr is a simple minimal JSON-only solr client for PHP
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 2.0 of the Apache license
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @category  Services
 * @package   LiteSolr
 * @author    Muayyad Alsadi <alsadi@gmail.com>
 * @copyright 2013 Muayyad Alsadi
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @version   GIT: <git_id>
 * @link      http://pear.php.net/package/PackageName
 */

require_once dirname(__FILE__)."/HttpClient.php";

/**
 * LiteSolr the solr client class
 *
 * @category  Services
 * @package   LiteSolr
 * @author    Muayyad Alsadi <alsadi@gmail.com>
 * @copyright 2013 Muayyad Alsadi
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PackageName
 */
class LiteSolr
{
    public $prefix;
    protected $mapping=array(
        'ping'=>array('verb'=>'get', 'uri'=>'admin/ping'),
        // NOTE: for older solr versions uri should be update/json
        'update'=>array('verb'=>'post', 'uri'=>'update'),
    );
    protected $http;
    
    /**
     * Constructor
     * 
     * @param string $prefix  URL prefix to be used
     * @param array  $mapping maps actions to which HTTP verb and URI
     * @param array  $options to be passed to our curl HttpClient eg. user agent
     *
     * @throws Exception "bad reponse" if unable to ping
     **/
    public function __construct(
        $prefix='http://localhost:8983/solr/',
        $mapping=array(),
        $options=array()
    ) {
        $this->prefix=$prefix;
        $this->http=new HttpClient($options);
        $this->ping();
    }

    /**
     * commit: a shortcut on update
     * 
     * see http://wiki.apache.org/solr/UpdateXmlMessages
     * 
     * @param mixed $params solr commit options
     *
     * @return mixed php decoded json response
     **/
    public function commit($params=null)
    {
        // params would be assumed by solr to be
        // array('waitSearcher'=>true, 'softCommit'=>false, 'expungeDeletes'=>false)
        if (!$params) {
            $params=new stdClass();
        }
        return $this->update(array("commit"=>$params));
    }
    
    /**
     * optimize: a shortcut on update
     *
     * @param mixed $params solr commit options
     *
     * @return mixed php decoded json response
     **/
    public function optimize($params=null)
    {
        // params would be assumed by solr to be
        // array('waitSearcher'=>true, 'softCommit'=>false, 'maxSegments'=>1)
        if (!$params) {
            $params=new stdClass();
        }
        return $this->update(array("optimize"=> $params));
    }

    /**
     * delete: a shortcut on update
     *
     * @param mixed $params array or ids or a query like
     *                       array('query'=>'*', 'commitWithin'=>'100')
     *
     * @return mixed php decoded json response
     **/
    public function delete($params)
    {
        return $this->update(array('delete'=>$params));
    }

    /**
     * magic function that do HTTP API call according to the mapping
     *
     * @param string $action the action to be mapped eg. update_json or ping
     * @param mixed  $args   the parameters passed to it
     *
     * @return mixed php decoded json response
     **/
    public function __call($action, $args)
    {
        if (!isset($this->mapping[$action])) {
            $m=array();
        } else {
            $m=$this->mapping[$action];
        }
        $uri=isset($m['uri'])?$m['uri']:str_replace('_', '/', $action);
        $verb=isset($m['verb'])?$m['verb']:((count($args)<=2)?'get':'post');
        if ($verb=='get') {
            $params=array_merge(array($uri), $args);
            return call_user_func_array(array($this, 'jsonGet'), $params);
        } else {
            $params=array_merge(array($verb, $uri), $args);
            return call_user_func_array(
                array($this, 'jsonCustomVerb'), $params
            );  
        }
    }
    
    /**
     * internal function to call a GET method and decode response as JSON
     *
     * @param string $action  the stripped URI to be called
     * @param mixed  $params  the parameters passed
     * @param mixed  $options cUrl options
     *
     * @return mixed php decoded json response
     **/
    public function jsonGet($action, $params=array(), $options=array())
    {
        // TODO: we might need add 'ts'=>time() to all get params
        // we might also need to add 'indent'=>'true' for debugging
        list($info,$content_s)=$this->http->get(
            $this->prefix.$action,
            $params+array('wt'=>'json'),
            $options
        );
        if ($info['code']!=200 || null===($content=json_decode($content_s, 1))) {
            throw new Exception("bad response: ".json_encode($info));
        }
        return $content;
    }
    
    /**
     * internal function to call a POST method and decode response as JSON
     *
     * @param string $action     the stripped URI to be called
     * @param mixed  $params     the parameters passed
     * @param mixed  $get_params parameters to be added to query string
     * @param mixed  $options    cUrl options
     *
     * @return mixed php decoded json response
     **/
    public function jsonPost($action, $params, $get_params=array(), $options=array())
    {
        return $this->jsonCustomVerb(
            'post', $action, $params, $get_params, $options
        );
    }

    /**
     * internal function to call a custom verb and decode response as JSON
     *
     * @param string $verb       the verb name
     * @param string $action     the stripped URI to be called
     * @param mixed  $params     the parameters passed
     * @param mixed  $get_params parameters to be added to query string
     * @param mixed  $options    cUrl options
     *
     * @return mixed php decoded json response
     **/
    public function jsonCustomVerb(
        $verb, $action, $params,
        $get_params=array(), $options=array()
    ) {
        $options+=array(
            CURLOPT_HTTPHEADER => array('Content-type: application/json')
        );
        if (!is_string($params)) {
            $params=json_encode($params);
        }
        $url=$this->prefix.$action;
        $get_params+=array('wt'=>'json');
        list($info,$content_s) = call_user_func_array(
            array($this->http, 'request'),
            array(strtoupper($verb),
            $url, $get_params, $params, $options)
        );
        // TODO: we might need to consider 2xx not just 200
        if ($info['code']!=200 || null===($content=json_decode($content_s, 1))) {
            throw new Exception('bad response: '.json_encode($info));
        }
        return $content;
        
    }

}
