<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'labtype-form',
	//'type' => 'horizontal',
	'htmlOptions' => array('class' => 'well'),
	'enableAjaxValidation'=>false,
)); 
  	
	$modelLab = Labtype::model()->findByPk($id);
	$modelMat = Material::model()->findByPk($modelLab->material_id);

  	echo "<h4>".$title." : ".$modelMat->name."/".$modelLab->name."</h4>";
  	echo "<hr>";	
 ?>
     <div class="alert alert-info">
	 <h5>คำแนะนำการกรอกข้อมูล</h5>
	 <ul>
	  <li>ชื่อ input ที่เป็นเลขยกกำลังให้ใช้ <code>&lt;sup&gt;ตัวเลข&lt;/sup&gt;</code> เช่น mm<sup>2</sup> =><code>mm&lt;sup&gt;2&lt;/sup&gt;</code> </li>
	  <li>สูตรคำนวณ ให้ใส่ "$"หน้าคอลัมภ์ ทุกครั้ง เช่น E/F =><code>$E/$F</code> </li>
	  <li>สูตรคำนวณ ที่เป็นเลขยกกำลังให้ใช้ <code>pow(ฐาน,เลขยกกำลัง)</code> เช่น E<sup>3</sup> =><code>pow($E,3)</code> </li>
	  <li>สูตรคำนวณ ค่า "π" ให้ใส่ว่า <code>pi()</code> </li>
	  <li>สูตรคำนวณ ค่าเฉลี่ย ให้ใส่ว่า <code>avg(ตัวเลข,ตัวเลข)</code> เช่น AVERAGE(A:D) => <code>avg($A,$B,$C,$D)</code>   </li>
	</ul>
	</div>
	
	<?php echo $form->errorSummary($model); ?>

	
	<?php

	 	//echo $form->textFieldRow($model,'material_id',array('class'=>'span5')); 

	 //  	$materialModels = Yii::app()->db->createCommand()
  //                       ->select('id,name')
  //                       ->from('materials')
  //                       ->order('id')
  //                       ->queryAll();


  //      //$models=Position::model()->findAll();
  //       $data = array();
  //       foreach ($materialModels as $key => $value) {
  //         $data[] = array(
  //                         'value'=>$value['id'],
  //                         'text'=>$value['name'],
  //                      );
  //       } 
  //       $typelist = CHtml::listData($data,'value','text');
  
  // 		echo '<span style="padding-right:38px;">ชนิดวัสดุ</span>';
		// echo CHtml::dropDownList('material_id','', $typelist,
		// 						array(
		// 						'empty'=>'กรุณาเลือกชนิดวัสดุ',	
		// 						'ajax' => array(
		// 							'type'=>'POST', //request type
		// 							'data'=>array('material'=>'js:this.value'),
		// 							'url'=>CController::createUrl('getLabtypeByMaterial'), //url to call.
		// 							//Style: CController::createUrl('currentController/methodToCall')
		// 							'update'=>'#labtype', //selector to update
									
		// 							//leave out the data key to pass all form values through
		// 						))); 
     
       
								 
		// //empty since it will be filled by the other dropdown
		// echo "<br>";
		// echo '<span style="padding-right:10px;">วิธีการทดสอบ</span>';
		// echo CHtml::dropDownList('labtype','', array('empty'=>'กรุณาเลือกวิธีการทดสอบ'));


?>
<!-- <h4>ชนิดวัสดุ : <?php    echo $modelMat->name;?></h4>
<h4>วิธีการทดสอบ : <?php echo $modelLab->name;?></h4>
 -->

<h5>Raw</h5>
<div id="errorRaw" name="errorRaw" class=""></div>
<div class="row-fluid">
 	<div class="span4">
		<?php 
		        echo CHtml::textField('nameRaw', '',array('class'=>'span12','placeholder'=>'ชื่อ'));

        ?>
	</div>
	<div class="span1">
		<?php echo CHtml::textField('columnRaw', '',array('class'=>'span12','placeholder'=>'คอลัมภ์')); ?>
	</div>
	
	<div class="span3">
		<?php echo CHtml::textField('formulaRaw', '',array('class'=>'span12','placeholder'=>'สูตรคำนวณ')); ?>
	</div>
	<div class="span1">
		<input type="checkbox" name="selfheaderRaw" id="selfheaderRaw" >with header
	</div>
	<div class="span1">
		<?php echo CHtml::textField('decimalRaw', '',array('class'=>'span12','placeholder'=>'ทศนิยม')); ?>
	</div>
	<div class="span2">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'ajaxLink',
		    
		    'type'=>'success',
		    'label'=>'เพิ่มข้อมูล',
		    'icon'=>'plus-sign',
		    'url'=>array('createRaw'),
		    'htmlOptions'=>array('class'=>'span12','style'=>''),
		    'ajaxOptions'=>array(
		    	    
		     	    'type' => 'POST',
                	'data' => array('labtype'=>$id,'name' => 'js:$("#nameRaw").val()','column' => 'js:$("#columnRaw").val()','formula' => 'js:$("#formulaRaw").val()','selfheader'=>'js:$("#selfheaderRaw").is(":checked")','decimal'=>'js:$("#decimalRaw").val()'),
                	'success' => 'function(msg){ 

                		error = "";
                		var obj = $.parseJSON(msg);
                		
                		jQuery.each(obj, function(i, val) {
                		  
						     error += val+"<br>";
						
						});



						if(error!="")
                             $("#errorRaw").addClass( "alert alert-block alert-error" );
						else	
							 $("#errorRaw").removeClass( "alert alert-block alert-error" );
						                		 
                		$("#errorRaw").html(error); 	

                		$("#columnRaw").val("");
                		$("#nameRaw").val(""); 
                		$.fn.yiiGridView.update("labtype-input-raw-grid"); }'
                ) 
		)); 




		?>
	</div>	
	
</div>

<?php

		$this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'labtype-input-raw-grid',
			'type'=>'bordered condensed',
			'selectableRows' =>2,
			'htmlOptions'=>array('style'=>'padding-top:5px'),
		    'enablePagination' => true,
		    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
		    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
			'dataProvider'=>$model->searchByType('raw',$id),
			// 'filter'=>$model,
			'columns'=>array(
				
				'name'=>array(
					    'name' => 'name',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("name"))),
						'headerHtmlOptions' => array('style' => 'width:35%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:left'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-raw-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
				'col_index'=>array(
					    'name' => 'col_index',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'col_index',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("col_index"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-raw-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
				'formula'=>array(
					    'name' => 'formula',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'formula',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("formula"))),
						'headerHtmlOptions' => array('style' => 'text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-raw-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
	  			'selfheader'=>array(
					    'name' => 'self_header',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'formula',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("formula"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section

							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-raw-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
				'decimal'=>array(
					    'name' => 'decimal_display',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'formula',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("formula"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-raw-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
	  			
				
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template' => '{delete}',
				),
			),
		)); 

	 ?>

 <hr>


<h5>Header</h5>
<div id="errorHeader" name="errorHeader" class=""></div>
<div class="row-fluid">
 	<div class="span4">
		<?php 
		        echo CHtml::textField('name', '',array('class'=>'span12','placeholder'=>'ชื่อ'));

        ?>
	</div>
	<div class="span1">
		<?php echo CHtml::textField('column', '',array('class'=>'span12','placeholder'=>'คอลัมภ์')); ?>
	</div>
	<div class="span3">
		<?php echo CHtml::textField('formula', '',array('class'=>'span12','placeholder'=>'สูตรคำนวณ')); ?>
	</div>
	<div class="span1">
		<input type="checkbox" name="selfheader" id="selfheader" >with header
	</div>
	<div class="span1">
		<?php echo CHtml::textField('decimal', '',array('class'=>'span12','placeholder'=>'ทศนิยม')); ?>
	</div>
	
	<div class="span2">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'ajaxLink',
		    
		    'type'=>'success',
		    'label'=>'เพิ่มข้อมูล',
		    'icon'=>'plus-sign',
		    'url'=>array('createHeader'),
		    'htmlOptions'=>array('class'=>'span12','style'=>''),
		    'ajaxOptions'=>array(
		    	    
		     	    'type' => 'POST',
                	'data' => array('labtype'=>$id,'name' => 'js:$("#name").val()','column' => 'js:$("#column").val()','formula' => 'js:$("#formula").val()','selfheader'=>'js:$("#selfheader").is(":checked")','decimal'=>'js:$("#decimal").val()'),
                	'success' => 'function(msg){  
                		
                		
                		error = "";
                		var obj = $.parseJSON(msg);
                		jQuery.each(obj, function(i, val) {
						   error += val+"<br>";
						});

						if(error!="")
                             $("#errorHeader").addClass( "alert alert-block alert-error" );
						else	
							 $("#errorHeader").removeClass( "alert alert-block alert-error" );
						                		 
                		$("#errorHeader").html(error); 
                		
                		$("#formula").val("");
                		$("#name").val("");
                		$("#column").val(""); 
                		$.fn.yiiGridView.update("labtype-input-header-grid"); 
                	}',
                	'error'=>'function(html){  console.log("fail");  }'
                ) 
		)); 




		?>
	</div>	
	
</div>

<?php

		$this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'labtype-input-header-grid',
			'type'=>'bordered condensed',
			'selectableRows' =>2,
			'htmlOptions'=>array('style'=>'padding-top:5px'),
		    'enablePagination' => true,
		    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
		    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
			'dataProvider'=>$model->searchByType('header',$id),
			// 'filter'=>$model,
			'columns'=>array(
				
				'name'=>array(
					    'name' => 'name',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("name"))),
						'headerHtmlOptions' => array('style' => 'width:35%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:left'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-header-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
				'col_index'=>array(
					    'name' => 'col_index',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'col_index',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("col_index"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-header-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
				'formula'=>array(
					    'name' => 'formula',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'formula',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("formula"))),
						'headerHtmlOptions' => array('style' => 'text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-header-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
	  			'selfheader'=>array(
					    'name' => 'self_header',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'formula',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("formula"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section

							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-header-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
				'decimal'=>array(
					    'name' => 'decimal_display',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'formula',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("formula"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-header-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
	  			'width'=>array(
					    'name' => 'width',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'formula',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("formula"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-header-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
	  			'group_header'=>array(
					    'name' => 'group_header',
					    'class' => 'editable.EditableColumn',
					    // 'filter'=>CHtml::activeTextField($model, 'formula',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("formula"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
						'editable' => array( //editable section
							//'apply' => '$data->user_status != 4', //can't edit deleted users
							//'text'=>'Click',
							//'tooltip'=>'Click',
							'title'=>'แก้ไข',
							'url' => $this->createUrl('updateInput'),
							'success' => 'js: function(response, newValue) {
											if(!response.success) return response.msg;

												$("#labtype-input-header-grid").yiiGridView("update",{});
											}',
							'options' => array(
								'ajaxOptions' => array('dataType' => 'json'),

							), 
							'placement' => 'right',
							'display' => 'js: function() {
						
							    
							}'
						)
	  			),
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template' => '{delete}',
					// 'buttons'=>array
		   //          (
		   //              'delete' => array
		   //              (
		   //                  'label'=>'delete',
		   //                  'icon'=>'trash',
		   //                  'type'=>'POST',
		   //                  'url'=>'Yii::app()->createUrl("labtype/deleteInput", array("id"=>$data->id))',
		   //                  'options'=>array(
		   //                      'class'=>'',
		   //                  ),
		   //              ),
		   //          )    
				),
			),
		)); 

	 ?>

	
	<div class="form-actions">
		<div class="pull-right">
		<?php

		 $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'primary',
			'url'=>array("index"),
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
