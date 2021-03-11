<div class="incorporation form">

	<p class="pull-right">
		<strong style="color:red">*</strong>
		<small><i> Campos obrigatórios</i></small>
	</p>
	
	<?php echo $this->Form->create('Incorporation', array('role' => 'form')); ?>

		<!-- Description -->
		<div class="row">
			<div class="form-group required col-md-3">
				<?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => 'Descrição', 'placeholder'=>false));?>
			</div>
		</div>

		<!-- Url -->
		<div class="row">
			<div class="form-group required col-md-6">
				<?php echo $this->Form->input('url', array('class' => 'form-control', 'label' => 'URL', 'placeholder'=>false));?>
			</div>
		</div>

		<!-- Script -->
		<div class="row">
			<div class="form-group required col-md-8">
				<?php echo $this->Form->input('incorporation', array('class' => 'form-control', 'label' => 'Incorporação', 'placeholder'=>'script...'));?>
			</div>
		</div>

		<!-- Situação -->
		<div class="row">
			<div class="form-group required col-md-2">
				<?php echo $this->Form->input('status', array('type'=>'select', 'class'=>'form-control','options' => Configure::read('Option.status'),'label' =>__('Status')) ); ?>
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
