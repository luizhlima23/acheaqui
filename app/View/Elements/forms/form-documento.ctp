<?php echo $this->Html->script( array('nicedit/nicEdit', 'nicedit_inputs'), array('block' => 'inlineScripts')); ?>

<div class="documento form">

	<?php echo $this->Form->create('PostDocumento'); ?>
		
		<!-- Titulo -->
		<div class="row">
			<div class="form-group required col-md-6">
				<?php echo $this->Form->input('nome', array('class'=>'form-control', 'label'=>false, 'placeholder'=>'Nome'));?>
			</div>
		</div>

		<!-- Descrição -->
		<div class="row">
			<div class="required col-md-12">
				<label>Descrição</label>
				<?php echo $this->Form->textarea('conteudo', array('id'=>'documentoConteudo', 'class'=>'form-control', 'label' => 'Descrição', 'placeholder'=>false, 'type'=>'text'));?>
			</div>
		</div>

		<?php 
			# Configurações Padrões
			echo $this->Form->hidden('id');
			echo $this->Form->hidden('status', array('value'=>1));
		?>
		<br>
		
		<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>