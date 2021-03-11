<?php $collapse = 'collapse'; if(isset($this->request['data']['filter'])){	$collapse = '';	} ?>
<?php echo $this->Search->create(null, array('id'=>'filter-form', 'class'=>''.$collapse.'')); ?>
<div class="panel-body">
	<div class="row">
		
		<!-- Código -->
		<div class="form-group col-md-1 col-sm-1">
			<label for="f_cod" class="bslabel">Código&nbsp;</label>
			<?php echo $this->Search->input('f_cod', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>
		
		<!-- Nome -->
		<div class="form-group col-md-3 col-sm-3">
			<label for="f_nome" class="bslabel">Nome&nbsp;</label>
			<?php echo $this->Search->input('f_nome', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>

		<!-- Fone 1 -->
		<div class="form-group col-md-2 col-sm-2">
			<label for="f_fone1" class="bslabel">Fone 1 &nbsp;</label>
			<?php echo $this->Search->input('f_fone1', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text', 'placeholder'=>'somente números'));?>
		</div>

		<!-- Referência  -->
		<div class="form-group col-md-2 col-sm-2" id="field-nome">
			<label for="f_referencia" class="bslabel">Referência &nbsp;</label>
			<?php echo $this->Search->input('f_referencia', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>

		<!-- Bairro -->
        <div class="form-group col-md-2 col-sm-2">
            <label for="f_bairro" class="bslabel"><?php echo __('Bairro'); ?>&nbsp;</label>
            <?php echo $this->Search->input('f_bairro', array('empty' => false,'multiple' => false, 'class'=>'form-control selectpicker', 'type'=>'select', 'data-live-search'=>true)); ?>
        </div>

		<!-- Pessoa -->
        <div class="form-group col-md-2 col-sm-2">
            <label for="f_pessoa" class="bslabel"><?php echo __('Pessoa'); ?>&nbsp;</label>
            <?php echo $this->Search->input('f_pessoa', array('empty' => false,'multiple' => false, 'class'=>'form-control', 'type'=>'select')); ?>
        </div>

		<!-- Situação -->
        <div class="form-group col-md-2 col-sm-2">
            <label for="f_status" class="bslabel"><?php echo __('Situação'); ?>&nbsp;</label>
            <?php echo $this->Search->input('f_status', array('empty' => false,'multiple' => false, 'class'=>'form-control', 'type'=>'select')); ?>
        </div>

		<!-- Interessado em Anúncio -->
        <div class="form-group col-md-2 col-sm-2">
            <label for="f_interessado" class="bslabel"><?php echo __('Deseja anunciar?'); ?>&nbsp;</label>
            <?php echo $this->Search->input('f_interessado', array('empty' => false,'multiple' => false, 'class'=>'form-control', 'type'=>'select')); ?>
        </div>
		
		<!-- Usuário  -->
		<div class="form-group col-md-2 col-sm-2" id="field-nome">
			<label for="f_user" class="bslabel">Responsável &nbsp;</label>
			<?php echo $this->Search->input('f_user', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>

		<!-- Cod. Plano  -->
		<div class="form-group col-md-2 col-sm-2" id="field-nome">
			<label for="f_plano" class="bslabel">Cód. Plano &nbsp;</label>
			<?php echo $this->Search->input('f_plano', array('class'=>'form-control', 'data-col'=>'col-md-3 col-sm-4', 'type'=>'text'));?>
		</div>

	</div>
</div>
<div class="panel-footer">
	<?php echo $this->Search->button(__('Filtrar'), array('type'=>'submit','class'=>'btn btn-success bsubmit btn-responsive', 'value'=>'0', 'name'=>'action-form')); ?>
</div>
<?php echo $this->Search->end(null, true); ?>