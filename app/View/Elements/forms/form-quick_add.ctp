<div class="contato form">

	<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>

		<div class="row">
			<div class="form-group required col-md-6">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label'=>'Nome', 'placeholder' => 'ex.: Mercado Silva'));?>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label for="ContatoFone1">Telefone</label>
				<div class="input-group">
					<div class="input-group-addon">(61)</div>
					<?php echo $this->Form->input('fone1', array('class' => 'form-control', 'label' => false, 'placeholder'=>false, 'maxLength'=>8, 'value'=>'3612', 'required'=>false));?>			
				</div>
			</div>
		</div>

		<!-- Endereço -->
		<div class="row">
			<div class="form-group required col-md-4">
				<?php
					echo $this->Form->input('logradouro_id',
						array(
							'class' => 'form-control selectpicker',
							'label'=>'Logradouro (Rua)',
							'empty'=>':: Selecione aqui',
							'multiple'=>false,
							'options'=>$logradouros,
							'data-live-search'=>true,
							'default'=>$defaults['logradouro_id'],
							'required'=>false
						)
					);
					echo $this->Html->link('+ cadastrar logradouro',
						array('#'),
						array('class'=>'btn-link pull-right')
					);
				?>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('end_num', array('class' => 'form-control', 'label'=>'Número', 'placeholder' => false));?>
			</div>
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('end_comp', array('class' => 'form-control', 'label'=>'Complemento', 'placeholder' => 'ex.: Qd xx Lt. xx'));?>
			</div>
		</div>

		<!-- localização -->
		<div class="row">
			<div class="form-group required col-md-4">
				<?php
					echo $this->Form->input('bairro_id', 
						array(
							'class' => 'form-control selectpicker', 
							'label'=>'Bairro', 
							'empty'=>':: Selecione', 
							'data-live-search'=>true, 
							'default'=>$defaults['bairro_id'], 
							'options'=>$bairros, 'required'=>false
						)
					);
					echo $this->Html->link('+ cadastrar bairro',
						array('#'),
						array('class'=>'btn-link pull-right')
					);

				?>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-5">
				<?php echo $this->Form->input('end_ref', array('class' => 'form-control', 'label'=>'Referência', 'placeholder' => 'ex.: próximo ao hospital municipal', 'required'=>false));?>
			</div>					
		</div>

		<!-- Características -->
		<?php 
			echo $this->Form->hidden('cidade_id', array('value'=>71));
			echo $this->Form->hidden('status', array('value'=>1));
		?>

		<br />
		
		<?php echo $this->Form->button(__('Cadastrar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

		<?php echo $this->Html->link('Voltar para Lista', array('controller'=>'contatos', 'action'=>'index'), array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>
