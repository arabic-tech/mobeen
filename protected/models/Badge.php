<?php

/**
 * This is the model class for table "{{badge}}".
 *
 * The followings are the available columns in table '{{badge}}':
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property integer $score
 */
class Badge extends EMongoDocument
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Badge the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	// public function tableName()
	// {
	// 	return 'tbl_badge';
	// }

	public function collectionName()
	{
		return 'badge';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('score', 'numerical', 'integerOnly'=>true),
			array('type, name', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, name, score', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'type' => 'Type',
			'name' => 'Name',
			'score' => 'Score',
		);
	}

	public function getBadges(){

		// $criteria=new CDbCriteria();
		// $criteria->compare('type','badge' , true);
		// $badges = Badge::model()->findAll($criteria);
		$badges = Badge::model()->find(array());
		$array = array();
		foreach ($badges  as $value) {
			$array [$value->badge]= $value->score;
		}
		return $array;
	}

	public function getUserBadge( $user_id){
        $badges = $this->getBadges();
        $user_score = User::model()->findByPk($user_id)->score;
		$tempScore =  0;
		$badge = '';
		if(is_array($badges))
		foreach ($badges as $key => $value) {
			if($value < $user_score  && $tempScore <=$value  )
				$badge=$key; $tempScore=$value  ;
		}
	
        return $badge ;
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('score',$this->score);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}