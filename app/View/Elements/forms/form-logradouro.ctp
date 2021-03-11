<div class="logradouro form">

	<?php echo $this->Form->create('Logradouro', array('role' => 'form')); ?>

		<!-- Tipo -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php
					echo $this->Form->input('end_tipo',
						array(
							'class' => 'form-control',
							'label' => 'Tipo',
							'default'=>'Rua',
							'options'=>$this->Formata->tiposLogradouro(),
							'type'=>'select',
							'multiple'=>false
						)
					);
				?>
			</div>
			<div class="form-group col-md-6">
				<?php echo $this->Form->input('descricao', array('class' => 'form-control', 'label' => 'Descrição', 'placeholder' => 'Descrição'));?>
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
			echo $this->Form->hidden('id');
		?>
		<br />

		<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>
