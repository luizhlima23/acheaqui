<div class="contato form">

	<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>

		<!-- Nome -->
		<div class="row">
			<div class="form-group col-md-6">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label' => 'Titulo', 'placeholder'=>'Nome do estabelecimento ou negócio'));?>
			</div>
		</div>

		<!-- Telefone -->
		<div class="row">
			<div class="col-md-12">
				<label>Telefones</label>
			</div>
			<div class="form-group col-md-3">
				<?php echo $this->Form->input('fone1', array('class' => 'form-control', 'label' => false));?>
			</div>
			<div class="form-group col-md-3">
				<?php echo $this->Form->input('fone2', array('class' => 'form-control', 'label' => false));?>
			</div>
		</div>

		<!-- Endereço -->
		<div class="row">
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('logradouro_id', array('class' => 'form-control', 'label' => 'Logradouro', 'empty'=>'(Escolha um)', 'multiple'=>false));?>
			</div>
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('end_num', array('class' => 'form-control', 'label' => 'Número'));?>
			</div>
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('end_comp', array('class' => 'form-control', 'label' => 'Complemento', 'placeholder'=>'ex.: Qd x Apt x'));?>
			</div>
		</div>

		<!-- localização -->
		<div class="row">
			<div class="form-group col-md-3">
				<?php echo $this->Form->input('bairro_id', array('class' => 'form-control', 'label' => 'Bairro', 'empty'=>'(Escolha um)', 'multiple'=>false));?>
			</div>
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('end_ref', array('class' => 'form-control', 'label' => 'Referência', 'placeholder'=>'ex.: próximo ao hospital municipal'));?>
			</div>
		</div>

		<h4>Tipo de estabelecimento</h4>
		<div class="row">
			<div class="form-group form-radio col-md-4">
				<?php
					$options = $tipos_estabelecimento;
					$attributes = array('legend' => false, 'separator'=>'&nbsp; &nbsp');
					echo $this->Form->radio('end_tpest', $options, $attributes);
				?>
			</div>
		</div>
		
		<h4>Tipo de cadastro</h4>
		<div class="row">
			<div class="form-group form-radio col-md-4">
				<?php
					$options = array('Física'=>__('Física'), 'Jurídica'=>__('Jurídica'));
					$attributes = array('legend' => false, 'separator'=>'&nbsp; &nbsp');
					echo $this->Form->radio('pessoa', $options, $attributes);
				?>
			</div>
		</div>

		<h4>Interesse em anúnciar?</h4>
		<div class="row">
			<div class="form-group form-radio col-md-4">
				<?php
					$options = Configure::read('Option.status_2');
					$attributes = array('legend' => false, 'separator'=>'&nbsp; &nbsp');
					echo $this->Form->radio('interessado', $options, $attributes);
				?>
			</div>
		</div>

		<!-- Características -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('status', array('type'=>'select', 'class'=>'form-control','options' => array(1=>__('Ativado'), 0=>__('Desativado')),'label' =>__('Situação')) ); ?>
			</div>
		</div>

		<?php 
			# Configurações Padrões
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('cidade_id', array('value'=>71));
		?>

		<br />

		<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>


	<?php echo $this->Form->end(); ?>

</div>
