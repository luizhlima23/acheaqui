<?php echo $this->Form->create('User',array('url'=>array( 'controller'=>'users', 'action'=>'remember_password'))); ?>
	
	<div class="row">
		<div class="form-group col-md-5">
			<?php echo $this->Form->input('email',array('type'=>'email', 'placeholder'=> __('digite seu e-mail de acesso'), 'label'=>false, 'class'=> 'form-control input-lg')); ?>
		</div>
	</div>

	<br />
	
	<?php
		echo $this->Form->button(__('Enviar'),
		array('type'=>'submit', 'id'=>'loadButton', 'class'=>'btn btn-primary btn-lg', 'escape'=>false, 'data-loading-text'=>'Aguarde...', 'autocomplete'=>'off'));
	?>
	<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

<?php echo $this->Form->end(); ?>