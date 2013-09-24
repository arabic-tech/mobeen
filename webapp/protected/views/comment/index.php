<?php
$this->breadcrumbs=array(
	'التعليقات',
);
?>

<h1>التعليقات</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
