<?php 
	echo $this->Html->script(
		array('bootstrap-select.min.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->css(array('bootstrap-select'), array('block' => 'inlineCss'));
?>
<div class="bairro form">

	<p class="pull-right">
		<strong style="color:red">*</strong>
		<small><i> Campos obrigatórios</i></small>
	</p>
	
	<?php echo $this->Form->create('Bairro', array('role' => 'form')); ?>

		<!-- Nome -->
		<div class="row">
			<div class="form-group required col-md-4">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label' => 'Nome', 'placeholder'=>false));?>
			</div>
		</div>

		<!-- Cidade -->
		<div class="row">
			<div class="form-group required col-md-3">
				<?php
					echo $this->Form->input('cidade_id', 
						array(
							'class' => 'form-control selectpicker', 
							'label'=>'Cidade', 
							'empty'=>':: Selecione', 
							'data-live-search'=>true, 
							'options'=>$cidades, 'required'=>false
						)
					);
				?>
			</div>
		</div>

		<!-- Situação -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('status', array('type'=>'select', 'class'=>'form-control','options' => Configure::read('Option.status'),'label' =>__('Situação')) ); ?>
			</div>
		</div>

		<?php 
			# Configurações Padrões
			echo $this->Form->hidden('id');
		?>
		<br />

		<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>