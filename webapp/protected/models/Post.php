<?php

class Post extends EMongoDocument
{

	/**
	 * The followings are the available columns in table 'tbl_post':
	 * @var integer $id
	 * @var string $title
	 * @var string $content
	 * @var string $tags
	 * @var integer $status
	 * @var integer $type
	 * @var integer $create_time
	 * @var integer $update_time
	 * @var integer $user_id
	 * @var PostLike[] $postLikes
	 @var PostLike[] $postDisLikes
	 */

	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;

	const TYPE_QUESTION =1;
	const TYPE_ARTICLE =2;
	const TYPE_TOOLS =3;
	public $current_user_like = null;	
	private $_oldTags;


	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{ 
		return parent::model($className);
	}

	// *
	//  * @return string the associated database table name
	 
	// public function tableName()
	// {
	// 	return '{{post}}';
	// }

	public function collectionName()
	{
		return 'post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, type, content, status', 'required'),
			array('status, type', 'in', 'range'=>array(1,2,3)),
			array('tags', 'normalizeTags'),
			array('status,type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		 //var_dump ( self::HAS_MANY   ) ; exit;
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			/* for db config
			// 'author' => array(self::BELONGS_TO, 'User', 'user_id'),
			// 'comments' => array(self::HAS_MANY, 'Comment', 'post_id', 'condition'=>'comments.status='.Comment::STATUS_APPROVED, 'order'=>'comments.create_time DESC'),
			// 'commentCount' => array(self::STAT, 'Comment', 'post_id', 'condition'=>'status='.Comment::STATUS_APPROVED),
			// 'postLikes' => array(PostLike::HAS_MANY , 'PostLike','post_id'  , 'condition' => 'likepost=1  ' ),
			// 'postDisLikes' => array(PostLike::STAT , 'PostLike','post_id'   ,'condition' => '	likepost=-1  ' ),
			*/

			 /* for mongodb config */
			  'author' => array( 'many', 'User', 'user_id' , 'on'=>'id'),
			  'comments' => array('many' , 'Comment', 'id' , 'on'=>'post_id'),
			  'postLikes' => array('many', 'PostLike','post_id'  , 'condition' => 'likepost=1  ' ),
			  //'postDisLikes' => array(PostLike::STAT , 'PostLike','post_id'   ,'condition' => '	likepost=-1  ' ),
			
			
			
		);
	}

	// public function getComments(){
	// 	$array = array(
	// 		'condition'=> array ( 'status' => Comment::STATUS_APPROVED  , 'post_id' => $this->id ) ,
	// 		'sort'=>array('create_time'=>1) ,
	// 	);

	// 	$criteria = new EMongoCriteria($array);
	// 	$data= Comment::model()->findAll( $criteria             ); 
		

	// 	// $criteria=new CDbCriteria(array(
	// 	// 	'condition'=>'status='.Comment::STATUS_APPROVED .' AND post_id=' . $this->id,
 //  //                       'order'=>'create_time DESC',
	// 	// 	));
	// 	// $data= Comment::model()->findAll( $criteria             ); 
	// 	return $data ;
	// }


	public function popularity(){
		return sizeof( $this->postLikes  ) - sizeof( $this->postDisLikes  )  ;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'الرقم الفريد',
			'title' => 'العنوان',
			'content' => 'النص',
			'tags' => 'الأوسمة',
			'status' => 'الحالة',
			'type' => 'Type',
			'create_time' => 'تاريخ الإنشاء',
			'update_time' => 'اخر تحديث',
			'user_id' => 'الناشر',
		);
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('post/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}


	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getLikeUrl()
	{
		return Yii::app()->createUrl('post/like', array(
			'id'=>$this->id,
		));
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getDisLikeUrl()
	{
		return Yii::app()->createUrl('post/dislike', array(
			'id'=>$this->id,
		));
	}


	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('post/index', 'tag'=>$tag));
		return $links;
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment)
	{
		if(Yii::app()->params['commentNeedApproval'])
			$comment->status=Comment::STATUS_PENDING;
		else
			$comment->status=Comment::STATUS_APPROVED;
		$comment->post_id=$this->id;
		$comment->user_id=Yii::app()->user->id;
		
		return $comment->save();
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->tags;
		$this->current_user_like = PostLike::model()->isUserLike( Yii::app()->user->id , $this->id);
	}
	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->create_time=$this->update_time=time();
				if(!isset($this->user_id))
				$this->user_id=Yii::app()->user->id; 

			}
			else
				$this->update_time=time();
			return true;
		}
		else
			return false;
	}

	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		parent::afterSave();
		Tag::model()->updateFrequency($this->_oldTags, $this->tags);
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
		Comment::model()->deleteAll('post_id='.$this->id);
		Tag::model()->updateFrequency($this->tags, '');
	}

	/**
	 * Retrieves the list of posts based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed posts.
	 */
	public function search()
	{
		// $criteria=new CDbCriteria;

		// $criteria->compare('title',$this->title,true);

		// $criteria->compare('status',$this->status);
		// $criteria->compare('type',$this->type);

		// return new CActiveDataProvider('Post', array(
		// 	'criteria'=>$criteria,
		// 	'sort'=>array(
		// 		'defaultOrder'=>'status, update_time DESC',
		// 	),
		// ));

		
		$array = array(
			//'condition' => array( 'title' => $this->title  , 'status'=>$this->status  , 'type'=>$this->type ) ,
			);
			$criteria = new EMongoCriteria($array);

		return new EMongoDataProvider('Post', array( 'criteria' => $criteria ) ) ;

	}


	/**
	 * get Related Post
	 */
	public function getMelated( )
	{
		$tag = Tag::string2array($this->tags) [0] ;
		$return =  Post::model()->findAll( array( "tags " =>  new MongoRegex("/$tag/") ) );;
		return $return;
	}

	public function getElasticMap()
	{
		return array(
			'id'=> array('type'=>'integer') ,
			'content' =>array('type'=>'string', 'index' => 'analyzed' ,'index_analyzer'=>'arabic' ,'search_analyzer'=>'arabic'),
			'title' =>array('type'=>'string', 'index' => 'analyzed' ,'index_analyzer'=>'arabic' ,'search_analyzer'=>'arabic'),
			'tags' =>array('type'=>'string', 'index' => 'analyzed' ,'index_analyzer'=>'arabic' ,'search_analyzer'=>'arabic'),
		) ;
	}

	public function like($user_id = null) 
	{
		if($user_id == null)
			$user_id = Yii::app()->user->id  ;

		$criteria=new CDbCriteria(array(
			'condition'=>' post_id=' . $this->id . ' AND user_id = ' . $user_id  ,
			));
		
		//$like = PostLike::model()->find( $criteria );
		$like = PostLike::model()->findOne( array(
			'post_id'=>   $this->id ,
			 'user_id' =>  $user_id  
			) );
		if($like==null)
			$like = new PostLike();
		$like->post_id =  $this->id ;
		$like->user_id = Yii::app()->user->id ;
		$like->likepost = 1;
		$like->save();
	}

	public function dislike($user_id = null) 
	{
		if($user_id == null)
			$user_id = Yii::app()->user->id  ;

		$criteria=new CDbCriteria(array(
			'condition'=>' post_id=' . $this->id . ' AND user_id = ' . $user_id  ,
			));
		
		//$like = PostLike::model()->find( $criteria );
		$like = PostLike::model()->findOne( array(
			'post_id'=>   $this->id ,
			 'user_id' =>  $user_id  
			) );
		
		if($like==null)
			$like = new PostLike();
		$like->post_id =  $this->id ;
		$like->user_id = Yii::app()->user->id ;
		$like->likepost = -1;
		$like->save();
	}

	public function findByPk( $id , $arr = array()){	
		return  self::model()->findOne( array_merge(array('id' =>(int)$id )  , $arr ) ) ;
	}
 
}
