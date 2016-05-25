<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'request-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'request_no',array('class'=>'span5','maxlength'=>15)); ?>

	<?php echo $form->textFieldRow($model,'date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'vendor_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'owner_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'job_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'contract_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'detail',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
