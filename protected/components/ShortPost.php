<?php
Yii::import('zii.widgets.CPortlet');
 
class ShortPost extends CWidget
{
    public function run() {


      //      $criteria=new CDbCriteria(array(
      //                   'condition'=>'status='.Post::STATUS_PUBLISHED,
      //                   'order'=>'update_time DESC',
      //                   'with'=>'commentCount', 
						// 'limit'=>15,
    	 //            ));

    $array =        array(
         'condition' => array('status' => Post::STATUS_PUBLISHED ),
        'sort' => array('date' => -1),
        'skip' => rand(50 , 10),
        'limit' => 11
    ) ; 

    $criteria = new EMongoCriteria(    $array);

    
    $data= Post::model()->find(    $criteria); 

                $first = true ;
                

		foreach ($data as $model) { 

?> 

<li>
    <img src="<?php echo User::model()->findByPk( $model->user_id)->picture ?>" class="right" /> 
    <a href='<?php echo "/post/view/" . $model->id ; ?>' >
        <p>  <?php echo $model->title     ;  ?> </p>
    </a>
            <div class="clear"></div>
    
</li>


<?php
		 }


    }
}