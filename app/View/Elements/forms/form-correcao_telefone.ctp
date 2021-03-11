<?php 
	echo $this->Html->script(
		array('inline-input_mask.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('/js/inputmask/inputmask.js', '/js/inputmask/inputmask.phone.extensions.js', '/js/inputmask/jquery.inputmask.js'), 
		array('block' => 'inlineScripts')
	);
?>

<div class="contato form">

	<?php echo $this->Form->create('Contato', array('url'=>array('controller'=>'correcoes', 'action'=>'sugerir_telefone', 'contato_id'=>$contato_id))); ?>
		
		<!-- Telefone -->
		<div class="row">
			<div class="form-group col-xs-4 col-sm-2 col-md-1 col-lg-1">
				<?php echo $this->Form->input('ddd', array('class' => 'form-control', 'label' => 'DDD', 'placeholder'=>false, 'value'=>'61', 'disabled'));?>
			</div>
			<div class="form-group col-xs-8 col-sm-3 col-md-3 col-lg-3">
				<?php echo $this->Form->input('fone1', array('class' => 'form-control phone-mask', 'label' => 'Telefone', 'placeholder'=>false));?>
			</div>
		</div>

		<br>

		<?php 
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('Contato.nome');
		?>

		<?php echo $this->Form->button(__('Enviar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
		
		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>