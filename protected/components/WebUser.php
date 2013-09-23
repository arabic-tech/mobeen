<?php
class WebUser extends CWebUser {
	private $_model;

	function getModel() {
		return $this->loadUser(Yii::app()->user->id);
	}

	public function authenticate($id) {
		$access_token   = null;
		$user = null;
		if($id=='google'){
			if(!isset(Yii::app()->session['access_token' ])) $google_info = $this->storeAccesstocken('google') ;

			$key= Yii::app()->params->google['key']; 
			$access_token =  Yii::app()->session['access_token' ] ;

			$google_info = $this->getUserInfo('https://www.googleapis.com/oauth2/v2/userinfo' ,'key='.$key.'&access_token='.$access_token);
			$google_id = $google_info ->id;
			$user = User::model()->findOne(array ( "google_id" => $google_id ) );
			if(!isset($user)) { 
				$user = new User();
				$user->id = Counter::getNewUserId();
				$user->google_id  = $google_id  ;
				$user->pretty_name = $google_info->name;
				$user->email = $google_info->email;
				print_r($user->save());
				print_r($user->getErrors ());
			}
		}
		else if($id=='facebook'){
			if(!isset(Yii::app()->session['access_token' ])) $google_info = $this->storeAccesstocken('facebook') ;
			$facebook_info = $this->getUserInfo('https://graph.facebook.com/me' ,'access_token='.Yii::app()->session['access_token' ]);
			$user = User::model()->findOne(array ("facebook_id"=> $facebook_info->id) );
			if(!isset($user)) { 
				$user = new User();
				$user->id = Counter::getNewUserId();
				$user->facebook_id  = $facebook_info ->id  ;
				$user->pretty_name = $facebook_info ->name;
				$user->email = $facebook_info ->email;
				$user->picture = $this->getUserImage('https://graph.facebook.com/me' ,'fields=picture.width(70).height(70)&access_token='.Yii::app()->session['access_token' ])->picture->data->url ;
				

				print_r($user->save());
				print_r($user->getErrors ());
			}
		}

		else if($id=='twitter'){
			if(isset($_REQUEST['oauth_verifier'])){
				$oauth_token= Yii::app()->session['oauth_token'];
				$oauth_token_secret  = Yii::app()->session['oauth_token_secret'];
				$consumer_secrit = Yii::app()->params['twitter']['CONSUMER_SECRET'];
				$consumer_key = Yii::app()->params['twitter']['CONSUMER_KEY'] ;
				$connection = new TwitterOAuth($consumer_key,  $consumer_secrit, $oauth_token,$oauth_token_secret );
				$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

				if (200 == $connection->http_code) {
					Yii::app()->session['access_token'] = $access_token;
					$content = $connection->get('account/verify_credentials');
					$id = $content->id ;
					$user = User::model()->findOne(array ( "twitter" =>  $id));
					if(!isset($user)) {
						$user = new User();
						$user->id = Counter::getNewUserId();
						$user->twitter = $id  ;
						$user->pretty_name = $content ->screen_name;
						$user->email = 'a@a.com';
						$user->save();
					}

				}
			}else{
				$connection = new TwitterOAuth(Yii::app()->params['twitter']['CONSUMER_KEY'], Yii::app()->params['twitter']['CONSUMER_SECRET']);
				$request_token = $connection->getRequestToken(Yii::app()->controller->createAbsoluteUrl('site/login', array('via'=>'twitter')));

				Yii::app()->session['oauth_token']  = $request_token['oauth_token'];
				Yii::app()->session['oauth_token_secret'] = $request_token['oauth_token_secret'];
				/* If last connection failed don't display authorization link. */
				switch ($connection->http_code) {
					case 200:
						/* Build authorize URL and redirect user to Twitter. */
						$url = $connection->getAuthorizeURL($request_token);
						header('Location: ' . $url);
						exit;
						break;
					default:
						/* Show notification if something went wrong. */
						return false;
				}
			}
		}

		$duration= 3600*24*30 ; // 30 days
		$this->allowAutoLogin = true;

		Yii::app()->user->login($user);
		header ('Location: /'); exit;
	}

	public function storeAccesstocken($network){
		if($network == 'google') {
			$client_id = Yii::app()->params->google['client_id'];
			$client_secret = Yii::app()->params->google['client_secret'];
			$redirect_url= Yii::app()->controller->createAbsoluteUrl('site/login', array('via'=>'google')); 
			$scope= Yii::app()->params->google['scope']; 

			$url = 'https://accounts.google.com/o/oauth2/token';
			$authUrl = 'https://accounts.google.com/o/oauth2/auth?redirect_uri='.$redirect_url.'&response_type=code&client_id='.$client_id .'&approval_prompt=force&scope=' . $scope;

			if (isset($_GET['code'])) {
				$code = $_GET['code'];
				$post_data = 'grant_type=authorization_code&code='. $code. '&client_id='.$client_id.'&client_secret='.$client_secret.'&redirect_uri='.$redirect_url;
				list($info, $content) = HttpClient::postRequest($url, null, $post_data);

				//if ($info['code']!=200 || null===($json=json_decode($content, 1))) {
				if ($info['code']!=200) {
					throw new Exception('bad response: '.json_encode($info));
				}
				$access_token = '';

				if(isset($content ) ){
					$access_token =   json_decode ( $content )->access_token ;
				} else {
					parse_str($content) ;
				}

				Yii::app()->session['access_token' ] = $access_token ; 
				return $access_token  ;

			} else {
				header ('Location: '.$authUrl);
				exit;
			}
			}else	if($network == 'facebook') {
				$scope= Yii::app()->params->facebook['scope']; 
				$client_id = Yii::app()->params->facebook['client_id'];
				$client_secret = Yii::app()->params->facebook['client_secret'];
				$redirect_url= $redirect_url= Yii::app()->controller->createAbsoluteUrl('site/login', array('via'=>'facebook'));
				$url = 'https://www.facebook.com/dialog/oauth?&scope=' . $scope  ;
				$authUrl = $url ."&app_id=$client_id&redirect_uri=$redirect_url" ;

				$url = "https://graph.facebook.com/oauth/access_token?client_id=$client_id&redirect_uri=$redirect_url&client_secret=$client_secret";

				if (isset($_GET['code'])) {
					$code = $_GET['code'];
					//$post_data = 'grant_type=authorization_code&code='. $code. '&client_id='.$client_id.'&client_secret='.$client_secret.'&redirect_uri='.$redirect_url;
					list($info, $content) = HttpClient::getRequest($url  . '&code='. $code);
					if ($info['code']!=200) {
						throw new Exception('bad response: '.json_encode($info));
					}
					$json = json_decode ( $content ) ;
					$access_token = '';
					if(isset($json ) ){
						$access_token =   json_decode ( $content )->access_token ;
					} else {
						parse_str($content) ;
					}

					Yii::app()->session['access_token' ] = $access_token ; 
					return $access_token  ;

				} else {
					header ('Location: '.$authUrl);
					exit;
				}
			}
		}

		public function getUserInfo($url , $data=''){
			list($info, $content) = HttpClient::getRequest($url .'?'.$data);
			if ($info['code']!=200 || null===($json=json_decode($content))) {
				throw new Exception('bad response: '.json_encode($info));
			}
			$json = json_decode($content) ;
			return $json;
		}



		public function getUserImage($url , $data=''){
			list($info, $content) = HttpClient::getRequest($url .'?'.$data);
			if ($info['code']!=200 || null===($json=json_decode($content))) {
				throw new Exception('bad response: '.json_encode($info));
			}
			$json = json_decode($content) ;
			return $json;
		}


		public function login($user){
			//$user = User::model()->findByPk($identity->id) ;
			//var_dump($identity);exit;
			$user->last_login = time();
			if($user->validate()) $user->update();
			$this->changeIdentity($user->id,$user->pretty_name , null);
		}
	}
