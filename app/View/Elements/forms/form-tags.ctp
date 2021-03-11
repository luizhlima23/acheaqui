<div class="categoria form">

	<?php
		isset($this->request->params['named']['categoria_id']) ?
			$cat_id = $this->request->params['named']['categoria_id']
			: $cat_id = false;
	?>

	<?php echo $this->Form->create('Tag', array('role' => 'form')); ?>
		
		<!-- Tag -->
		<div class="row">
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('tag', array('class' => 'form-control', 'label' => 'Descrição', 'placeholder'=>'ex.: pão de mel')); ?>
			</div>
		</div>

		<!-- Categoria -->
		<div class="row">
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('categoria_id', array('options'=>$categoryList, 'class' => 'form-control selectpicker', 'data-live-search'=>true, 'label'=>'Categoria', 'empty'=>'Nenhuma', 'multiple'=>false));?>
			</div>					
		</div>				

		<!-- Situação -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('status', array('type'=>'select', 'class'=>'form-control','options' => array(1=>__('Ativado'), 0=>__('Desativado')),'label' =>__('Situação')) ); ?>
			</div>
		</div>

		<?php 
			# Configurações Padrões
			echo empty($this->data['Tag']['id']) ? null : $this->Form->hidden('id');
		?>

		<br />

		<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>
