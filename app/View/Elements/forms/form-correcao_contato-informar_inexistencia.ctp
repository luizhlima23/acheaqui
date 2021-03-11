<div class="contato form">
	
	<?php echo $this->Form->create('Contato', array('url'=>array('controller'=>'correcoes', 'action'=>'informar_inexistencia', 'contato_id'=>$this->request->data['Contato']['id']))); ?>
		
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
				<?php echo $this->Form->input('observacao', array('class' => 'form-control input-lg no-resize', 'placeholder' => 'algum comentário sobre a empresa?', 'label'=>false, 'type'=>'textarea', 'rows'=>2));?>
			</div>
		</div>

		<?php 
			echo $this->Form->hidden('id');
		?>

		<?php echo $this->Form->button(__('Confirmar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
		
		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>