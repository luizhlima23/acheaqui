<?php $collapse = 'collapse'; if(isset($this->request['data']['filter'])){	$collapse = '';	} ?>
<?php echo $this->Search->create(null, array('id'=>'filter-form', 'class'=>''.$collapse.'')); ?>
<div class="panel-body">
	<div class="row">
		
		<!-- Código -->
		<div class="form-group col-md-1 col-sm-1">
			<label for="f_cod" class="bslabel"># ID&nbsp;</label>
			<?php echo $this->Search->input('f_cod', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>
		
		<!-- Pesquisa -->
		<div class="form-group col-md-3 col-sm-3">
			<label for="f_search_string" class="bslabel">Pesquisa&nbsp;</label>
			<?php echo $this->Search->input('f_search_string', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>
		
		<!-- Código de Usuário -->
		<div class="form-group col-md-1 col-sm-1">
			<label for="f_user_id" class="bslabel"># Usuário&nbsp;</label>
			<?php echo $this->Search->input('f_user_id', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>
		
		<!-- IP -->
		<div class="form-group col-md-3 col-sm-3">
			<label for="f_user_id" class="bslabel">IP Address&nbsp;</label>
			<?php echo $this->Search->input('f_ip', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>
		
		<!-- Mobile -->
        <div class="form-group col-md-2 col-sm-2">
            <label for="f_mobile" class="bslabel"><?php echo __('Mobile'); ?>&nbsp;</label>
            <?php echo $this->Search->input('f_mobile', array('empty' => false,'multiple' => false, 'class'=>'form-control', 'type'=>'select')); ?>
        </div>

	</div>
</div>
<div class="panel-footer">
	<?php echo $this->Search->button(__('Filtrar'), array('type'=>'submit','class'=>'btn btn-success bsubmit btn-responsive', 'value'=>'0', 'name'=>'action-form')); ?>
</div>
<?php echo $this->Search->end(null, true); ?>