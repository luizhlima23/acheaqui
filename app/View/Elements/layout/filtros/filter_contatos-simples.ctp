<?php $collapse = 'collapse'; if(isset($this->request['data']['filter'])){	$collapse = '';	} ?>
<?php echo $this->Search->create(null, array('id'=>'filter-form', 'class'=>''.$collapse.'')); ?>
<div class="panel-body">
	<div class="row">
		
		<!-- Código -->
		<div class="form-group col-md-2 col-sm-2">
			<label for="f_cod" class="bslabel">Código&nbsp;</label>
			<?php echo $this->Search->input('f_cod', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>
		
		<!-- Nome -->
		<div class="form-group col-md-4 col-sm-4">
			<label for="f_nome" class="bslabel">Nome&nbsp;</label>
			<?php echo $this->Search->input('f_nome', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>

		<!-- Fone 1 -->
		<div class="form-group col-md-3 col-sm-3">
			<label for="f_fone1" class="bslabel">Telefone &nbsp;</label>
			<?php echo $this->Search->input('f_fone1', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text', 'placeholder'=>'apenas números'));?>
		</div>

		<!-- Situação -->
        <div class="form-group col-md-2 col-sm-2">
            <label for="f_status" class="bslabel"><?php echo __('Situação'); ?>&nbsp;</label>
            <?php echo $this->Search->input('f_status', array('empty' => false,'multiple' => false, 'class'=>'form-control', 'type'=>'select')); ?>
        </div>

	</div>
</div>
<div class="panel-footer">
	<?php echo $this->Search->button(__('Filtrar'), array('type'=>'submit','class'=>'btn btn-success bsubmit btn-responsive', 'value'=>'0', 'name'=>'action-form')); ?>
</div>
<?php echo $this->Search->end(null, true); ?>