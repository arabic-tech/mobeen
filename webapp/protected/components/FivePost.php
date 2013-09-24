<?php
Yii::import('zii.widgets.CPortlet');
 
class FivePost extends CWidget
{
    public function run() {
           $criteria=new CDbCriteria(array(
                        'condition'=>'status='.Post::STATUS_PUBLISHED,
                        'order'=>'update_time DESC',
                        'with'=>'commentCount', 
			'limit'=>7,
                ));

                $data= Post::model()->findAll( 
                        $criteria
                ); 

                $first = true ;
                for ($i=0 ; $i < sizeof($data); $i++ ) {
                        if($first) {
                                $first = !$first;
                                continue ;
                        }
                        $text = mb_substr(  $data[$i] ->content , 0, 1100, 'UTF-8');
                        $index = strrpos($text," ");
                        $text = substr($text,0,$index);

                        $data[$i]->content = $text ;
                }

		foreach ($data as $model) { 
?> 
<div class='row span11' > 
	<hr />
	<div class=" span8">	
		<div class="title ">
			<h1>
				<?php echo CHtml::link(CHtml::encode($model->title), $model->url); ?>
			
		</h1 >
<br/>
		</span>
		</div>
		
		<div class="content"> 	<?php echo $model->content; ?> </div>
	</div>
	<div class='span2' >
		<span class=' buttons' >
				<i class='icon-thumbs-up' onclick=<?php echo Yii::app()->user->isGuest?    '': CHtml::ajax( array( 'url'=>'/post/like' , 'data' => array('id' => $model->id) , 'update'=>'#likeLabel-'. $model->id  )) ; ?> > </i>
				<span  id='likeLabel-<?php echo $model->id ;?>' >  <?php 		echo sizeof($model->postLikes ) ; ?> </span>
				
				<i class='icon-thumbs-down ' onclick=<?php echo Yii::app()->user->isGuest?    '':CHtml::ajax( array( 'url'=>'/post/dislike'  ,'data' => array('id' => $model->id) , 'update'=>'#dislikeLabel-'.$model->id )) ;  ?> > </i>
				<span id='dislikeLabel-<?php echo $model->id ;?>'  > <?php 		echo sizeof($model->postDisLikes ) ; ?></span>
			<br/>
		<?php echo 'بلوحة مفاتيح ' .$model->author->pretty_name ; ?>
		<br/>
			<?php echo 'في يوم ' .   Yii::app()->dateFormatter->format('EEE، d LLLL، yyyy ', date('Y-m-j',$model->create_time)); ?>
		<br />
		<div class="nav">
			<b>الأوسمة:</b>
			<?php echo implode(', ', $model->tagLinks); ?>
			<br/>
			<?php echo CHtml::link("التعليقات ({$model->commentCount})",$model->url.'#comments'); ?> 
			<br />
			اخر تحديث في <?php echo Yii::app()->dateFormatter->format('EEE، d LLLL، yyyy ', $model->update_time); ?>
		</div>
		
	</div>
	<br/>

</div>
</div>

</div>


<?php
		 }


    }
}
