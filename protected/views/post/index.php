

<?php
if(!Yii::app()->user->isGuest ) { echo CHtml::link(  'انشاء مدخلة جديدة' , '/post/create') ; }
 if(!empty($_GET['tag'])): ?>
<h1>المدخلات بوسم  <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>"{items}\n{pager}",
)); ?>
