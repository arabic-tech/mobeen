<div class="form row  well">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>150)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>



<?php if(CCaptcha::checkRequirements()): ?>
<div class="">
    
	    <?php $this->widget('CCaptcha'); ?>
	    <?php echo $form->textField($model,'verifyCode'); ?>
    
    
    
    <?php echo $form->error($model,'verifyCode'); ?>
</div>
<?php endif; ?>

	<div class=" buttons pull-left">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'تحديث' : 'حفظ'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
