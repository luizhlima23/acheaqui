<div class="role form">

	<p class="pull-right">
		<strong style="color:red">*</strong>
		<small><i> Campos obrigatórios</i></small>
	</p>
	
	<?php echo $this->Form->create('Role', array('role' => 'form')); ?>

		<!-- Nome -->
		<div class="row">
			<div class="form-group required col-md-4">
				<?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => 'Função', 'placeholder'=>'Nome'));?>
			</div>
		</div>

		<!-- Descrição -->
		<div class="row">
			<div class="form-group required col-md-6">
				<?php echo $this->Form->input('description', array('type'=>'textarea', 'class' => 'form-control', 'label' => 'Descrição', 'placeholder'=>'Descrição', 'rows'=>'2', 'cols'=>'5'));?>
			</div>
		</div>

		<!-- Ordem, Admin menu -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('ordem', array('type'=>'number', 'class' => 'form-control', 'label' => 'Ordem', 'placeholder'=>false));?>
			</div>
			<div class="form-group col-md-2">
				<?php 
					echo $this->Form->input('admin_menu', 
						array(
							'type'=>'select', 'class'=>'form-control',
							'options' => $role_menus,
							'label' =>__('Menu de funções'),
							'empty'=> ':: Nenhum'
						) 
					); 
				?>
			</div>
		</div>

		<!-- Situação -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('status', array('type'=>'select', 'class'=>'form-control','options' => Configure::read('Option.status'),'label' =>__('Situação')) ); ?>
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
