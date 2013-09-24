<?php

/**
 * This is the model class for table "tbl_badge_log".
 *
 * The followings are the available columns in table 'tbl_badge_log':
 * @property string $action
 * @property integer $user_id
 * @property integer $action_score
 * @property string $time
 * @property integer $user_score
 * @property string $on_model
 * @property integer $on_id
 */
class BadgeLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BadgeLog the static model class
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
		return 'tbl_badge_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, action_score, user_score, on_id', 'numerical', 'integerOnly'=>true),
			array('action, on_model', 'length', 'max'=>255),
			array('time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('action, user_id, action_score, time, user_score, on_model, on_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'action' => 'Action',
			'user_id' => 'User',
			'action_score' => 'Action Score',
			'time' => 'Time',
			'user_score' => 'User Score',
			'on_model' => 'On Model',
			'on_id' => 'On',
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

		$criteria->compare('action',$this->action,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('action_score',$this->action_score);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('user_score',$this->user_score);
		$criteria->compare('on_model',$this->on_model,true);
		$criteria->compare('on_id',$this->on_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}