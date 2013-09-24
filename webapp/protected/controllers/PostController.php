<?php

class PostController extends Controller
{
//	public $layout='column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('index','view'  ),
				'users'=>array('*'),
			),

			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('admin'  ),
				'roles'=>array('admin'),
			),

			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('list' ,'like' , 'create'  , 'dislike'),
				'users'=>array('@'),
			),
			array('deny' , 'users'=>array('*' )) , 
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$post=$this->loadModel();
		$comment=$this->newComment($post);

		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;
		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			$model->id = Counter::getNewPostId();

			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $criteria=new CDbCriteria(array(
		// 	'condition'=>'status='.Post::STATUS_PUBLISHED,
		// 	'order'=>'update_time DESC',
		// 	'with'=>'commentCount',
		// ));
		// if(isset($_GET['tag']))
		// 	$criteria->addSearchCondition('tags',$_GET['tag']);

		// $dataProvider=new CActiveDataProvider('Post', array(
		// 	'pagination'=>array(
		// 		'pageSize'=>Yii::app()->params['postsPerPage'],
		// 	),
		// 	'criteria'=>$criteria,
		// ));

		$array = array(
			'condition' => array(
				'status'=>Post::STATUS_PUBLISHED,
			)
			) 		 	
		;
		if(isset($_GET['tag']))
			$array['condition']['tags'] =$_GET['tag'];
		$criteria = new EMongoCriteria($array);

		$dataProvider =  new EMongoDataProvider('Post', array( 'criteria' => $criteria   )) ;


		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout='column2';

		$model=new Post('search');
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Suggests tags based on the current user input.
	 * This is called via AJAX when the user is entering the tags input.
	 */
	public function actionSuggestTags()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$tags=Tag::model()->suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
	}

	public function  actionLike($id)
	{
		$post = Post::model()->findByPk( $id);
		$post->like( );
		$this->redirect('/site/index');
	}


	public function  actionDisLike($id)
	{
		$post = Post::model()->findByPk( $id);
		$post->dislike( );
		$this->redirect('/site/index');
	}

	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
				if(Yii::app()->user->isGuest)
					//$condition='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
					$condition=array( 'status' => Post::STATUS_PUBLISHED ) ;
				else // TODO check if he the owner
					$condition=array();
				$this->_model=Post::model()->findByPk($_GET['id'], $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Creates a new comment.
	 * This method attempts to create a new comment based on the user input.
	 * If the comment is successfully created, the browser will be redirected
	 * to show the created comment.
	 * @param Post the post that the new comment belongs to
	 * @return Comment the comment instance
	 */
	protected function newComment($post)
	{
		$comment=new Comment;
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			$comment->user_id = Yii::app()->user->id;
			$comment->id = Counter::getNewCommentId();
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}

	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
	    return array(
	        // captcha action renders the CAPTCHA image displayed on the contact page
	        'captcha'=>array(
	            'class'=>'CCaptchaAction',
	            'backColor'=>0xFFFFFF,
	        ),
	    );
	}


	  /**
   * Manages  user entries .
   */
  public function actionList()
  { 
    $model=new Post('search');
    $model->unsetAttributes();  // clear any default values
	$condition = array('user_id' => Yii::app()->user->id  ) ; 
    if(isset($_GET['Post'])){
    	if(isset($_GET['Post']['title']	)) {
    		$regex = new MongoRegex("/".$_GET['Post']['title']."/i");
    		$condition['title'] = $regex	;
    	}

    	if(isset($_GET['Post']['status']) && $_GET['Post']['status']!==''  )
    		$condition['status'] = (int)$_GET['Post']['status']	;

      	$model->attributes = $_GET['Post'];
    }
    //var_dump($condition) ; exit;
    $dataProvider = new EMongoDataProvider('Post',   array( 'criteria' =>array( 'condition'=>$condition ), 'sort'=>array('defaultOrder'=>array('id'=>1,)))) ;
    
    $this->render('admin',array(
      'model'=>$model, 'dataProvider'=>$dataProvider ,
    ));
  }



}
