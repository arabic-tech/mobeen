<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'التواصل',
);
?>

<h1> اتصل بنا</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('contact'),
    )); ?>

<?php else: ?>

<p>
    إذا كان عندك سؤال او استفسار الرجاء تعبئة النموذج التالي للتواصل معنا، شكرا لك 
</p>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <p class="note">الخانات الموسمة بـ <span class="required">*</span> مطلوبة.</p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'name'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

    <?php echo $form->textFieldRow($model,'subject',array('size'=>60,'maxlength'=>128)); ?>


    <?php $this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'id'=>'Entry-text',
    'attribute' => 'body',
    'name' => 'Entry[body]',
    'value'=>$model->body,
    'options' => array(
        'lang' => 'ar',
        'direction'=>'rtl'
    ),
));


 if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(
            'hint'=>'الرجاء ادخال الحروف كالتي في الصورة.<br/>لا تهتم لحالة الحروف.',
        )); ?>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'ارسال',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>