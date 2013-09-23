<?php
class Counter extends EMongoDocument {

	public static function model($className=__CLASS__) { return parent::model($className); }

	public  function collectionName() { return 'counters'; }

	public static function getNewCommentId(){
		$counter = Counter::model()->findBy_id(1) ;
		$counter->comment_id  +=1 ;
		$counter->update();
		//echo $counter->user_id ;
		return($counter->comment_id);
	}

	public static function getNewAuthorId(){
		$counter = Counter::model()->findBy_id(1) ;
		$counter->user_id  +=1 ;
		$counter->update();
		//echo $counter->user_id ;
		return($counter->user_id);
	}

	public static function getNewShareLogId(){
		$counter = Counter::model()->findBy_id(1) ;
		$counter->share_logs_id  +=1 ;
		$counter->update();
		return($counter->share_logs_id);
	}


	public static function getNewPostId(){
		$counter = Counter::model()->findBy_id(1) ;
		$counter->entry_id  +=1 ;
		$counter->update();
		//echo $counter->user_id ;
		return($counter->entry_id);
	}



	public static function getNewUserId(){
		$counter = Counter::model()->findBy_id(1) ;
		$counter->user_id  +=1 ;
		$counter->update();
		echo $counter->user_id ;
		return($counter->user_id);
	}

	/**
	 *
	 */
	public function getMongoId($value){
		return $value;
	}

	public function findBy_id($_id){
		$this->trace(__FUNCTION__);
		return $this->findOne(array('_id' => $_id));
	}

   
}
