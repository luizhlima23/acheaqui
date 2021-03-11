<style type="text/css">
	.contato #CorrecaoMotivo{
		max-height: 350px;
		resize: vertical;
	}
</style>

<div class="contato form well">
	
	<p class="pull-right">
		<strong style="color:red">*</strong>
		<small><i> Campos obrigatórios</i></small>
	</p>

	<?php echo $this->Form->create('Correcao'); ?>
		
		<!-- resultado -->
		<div class="row">
			<div class="form-group required col-xs-12 col-sm-6 col-md-5 col-lg-5">
				<?php echo $this->Form->input('resultado', array('type'=>'select', 'class'=>'boxToggle form-control','options' =>Configure::read('Option.correcao'),'label' =>false, 'data-toggle-id'=>'#boxCorrecao', 'data-toggle-value'=>'AC') ); ?>
			</div>
		</div>
		
		<div id="boxCorrecao">
			
			<?php 
				$fields = $data_after['Contato'];
				$this->request->data['Contato'] = $data_after['Contato'];
			?>

			<?php if(array_key_exists('nome', $fields)): ?>
				<!-- Nome -->
				<div class="row">
					<div class="form-group required col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<?php echo $this->Form->input('Contato.nome', array('class' => 'form-control', 'label' => 'Nome da Empresa', 'placeholder'=>'Nome da empresa ou negócio'));?>
					</div>
				</div>
			<?php endif; ?>

			<?php if(array_key_exists('fone1', $fields)): ?>
				<!-- Telefone -->
				<div class="row">
					<div class="form-group col-xs-8 col-sm-4 col-md-4 col-lg-4">
						<?php echo $this->Form->input('Contato.fone1', array('class' => 'form-control phone-mask', 'label' => 'Telefone', 'placeholder'=>false));?>
					</div>
				</div>
			<?php endif; ?>

			<?php if(array_key_exists('logradouro_id', $fields)): ?>
				<!-- Endereço -->
				<div class="row">
					<div class="form-group col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<?php
							echo $this->Form->input('Contato.logradouro_id',
								array(
									'class' => 'form-control selectpicker',
									'label'=>'Logradouro (Rua)',
									'empty'=>':: Selecione aqui',
									'multiple'=>false,
									'options'=>$logradouros,
									'data-live-search'=>true,
									'required'=>false
								)
							);
						?>
					</div>
				</div>
			<?php endif; ?>

			<!-- número, complemento -->
			<div class="row">
				<?php if(array_key_exists('end_num', $fields)): ?>
				<div class="form-group col-xs-4 col-sm-3 col-md-3 col-lg-3">
					<?php echo $this->Form->input('Contato.end_num', array('class' => 'form-control', 'label' => 'Número'));?>
				</div>
				<?php endif; ?>
				<?php if(array_key_exists('end_comp', $fields)): ?>
				<div class="form-group col-xs-8 col-sm-5 col-md-4 col-lg-4">
					<?php echo $this->Form->input('Contato.end_comp', array('class' => 'form-control', 'label' => 'Complemento', 'placeholder'=>'ex.: Qd x Apt x'));?>
				</div>
				<?php endif; ?>
			</div>

			<!-- bairro, referencia -->
			<div class="row">
				<?php if(array_key_exists('bairro_id', $fields)): ?>
				<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
					<?php
						echo $this->Form->input('Contato.bairro_id',
							array(
								'class' => 'form-control selectpicker',
								'label'=>'Bairro',
								'empty'=>':: Selecione aqui',
								'multiple'=>false,
								'options'=>$bairros,
								'data-live-search'=>true,
								'required'=>false
							)
						);
					?>
				</div>
				<?php endif; ?>
				<?php if(array_key_exists('end_ref', $fields)): ?>
				<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<?php echo $this->Form->input('Contato.end_ref', array('class' => 'form-control', 'label' => 'Referência', 'placeholder'=>'ex.: próximo ao hospital municipal'));?>
				</div>
				<?php endif; ?>
			</div>

			<?php if(array_key_exists('razao_social', $fields)): ?>
				<!-- Razão social -->
				<div class="row">
					<div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php echo $this->Form->input('Contato.razao_social', array('class' => 'form-control', 'label' => 'Razão social', 'placeholder'=>false));?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(array_key_exists('cpf_cnpj', $fields)): ?>
				<!-- CPF / CNPJ -->
				<div class="row">
					<div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php echo $this->Form->input('Contato.cpf_cnpj', array('class' => 'form-control', 'label' => 'CPF / CNPJ', 'placeholder'=>false, 'maxlength'=>'18'));?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(array_key_exists('cargo_responsavel', $fields)): ?>
				<!-- Cargo -->
				<div class="row">
					<div class="form-group required col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php echo $this->Form->input('Contato.cargo_responsavel', array('class' => 'form-control', 'label' => 'Cargo', 'placeholder'=>'Cargo na empresa'));?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if(array_key_exists('observacao', $fields)): ?>
				<!-- Obervação -->
				<div class="row">
					<div class="form-group required col-xs-12 col-sm-12 col-md-10 col-lg-10">
						<?php echo $this->Form->input('Contato.observacao', array('class' => 'form-control input-lg no-resize', 'placeholder' => 'algum comentário sobre a empresa?', 'label'=>false, 'type'=>'textarea', 'rows'=>2));?>
					</div>
				</div>
			<?php endif; ?>
			
		</div>

		<!-- motivo -->
		<div class="row">
			<div class="form-group required col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="inp_wrapper">
					<?php 
						echo $this->Form->input('motivo', 
							array(
								'class'=>'form-control', 'label'=>false, 'placeholder' =>'Motivo',
								'row'=>4, 'onkeyup'=>'InputCharsLimit(this.value,500, \'counter\')',
								'maxlength'=>500
							)
						);
					?>
					<div id="count_wrap">
						<small><i id="counter"></i></small>
					</div>
				</div>
			</div>
		</div>

		<?php 
			# Configurações Padrões
		?>
		<br />

		<?php echo $this->Form->button(__('Concluir'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
		
		<?php echo $this->Html->link('Cancelar', array('controller'=>'correcoes', 'action'=>'index'), array('class'=>'btn btn-link')); ?>
			

	<?php echo $this->Form->end(); ?>

</div>