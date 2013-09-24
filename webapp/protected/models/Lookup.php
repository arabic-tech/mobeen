<?php

class Lookup extends EMongoDocument
{
	/**
	 * The followings are the available columns in table 'tbl_lookup':
	 * @var integer $id
	 * @var string $object_type
	 * @var integer $code
	 * @var string $name_en
	 * @var string $name_fr
	 * @var integer $sequence
	 * @var integer $status
	 */

	private static $_items=array();

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
	// 	return '{{lookup}}';
	// }

	public function collectionName()
	{
		return 'lookup';
	}


	/**
	 * Returns the items for the specified type.
	 * @param string item type (e.g. 'PostStatus').
	 * @return array item names indexed by item code. The items are order by their position values.
	 * An empty array is returned if the item type does not exist.
	 */
	public static function items($type)
	{
	
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return self::$_items[$type];
	}

	/**
	 * Returns the item name for the specified type and code.
	 * @param string the item type (e.g. 'PostStatus').
	 * @param integer the item code (corresponding to the 'code' column value)
	 * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
	 */
	public static function item($type,$code)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
	}

	public static function itemClass($type,$code)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		if($type == 'PostStatus' )
		{

			if( $code == POST::STATUS_DRAFT ) return 'label label-inverse';
			if( $code == POST::STATUS_PUBLISHED ) return 'label label-success';
			if( $code == POST::STATUS_ARCHIVED ) return 'label label-info';

		} return 'label';
	}


	/**
	 * Loads the lookup items for the specified type from the database.
	 * @param string the item type
	 */
	private static function loadItems($type)
	{
		$array=array(
			'condition'=> array('type'=>$type ) ,
			'sort'=>array ( 'position' =>1 ),
		);
		$criteria = new EMongoCriteria($array);
		$models=self::model()->find($criteria);
		self::$_items[$type]=array();
		
		foreach($models as $model){
			self::$_items[$type][$model->code]=$model->name;
		}
	}
}