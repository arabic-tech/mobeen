<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * HttpClient is a simple minimal cUrl-based HTTP client
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


/**
 * Simple HTTP client based on cUrl, it can re-use connections
 * 
 * it support all kinds of custom HTTP verbs like PUT, PURGE and DELETE
 * used like this
 * $http=new HttpClient();
 * list($info, $content)=$http->get($url, array($key1=>$value1, $key2=>$value2));
 * list($info, $content)=$http->post($url, array($key1=>$value1, $key2=>$value2));
 *
 * @category  Services
 * @package   LiteSolr
 * @author    Muayyad Alsadi <alsadi@gmail.com>
 * @copyright 2013 Muayyad Alsadi
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PackageName
 */
class HttpClient
{
    protected $opt = array(
        CURLOPT_USERAGENT=>'LiteSolr (cUrl)',
        CURLOPT_HEADER => 0,
        CURLOPT_HTTPHEADER=>array('Expect: '),
        CURLOPT_FRESH_CONNECT => 0,
        CURLOPT_FORBID_REUSE => 0,
        CURLOPT_BINARYTRANSFER => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_TIMEOUT => 600,
    );
    protected $curl=null;

    /**
     * Constructor
     * 
     * @param array $options cUrl options common in all requests
     *
     * @return a new instance
     **/
    public function __construct($options=array())
    {
        $this->curl = curl_init();
        $this->opt = $options + $this->opt;
    }

    /**
     * Destructor
     **/
    public function __destruct()
    {
        if (gettype($this->curl) == 'resource') {
            curl_close($this->curl);
        }
    }

    /**
     * Send a custom HTTP request 
     *
     * @param string $verb        the HTTP verb eg. GET, POST, ...etc.
     * @param string $url         the URL to be requested
     * @param mixed  $get_params  values to be appended as query string
     * @param mixed  $post_params values to send in the request body (ie. POST)
     * @param array  $options     cURL options
     *
     * @return array having two elements info and result
     */
    public function request(
        $verb, $url,
        $get_params=null, $post_params=null, $options=array()
    ) {
        if ($get_params!==null) {
            $url.=(strpos($url, '?') === false ? '?' : '&')
                .(is_string($get_params)?$get_params:http_build_query($get_params));
        }
        $opt=array(CURLOPT_URL=>$url, CURLOPT_CUSTOMREQUEST=>$verb)+$options;
        if ($post_params!==null) {
            $opt += array(
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => (is_string($post_params))?
                    $post_params:http_build_query($post_params),
            );
        }
        $opt+=$this->opt;
        curl_setopt_array($this->curl, $opt);
        if (! $result = curl_exec($this->curl)) {
            return array(array(
                'code'=>'',
                'Content-Type'=>'',
                'curl-Error'=>curl_error($this->curl)), ''
            );
        }
        $info=array(
          'code' => curl_getinfo($this->curl, CURLINFO_HTTP_CODE),
          'Content-Type' => curl_getinfo($this->curl, CURLINFO_CONTENT_TYPE)
        );
        return array($info, $result);
    }
    
    /**
     * Send a GET requst using cURL
     *
     * @param string $url     to request
     * @param array  $params  values to send
     * @param array  $options for cURL
     *
     * @return array having two elements info and result
     */
    public function get($url, $params=null, $options=array())
    {   
        return $this->request("GET", $url, $params, null, $options);
    }


    /**
     * PHP magic so that you can $http->put(...);
     *
     * @param string $verb HTTP method to be called
     * @param array  $args options like request above
     *
     * @return array having two elements info and result
     */
    public function __call($verb, $args)
    {
        $url=array_shift($args);
        $get_params=array_shift($args);
        if ($get_params===null) {
            $get_params=array();
        }
        $post_params=array_shift($args);
        if ($post_params===null) {
            $post_params=array();
        }
        $options=array_shift($args);
        if ($options===null) {
            $options=array();
        }
        return $this->request(
            strtoupper($verb), $url, $get_params, $post_params, $options
        );
    }

    /**
     * shortcut static version
     *
     * @return array having two elements info and result
     */
    public static function getRequest()
    {
        $http=new HttpClient();
        return call_user_func_array(array($http, 'get'), func_get_args());
    }

    /**
     * shortcut static version
     *
     * @return array having two elements info and result
     */
    public static function postRequest()
    {
        $http=new HttpClient();
        return call_user_func_array(array($http, 'post'), func_get_args());
    }

    /**
     * shortcut static version
     *
     * @return array having two elements info and result
     */
    public static function customRequest()
    {
        $args=func_get_args();
        $verb=array_shift($args);
        $http=new HttpClient();
        return call_user_func_array(array($http, $verb), $args);
    }

}
