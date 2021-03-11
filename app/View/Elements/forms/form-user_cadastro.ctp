<div class="users form">

	<?php echo $this->Form->create('User', array('role' => 'form')); ?>

		<!-- Nome -->
		<div class="row">
			<div class="form-group col-md-6">
				<?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => 'Nome Completo', 'placeholder'=>false));?>
			</div>
		</div>

		<!-- E-mail -->
		<div class="row">
			<div class="form-group col-md-6">
				<?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => 'E-mail', 'placeholder'=>false));?>
			</div>
		</div>

		<?php 
			# Configurações Padrões
			echo $this->Form->hidden('id');
		?>

		<br />

		<?php echo $this->Form->button(__('Cadastrar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

	<?php echo $this->Form->end(); ?>

</div>
