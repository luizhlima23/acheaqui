<div class="categoria form">

	<?php echo $this->Form->create('Categoria', array('role' => 'form')); ?>
		
		<!-- Nome da categoria -->
		<div class="row">
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label' => 'Descrição', 'placeholder'=>'ex.: Auto-escolas')); ?>
			</div>
		</div>

		<!-- Categoria Pai -->
		<div class="row">
			<div class="form-group col-md-6">
				<?php echo $this->Form->input('parent_id', array('options'=>$categoryList, 'class' => 'form-control selectpicker', 'data-live-search'=>true, 'label'=>'Categoria Pai', 'empty'=>'Nenhuma', 'multiple'=>false));?>
			</div>					
		</div>

		<?php 
			# Configurações Padrões
			echo empty($this->data['Categoria']['id']) ? null : $this->Form->hidden('id'); 
		?>		

		<br />

		<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>


	<?php echo $this->Form->end(); ?>

</div>
