<?php 
	echo $this->Html->script(
		array('bootstrap-select.min.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->css(array('bootstrap-select'), array('block' => 'inlineCss'));
?>

<div class="contato form">

	<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>

		<div class="row">
			<div class="form-group col-md-4">
				<?php
					echo $this->Form->input('user_id',
						array(
							'class' => 'form-control selectpicker',
							'label'=>false,
							'empty'=>':: Selecione aqui',
							'multiple'=>false,
							// 'options'=>$logradouros,
							'data-live-search'=>true,
							'required'=>false
						)
					);
				?>
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
