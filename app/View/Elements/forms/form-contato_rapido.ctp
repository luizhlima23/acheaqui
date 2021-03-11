<div class="contato form">

<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>

	<!-- Nome, Telefone -->
	<div class="row">
		<div class="form-group col-md-4">
			<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label'=>'Titulo', 'placeholder' => 'ex.: Mercado Moura'));?>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('fone1', array('class' => 'form-control', 'label'=>'Telefone', 'placeholder' => 'ex.: 36120000'));?>
			</div>
		</div>
	</div>

	<!-- Endereço -->
	<div class="row">
		<div class="form-group col-md-4">
			<?php echo $this->Form->input('logradouro_id', array('class' => 'form-control selectpicker', 'data-live-search'=>true, 'label'=>'Logradouro', 'empty'=>'Clique aqui', 'multiple'=>false, 'default'=>$defaults['logradouro_id']));?>
		</div>
		<div class="form-group col-md-1">
			<?php echo $this->Form->input('end_num', array('class' => 'form-control', 'label'=>'Número', 'placeholder' => false));?>
		</div>
	</div>

	<!-- localização -->
	<div class="row">
		<div class="form-group col-md-3">
			<?php echo $this->Form->input('end_comp', array('class' => 'form-control', 'label'=>'Complemento', 'placeholder' => 'ex.: Qd 1 Lt 10'));?>
		</div>
		<div class="form-group col-md-3">
			<?php echo $this->Form->input('end_ref', array('class' => 'form-control', 'label'=>'Referência', 'placeholder' => 'ex.: próximo ao itaú'));?>
		</div>					
	</div>
	<div class="row">
		<div class="form-group col-md-3">
			<?php echo $this->Form->input('bairro_id', array('class' => 'form-control selectpicker', 'label'=>'Bairro', 'empty'=>'Clique aqui', 'data-live-search'=>true, 'default'=>$defaults['bairro_id']));?>
		</div>
	</div>

	<!-- Parâmetros -->
	<?php echo $this->Form->hidden('cidade_id', array('value'=>71)); ?>

	<br />
	
	<div class="row">
		<div class="form-group col-md-12">
			<?php
				echo $this->Form->button(__('Salvar'),
				array('type'=>'submit', 'id'=>'loadButton', 'class'=>'btn btn-primary btn-lg', 'escape'=>false, 'data-loading-text'=>'Aguarde...'));
			?>
		</div>
	</div>

<?php echo $this->Form->end(); ?>

</div>