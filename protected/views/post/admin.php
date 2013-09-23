<?php
$this->breadcrumbs=array(
	'إدارة المدخلات',
);
?>
<h1> إدارة المدخلات </h1>


<?php

 if(!Yii::app()->user->isGuest ) { echo CHtml::link(  'انشاء مدخلة جديدة' , '/post/create') ; }

 $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->title), $data->url)'
		),
		array( 'type'=>'raw',
			'name'=>'status',
			'value'=>'CHtml::label( Yii::t("core", Lookup::item("PostStatus",$data->status) ) , null , array("class"=> Lookup::itemClass( "PostStatus",$data->status)))',
			'filter'=>Lookup::items('PostStatus'),
		),
		array(
			'name'=>'create_time',
			'filter'=>false,
			'value'=>'Yii::app()->dateFormatter->format("EEE، d LLLL، yyyy ", $data->create_time)'
		),
	        // array(
	        //     'class'=>'bootstrap.widgets.TbButtonColumn',
	        //     'htmlOptions'=>array('style'=>'width: 50px'),
	        // ),
	),
)); ?>
