<?php 
	echo $this->Html->script(
		array('inline-input_mask.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('/js/inputmask/inputmask.js', '/js/inputmask/inputmask.date.extensions.js', '/js/inputmask/inputmask.phone.extensions.js', '/js/inputmask/jquery.inputmask.js'), 
		array('block' => 'inlineScripts')
	);
?>

<div class="user form">

	<p class="pull-right">
		<strong style="color:red">*</strong>
		<small><i> Campos obrigatórios</i></small>
	</p>

	<?php echo $this->Form->create('User', array('role' => 'form')); ?>

		<div class="row">
			<div class="form-group required col-md-3">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label'=>'Nome', 'placeholder' => 'ex.: João'));?>
			</div>
			<div class="form-group required col-md-4">
				<?php echo $this->Form->input('sbnome', array('class' => 'form-control', 'label'=>'Sobrenome', 'placeholder' => 'da Silva'));?>
			</div>
		</div>
		<div class="row">
			<div class="form-group required col-md-6">
				<?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'E-mail'));?>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<?php echo $this->Form->input('Cadastro.telefone', array('class' => 'form-control ddd_phone-mask', 'placeholder' => ''));?>
			</div>
		</div>
		<div class="row">
			<div class="form-group required col-md-3">
				<?php echo $this->Form->input('Cadastro.data_nascimento', array('class' => 'form-control date-mask', 'placeholder' => false, 'label'=>'Data de nascimento', 'type'=>'text'));?>
			</div>
		</div>

<!-- 		<div class="row">
			<div class="form-group fix-radio col-md-6">
				<strong>Sexo</strong><br />
				<?php
					$options = array('Masculino'=>'Masculino', 'Feminino'=>'Feminino');
					$attributes = array('legend' => false, 'separator'=>'&nbsp; &nbsp');
					echo $this->Form->radio('Cadastro.sexo', $options, $attributes);
				?>
			</div>
		</div>
 -->		
		<div class="row">
			<div class="form-group required col-md-3">
				<?php echo $this->Form->input('Cadastro.cpf', array('class' => 'form-control cpf-mask', 'placeholder' => '', 'label'=>'CPF', 'maxlength'=>'14'));?>
			</div>
		</div>

		<?php 
			# Configurações Padrões
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('Cadastro.id'); 
			echo $this->Form->hidden('Cadastro.status', array('value'=>1));
		?>
		
		<br />

		<?php echo $this->Form->button(__('Atualizar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
		

	<?php echo $this->Form->end(); ?>

</div>