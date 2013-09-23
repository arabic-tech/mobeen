<div class="view">
<?php
$this->breadcrumbs=array(
		'Users'=>array('index'),
		$model->_id,
		);

$this->pageTitle = 'ملفي';
$model->badge = Yii::app()->badgeManager->getUserBadge(Yii::app()->user->id);
$model->score= Yii::app()->badgeManager->getUserScore(Yii::app()->user->id);

$form = $this->beginWidget('CActiveForm', array(
			'id'=>'verticalForm',
			'htmlOptions'=>array('class'=>'view'),
			)); ?>
<?php
//TODO
// echo Chtml::label(  'حسابات مرتبطة'  ,''); 
// echo Chtml::label(  $model->getLoginSource() ,'' , array('style'=>'margin-right:17px;display:block')); 
?>
<br/>
<?php
echo CHtml::label(
 $model->attributeLabels()['badge']
  .': '.$model->badge . ', '
  . $model->attributeLabels()['score'] .': '.$model->score , ''); 
?>


<br/>


<?php echo $form->label($model, 'prettyname' ); ?>
<?php echo $form->textField($model, 'prettyname'); ?>
<br/> <br/> 

<?php echo $form->label($model, 'email'); ?>

	<?php
if(is_array($model->email))
	foreach ($model->email as $key => $value) {
		echo CHtml::label(   $value , ' '   );
	}
else 
echo CHtml::label( $model->email  , '');

//echo $form->textField($model, 'email', array('class'=>'span3')); ?>
<br/> 
<?php echo $form->checkbox($model, 'subscribe'); ?>
<?php echo $form->label($model, 'subscribe' ); ?>

<br/>
<?php echo $form->checkbox($model, 'autoshare'); ?>
<?php echo $form->label($model, 'autoshare'); ?>

<br/>
<br/>
<div  style='text-align: left ; ' >

</div>
<br/>


<?php $this->endWidget(); ?>

</div>
