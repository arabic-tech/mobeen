<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>


	<?php echo CHtml::errorSummary($model , null , null  , array('class'=>'alert alert-error' )); ?>

	<div class="">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',Lookup::items('PostType')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>


	<div class="">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array( 'size'=>80,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="">
	<?php
	echo $form->labelEx($model,'content');
	$this->widget('ImperaviRedactorWidget', array(
		'model' => '',
		'id'=>'Post-Content',
		'attribute' => 'text',
		'name' => 'Post[content]',
		'value'=>$model->content,
		'options' => array(
			'lang' => 'ar',
			'direction'=>'rtl'
		),
	)); ?>


		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php $this->widget('CAutoComplete', array(
			'model'=>$model,
			'attribute'=>'tags',
			'url'=>array('suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>50),
		)); ?>
		<p class="hint"> يمكنك الفصل بين الأوسمة باستخدام الفاصلة (،) .</p>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="buttons pull-left">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'إنشاء' : 'حفظ'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
