<?php 
	echo $this->Html->script(
		array('inline-toggle_checkbox.js', 'inline-input_mask.js', 'bootstrap-select.min.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('/js/inputmask/inputmask.js', '/js/inputmask/inputmask.date.extensions.js', '/js/inputmask/inputmask.phone.extensions.js', '/js/inputmask/jquery.inputmask.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->css(array('bootstrap-select'), array('block' => 'inlineCss'));
?>

<div class="contato form">

	<p class="pull-right">
		<strong style="color:red">*</strong>
		<small><i> Campos obrigatórios</i></small>
	</p>
	
	<?php echo $this->Form->create('Contato', array('url'=>array('controller'=>'correcoes', 'action'=>'sugerir_correcao', 'contato_id'=>$contato_id))); ?>
		
		<!-- Nome -->
		<div class="row">
			<div class="form-group required col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label' => 'Nome da Empresa', 'placeholder'=>'Nome da empresa ou negócio'));?>
			</div>
		</div>

		<!-- Telefone -->
		<div class="row">
			<div class="form-group col-xs-4 col-sm-2 col-md-1 col-lg-1">
				<?php echo $this->Form->input('ddd', array('class' => 'form-control', 'label' => 'DDD', 'placeholder'=>false, 'value'=>'61', 'disabled'));?>
			</div>
			<div class="form-group col-xs-8 col-sm-3 col-md-3 col-lg-3">
				<?php echo $this->Form->input('fone1', array('class' => 'form-control phone-mask', 'label' => 'Telefone', 'placeholder'=>false));?>
			</div>
		</div>

		<!-- Endereço -->
		<div class="row">
			<div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<?php
					echo $this->Form->input('logradouro_id',
						array(
							'class' => 'form-control selectpicker',
							'label'=>'Logradouro (Rua)',
							'empty'=>':: Selecione aqui',
							'multiple'=>false,
							'options'=>$logradouros,
							'data-live-search'=>true,
							'required'=>false
						)
					);
				?>
			</div>
			<div class="form-group col-xs-4 col-sm-2 col-md-2 col-lg-2">
				<?php echo $this->Form->input('end_num', array('class' => 'form-control', 'label' => 'Número'));?>
			</div>
			<div class="form-group col-xs-8 col-sm-5 col-md-4 col-lg-4">
				<?php echo $this->Form->input('end_comp', array('class' => 'form-control', 'label' => 'Complemento', 'placeholder'=>'ex.: Qd x Apt x'));?>
			</div>
		</div>

		<!-- localização -->
		<div class="row">
			<div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
				<?php
					echo $this->Form->input('bairro_id',
						array(
							'class' => 'form-control selectpicker',
							'label'=>'Bairro',
							'empty'=>':: Selecione aqui',
							'multiple'=>false,
							'options'=>$bairros,
							'data-live-search'=>true,
							'required'=>false
						)
					);
				?>
			</div>
			<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
				<?php echo $this->Form->input('end_ref', array('class' => 'form-control', 'label' => 'Referência', 'placeholder'=>'ex.: próximo ao hospital municipal'));?>
			</div>
		</div>

		<br>

		<?php 
			echo $this->Form->hidden('id');
		?>

		<?php echo $this->Form->button(__('Enviar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
		
		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>