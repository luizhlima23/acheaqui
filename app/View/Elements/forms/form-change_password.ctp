<div class="users form">
	<?php echo $this->Form->create('User',array('url'=>array('controller'=>'users', 'action'=>'change_password', $hash)) ); ?>
		
		<div class="form-group">
			<?php echo $this->Form->input('password',array('label' => false, 'type'=>'password', 'placeholder'=> __('Informe uma senha'), 'class'=> 'form-control'));?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input('confirm_password',array('label' => false, 'type'=>'password', 'placeholder'=> __('Confirme a senha'), 'class'=> 'form-control'));?>
		</div>

		<?php 
			# Configurações Padrões
			if (!empty($hash)){

				echo $this->Form->hidden('hash',array('value' => $hash));
			}
		?>

		<br />

		<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

	<?php echo $this->Form->end(); ?>
</div>