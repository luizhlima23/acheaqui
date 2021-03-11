<?php $collapse = 'collapse'; if(isset($this->request['data']['filter'])){	$collapse = '';	} ?>
<?php echo $this->Search->create(null, array('id'=>'filter-form', 'class'=>''.$collapse.'')); ?>
<div class="panel-body">
	<div class="row">

		<!-- Código -->
		<div class="form-group col-md-1 col-sm-1">
			<label for="f_cod" class="bslabel"><?php echo __('# ID'); ?>&nbsp;</label>
			<?php echo $this->Search->input('f_cod', array('class'=>'form-control', 'placeholder'=>false, 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>

		<!-- Nome -->
		<div class="form-group col-md-4 col-sm-4">
			<label for="f_name" class="bslabel"><?php echo __('Nome'); ?>&nbsp;</label>
			<?php echo $this->Search->input('f_name', array('class'=>'form-control', 'placeholder'=>__('Nome'), 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>

		<!-- Status -->
		<div class="form-group col-md-2 col-sm-2">
			<label for="f_status" class="bslabel"><?php echo __('Situação'); ?>&nbsp;</label>
			<?php echo $this->Search->input('f_status', array('empty' => 'Todos','multiple' => false, 'class'=>'form-control', 'type'=>'select')); ?>
		</div>

	</div>
</div>
<div class="panel-footer">
	<?php echo $this->Search->button(__('Filtrar'), array('type'=>'submit','class'=>'btn btn-success bsubmit btn-responsive', 'value'=>'0', 'name'=>'action-form')); ?>
</div>
<?php echo $this->Search->end(null, true); ?>