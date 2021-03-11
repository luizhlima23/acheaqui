<?php 
	echo $this->Html->script(array('inline-contato_informal-checkbox.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('inline-input_mask.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('/js/inputmask/inputmask.js', '/js/inputmask/inputmask.date.extensions.js', '/js/inputmask/inputmask.phone.extensions.js', '/js/inputmask/jquery.inputmask.js'), 
		array('block' => 'inlineScripts')
	);
?>
<div class="contato form">
	
	<?php echo $this->Form->create('Contato', array('url' => array('prefix'=>false, 'controller' => 'contatos', 'action' => 'reivindicar_empresa', $id))); ?>
		
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
					
				<!-- Razão social e CNPJ -->
				<div class="row">
					<div class="form-group required col-md-5">
						<?php echo $this->Form->input('Contato.razao_social', array('class' => 'form-control disableOnCheck', 'label' => 'Razão social', 'placeholder'=>false));?>
					</div>
					<div class="form-group required col-md-3">
						<?php echo $this->Form->input('Contato.cpf_cnpj', array('class' => 'form-control cnpj-mask disableOnCheck', 'label' => 'CNPJ', 'placeholder'=>false, 'maxlength'=>'18'));?>
					</div>
					<div class="form-group col-md-2 checkbox text-left" style="margin-left:20px">
						<br>
						<label for="ContatoInformal" style="padding-left:0px;" class="text-muted" data-toggle="tooltip" data-placement="top" title="">
							<?php 
								echo $this->Form->input('informal',
									array(
										'type'=>'checkbox',
										'label'=>false,
										'hiddenField' => true,
										'div'=>false, 'class'=>'text-left',
										'value' => true,
										'class'=>'btnDisable',
									)
								);
							?>
							Meu negócio é informal
						</label>
					</div>
				</div>

				<br>

				<!-- Nome -->
				<div class="row">
					<div class="form-group required col-md-3">
						<?php echo $this->Form->input('User.nome', array('class' => 'form-control', 'label' => 'Seu nome', 'placeholder'=>'seu nome'));?>
					</div>
					<div class="form-group required col-md-5">
						<?php echo $this->Form->input('User.sbnome', array('class' => 'form-control', 'label' => 'Sobrenome', 'placeholder'=>false));?>
					</div>
				</div>

				<!-- Email e Telefone -->
				<div class="row">
					<div class="form-group required col-md-3">
						<?php echo $this->Form->input('Cadastro.telefone', array('class' => 'form-control ddd_phone-mask', 'label' => 'Telefone', 'placeholder'=>false));?>
					</div>
					<div class="form-group required col-md-6">
						<?php echo $this->Form->input('User.email', array('class' => 'form-control', 'label' => 'E-mail', 'placeholder'=>false));?>
					</div>
				</div>

				<!-- Cargo e CPF -->
				<div class="row">
					<div class="form-group required col-md-3">
						<?php echo $this->Form->input('Contato.cargo_responsavel', array('class' => 'form-control', 'label' => 'Cargo na empresa', 'placeholder'=>false));?>
					</div>
					<div class="form-group required col-md-3">
						<?php 
							echo $this->Form->input('Cadastro.cpf', 
								array(
									'class'=>'form-control cpf-mask',
									'placeholder' => '',
									'label'=>'CPF',
									'maxlength'=>'14'
								)
							);
						?>
					</div>
				</div>

			</div>
		</div>
		
		<?php 
			echo $this->Form->input('Cadastro.id');

			echo $this->Form->hidden('Contato.id', array('value'=>$id));
		?>
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-6">
				<small class="text-muted">
					Clicando no botão concluir, você confirma que possui autoridade para reivindicar essa empresa e concorda com os 
					<button type="button" class=" btn-link" data-toggle="modal" data-target="#ModalTermos">
						Termos de uso
					</button>
					do site.
				</small>
			</div>
		</div>
		<br>

		<?php echo $this->Form->button(__('Concluir'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
		<?php echo $this->Html->link('Voltar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>

<!-- Modal Termos -->
<?php echo $this->element('layout/termos-uso_modal');?>