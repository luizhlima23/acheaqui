<?php $collapse = 'collapse'; if(isset($this->request['data']['filter'])){	$collapse = '';	} ?>
<?php echo $this->Search->create(null, array('id'=>'filter-form', 'class'=>''.$collapse.'')); ?>
<div class="panel-body">
	<div class="row">
		
		<!-- # ID -->
		<div class="form-group col-xs-12 col-sm-3 col-md-2 col-lg-2">
			<?php 
				echo $this->Search->input('f_cod', 
					array('class'=>'form-control', 'type'=>'text', 'placeholder'=>'# ID')
				);
			?>
		</div>

		<!-- NOME -->
		<div class="form-group col-md-4 col-sm-4">
			<?php echo $this->Search->input('f_nome', array('class'=>'form-control', 'type'=>'text', 'placeholder'=>'Nome'));?>
		</div>

		<!-- STATUS -->
		<div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<?php 
				echo $this->Search->input('f_status', 
					array('empty'=>':: Status','multiple' => false, 'class'=>'form-control', 'type'=>'select')
				);
			?>
		</div>

	</div>
</div>
<div class="panel-footer">
	<?php echo $this->Search->button(__('Filtrar'), array('type'=>'submit','class'=>'btn btn-success bsubmit btn-responsive', 'value'=>'0', 'name'=>'action-form')); ?>
</div>
<?php echo $this->Search->end(null, true); ?>