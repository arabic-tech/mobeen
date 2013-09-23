<?php

/**
 * This is the model class for table "{{post_like}}".
 *
 * The followings are the available columns in table '{{post_like}}':
 * @property integer $id
 * @property boolean $like
 * @property boolean $dislike
 * @property integer $create_time
 * @property integer $user_id
 * @property integer $post_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Post $post
 */
class Like extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostLike the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{like}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, post_id, type', 'required'),
			array('create_time, user_id, post_id', 'numerical', 'integerOnly'=>true),
			array('type', 'string'),
			array('like, dislike, type', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, like, dislike, create_time, user_id, post_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'like' => 'Like',
			'dislike' => 'Dislike',
			'create_time' => 'Create Time',
			'user_id' => 'User',
			'post_id' => 'Post',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('like',$this->like);
		$criteria->compare('dislike',$this->dislike);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('post_id',$this->post_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
