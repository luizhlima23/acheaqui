<div class="users form">
	<?php echo $this->Form->create('User', array('url'=>array('controller'=>'users', 'action' => 'login'))); ?>
		
		<div class="form-group">
			<?php echo $this->Form->input('email', array('type'=>'email', 'placeholder'=>__('E-mail'),'label'=>false, 'class'=>'form-control input-lg')); ?>
		</div>
		
		<!-- Senha -->
		<div class="row">
			<div class="form-group required col-md-12">
				<?php echo $this->Form->input('password', array('class' => 'form-control input-lg', 'placeholder' => __('Senha'), 'label'=>false));?>
			</div>
		</div>

		<?php
			echo $this->Form->button(__('Acessar'),
				array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')
			);
			echo $this->Html->link(__('Esqueci minha senha'),
				array('controller' => 'users','action' => 'remember_password'),
				array('class'=>'btn btn-link')
			);
		?>

	<?php echo $this->Form->end(); ?>
</div>