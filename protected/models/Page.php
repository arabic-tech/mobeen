<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property integer $id
 * @property integer $caption_id
 * @property string $number
 * @property string $part
 * @property string $hadith
 * @property string $content
 * @property integer $x_id
 *
 * The followings are the available model relations:
 * @property Caption2[] $caption2s
 */
class Page extends CActiveRecord
{

	public function getDbConnection() {
		return Yii::app()->dbBukhari;
	}
	
	public static function getElasticMap() {
		return array(
	'id'=> array('type'=>'integer') , 
	'number' => array('type'=>'integer') ,
	'part' => array('type'=>'integer') ,
	'hadith' => array('type'=>'integer') ,
	'content' =>array('type'=>'string', 'index' => 'analyzed' ,'index_analyzer'=>'arabic' ,'search_analyzer'=>'arabic'),
);
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Page the static model class
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
		return 'page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, caption_id', 'required'),
			array('id, caption_id, x_id', 'numerical', 'integerOnly'=>true),
			array('number, part, hadith, content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, caption_id, number, part, hadith, content, x_id', 'safe', 'on'=>'search'),
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
			'caption2s' => array(self::HAS_MANY, 'Caption2', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'caption_id' => 'Caption',
			'number' => 'Number',
			'part' => 'Part',
			'hadith' => 'Hadith',
			'content' => 'Content',
			'x_id' => 'X',
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
		$criteria->compare('caption_id',$this->caption_id);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('part',$this->part,true);
		$criteria->compare('hadith',$this->hadith,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('x_id',$this->x_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
