<div class="users form">
	<?php echo $this->Form->create('Contato', array('url'=>array('controller'=>'contatos', 'action' => 'desistir_empresa'))); ?>
		
		<!-- Senha -->
		<div class="row">
			<div class="form-group required col-md-12">
				<?php echo $this->Form->input('User.password', array('class' => 'form-control input-lg', 'placeholder' => __('digite sua senha'), 'label'=>false));?>
			</div>
		</div>

		<?php
			echo $this->Form->button(__('Confirmar'),
				array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-block btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')
			);
		?>

		<?php
			echo $this->Form->hidden('Contato.id');
		?>

	<?php echo $this->Form->end(); ?>
</div>