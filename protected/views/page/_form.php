<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caption_id'); ?>
		<?php echo $form->textField($model,'caption_id'); ?>
		<?php echo $form->error($model,'caption_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textArea($model,'number',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'part'); ?>
		<?php echo $form->textArea($model,'part',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'part'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hadith'); ?>
		<?php echo $form->textArea($model,'hadith',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'hadith'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content_plain'); ?>
		<?php echo $form->textArea($model,'content_plain',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content_plain'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->