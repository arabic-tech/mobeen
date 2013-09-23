<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $Id
 * @property string $pretty_name
 * @property string $email
 * @property string $created_at
 * @property string $last_login
 * @property string $updated_at
 * @property string $validation_key
 * @property boolean $subscripe
 * @property string $facsubscribeebook_id
 * @property string $google_id
 * @property string $twitter
 * @property string $password
 *
 * The followings are the available model relations:
 * @property Post[] $posts
 * @property PostLike[] $postLikes
 */
class User extends EMongoDocument
{
	public $badge;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		// *
		//  * @return string the associated database table name
		 
		// public function tableName()
		// {
		// 	return 'tbl_user';
		// }

	/**
	 * @return string the associated database collection name
	 */
	public function collectionName()
	{
		return 'user';
	}

	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pretty_name, email', 'required'),
			array('pretty_name, email, validation_key, facebook_id, google_id, twitter, picture', 'length', 'max'=>255),
			array('password', 'length', 'max'=>256),
			array('score', 'numerical', 'integerOnly'=>true),
			array('created_at, last_login, updated_at, subscribe', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, pretty_name, email, created_at, last_login, updated_at, validation_key, facebook_id, google_id,picture,  twitter, password', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			// 'posts' => array(self::HAS_MANY, 'Post', 'user_id'),
			// 'postLikes' => array(self::HAS_MANY, 'PostLike', 'user_id'),

			'posts' => array('many' , 'Post', 'user_id'),
			'postLikes' => array('many' , 'PostLike', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'الرقم الفريد',
			'pretty_name' => 'اسم الظهور',
			'email' => 'البريد',
			'created_at' => 'تاريخ الإنشاء',
			'last_login' => 'اخر تسجيل دخول',
			'updated_at' => 'حدث في',
			'validation_key' => 'رمز التأكيد',
			'subscribe' => 'القائمة البريدية',
			'facebook_id' => 'حساب الفايسبوك',
			'google_id' => 'حساب جوجل',
			'twitter' => 'حساب تويتير',
			'password' => 'كلمة السر',
			'score' => 'العلامات',
			'badge' => 'اللقب',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->id);
		$criteria->compare('pretty_name',$this->pretty_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('validation_key',$this->validation_key,true);
		$criteria->compare('facebook_id',$this->facebook_id,true);
		$criteria->compare('google_id',$this->google_id,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('score',$this->score);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function getRole(){
		$auths = Yii::app()->authManager->getAuthAssignments(''.$this->id) ;
		$list = '';
		foreach ($auths as $key => $value) {
			$list.= $key ;
		}
		return $list ;
	}

	public static function getRolesList(){
		return array('admin'=>'Admin','editor'=>'Editor','author'=>'author'  );
	}

	public function setRole($role){

		$auth=Yii::app()->authManager;
		$items = $auth->getRoles($this->id);
		//echo (print_r($items , true)) ;
		foreach ($items as $item) {
			echo $auth->revoke($item->name, $this->id);
			$auth->save();
		}
		unset($auth);	
		$auth=Yii::app()->authManager;
		//echo $this->id; exit;
		$auth->assign($role,(int)$this->id); 
		return ($auth->save());
	}

	public function validatePassword($password)
	{

//echo $this->password ; exit;//. '<br />' .$this->password ; exit;
		return crypt($password,$this->password)===$this->password;
	}

	public function hashPassword($password)
	{
		return crypt($password , $this->generateSalt());
	}

	/**
	 * Generates a salt that can be used to generate a password hash.
	 *
	 * The {@link http://php.net/manual/en/function.crypt.php PHP `crypt()` built-in function}
	 * requires, for the Blowfish hash algorithm, a salt string in a specific format:
	 *  - "$2a$"
	 *  - a two digit cost parameter
	 *  - "$"
	 *  - 22 characters from the alphabet "./0-9A-Za-z".
	 *
	 * @param int cost parameter for Blowfish hash algorithm
	 * @return string the salt
	 */
	protected function generateSalt($cost=10)
	{
		if(!is_numeric($cost)||$cost<4||$cost>31){
			throw new CException(Yii::t('Cost parameter must be between 4 and 31.'));
		}
		// Get some pseudo-random data from mt_rand().
		$rand='';
		for($i=0;$i<8;++$i)
			$rand.=pack('S',mt_rand(0,0xffff));
		// Add the microtime for a little more entropy.
		$rand.=microtime();
		// Mix the bits cryptographically.
		$rand=sha1($rand,true);
		// Form the prefix that specifies hash algorithm type and cost parameter.
		$salt='$2a$'.str_pad((int)$cost,2,'0',STR_PAD_RIGHT).'$';
		// Append the random salt string in the required base64 format.
		$salt.=strtr(substr(base64_encode($rand),0,22),array('+'=>'.'));
		return $salt;
	}

	public function findByPk( $id , $arr = array()){	
		error_log( print_r(  $id  ,true)) ;
		return  self::model()->findOne( array_merge(array('id' =>(int)$id )  , $arr ) ) ;
	}
}
