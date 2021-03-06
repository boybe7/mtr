<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'standard-form',
	'htmlOptions' => array('class' => 'well'),
	'enableAjaxValidation'=>false,
)); 
  	
  	echo "<h4>".$title."</h4>";
  	echo "<hr>";	
?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php

	 	//echo $form->textFieldRow($model,'material_id',array('class'=>'span5')); 

	  	$materialModels = Yii::app()->db->createCommand()
                        ->select('id,name')
                        ->from('materials')
                        ->order('id')
                        ->queryAll();


       //$models=Position::model()->findAll();
        $data = array();
        foreach ($materialModels as $key => $value) {
          $data[] = array(
                          'value'=>$value['id'],
                          'text'=>$value['name'],
                       );
        } 
        $typelist = CHtml::listData($data,'value','text');
        echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span5','empty'=>"")); 

	 ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span8','maxlength'=>200)); ?>

	<?php echo $form->textAreaRow($model,'description',array('class'=>'span8','maxlength'=>400)); ?>

	

	<div class="form-actions">
		<div class="pull-right">
		<?php

		 $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'บันทึก',
		)); 
		 echo "<span>  </span>";
		 $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'link',
					'type'=>'danger',
					'url'=>array("index"),
					'label'=>'ยกเลิก',
				)); 


		?>
		</div>
	</div>

<?php $this->endWidget(); ?>
