<?php 
	echo $this->Html->script(array('inline-contato_informal-checkbox.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('inline-toggle_checkbox.js', 'inline-toggle_endereco.js', 'inline-input_mask.js', 'bootstrap-select.min.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('/js/inputmask/inputmask.js', '/js/inputmask/inputmask.date.extensions.js', '/js/inputmask/inputmask.phone.extensions.js', '/js/inputmask/jquery.inputmask.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->css(array('bootstrap-select'), array('block' => 'inlineCss'));
?>

<div class="contato form">

	<p class="pull-right">
		<strong style="color:red">*</strong>
		<small><i> Campos obrigatórios</i></small>
	</p>
	
	<?php echo $this->Form->create('Contato', array('url'=>array('controller'=>'contatos', 'action'=>'cadastrar_empresa', 'option'=>$option))); ?>
		
		<h3 class="text-orange">NOME</h3>
		<!-- Nome -->
		<div class="row">
			<div class="form-group required col-md-6">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label' => 'Nome da Empresa (nome fantasia)', 'placeholder'=>'Nome da empresa ou negócio'));?>
			</div>
		</div>

		<h3 class="text-orange">TELEFONE</h3>
		<!-- Telefone -->
		<div class="row">
			<div class="form-group col-md-1">
				<?php echo $this->Form->input('ddd', array('class' => 'form-control', 'label' => 'DDD', 'placeholder'=>false, 'value'=>'61', 'disabled'));?>
			</div>
			<div class="form-group col-md-3">
				<?php echo $this->Form->input('fone1', array('id'=>'toggleFone', 'class' => 'form-control phone-mask', 'label' => 'Telefone', 'placeholder'=>false));?>
			</div>
		</div>

		<h3 class="text-orange">ENDEREÇO</h3>
		<!-- Endereço -->
		<div class="row">
			<div class="form-group col-md-6 checkbox text-left" style="margin-left:20px">
				<label for="toggleEndereco" style="padding-left:0px;" class="text-orange" data-toggle="tooltip" data-placement="right" title="Marque esta opção caso a sua empresa/negócio não tenha endereço fisico.">
				<?php
					echo $this->Form->input('Form.endereco',
						array(
							'id'=>'toggleEndereco',
							'type'=>'checkbox',
							'label'=>false,
							'hiddenField' => true,
							'div'=>false, 'class'=>'text-left',
							'value' => 'nao',
							'data-toggle-id'=>'#toogleDivEndereco'
						)
					);
				?>
				Não possui endereço físico </label>
			</div>
		</div>
		<div id="toogleDivEndereco">
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
								'required'=>false
							)
						);
					?>
				</div>
				<div class="form-group col-md-2">
					<?php echo $this->Form->input('end_num', array('class' => 'form-control', 'label' => 'Número'));?>
				</div>
				<div class="form-group col-md-4">
					<?php echo $this->Form->input('end_comp', array('class' => 'form-control', 'label' => 'Complemento', 'placeholder'=>'ex.: Qd x Apt x'));?>
				</div>
			</div>

			<!-- localização -->
			<div class="row">
				<div class="form-group required col-md-3">
					<?php
						echo $this->Form->input('bairro_id',
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
				<div class="form-group col-md-4">
					<?php echo $this->Form->input('end_ref', array('class' => 'form-control', 'label' => 'Referência', 'placeholder'=>'ex.: próximo ao hospital municipal'));?>
				</div>
			</div>
		</div>
		
		<h3 class="text-orange">RESPONSÁVEL</h3>
		<?php if($option!='completo'): ?>
		<div class="row">
			<div class="form-group col-md-6 checkbox text-left" style="margin-left:20px">
				<label for="toggleCheck" style="padding-left:0px;" class="text-orange" data-toggle="tooltip" data-placement="top" title="O responsável pela empresa pode alterar os dados de cadastro a qualquer momento no painel de controle.">
				<?php
					echo $this->Form->input('responsavel',
						array(
							'id'=>'toggleCheck',
							'type'=>'checkbox',
							'label'=>false,
							'hiddenField' => true,
							'div'=>false, 'class'=>'text-left',
							'value' => true,
							'data-toggle-id'=>'#toogleDiv'
						)
					);
				?>
				Você é o responsável pela empresa/negócio?</label>
			</div>
		</div>
		<?php else: ?>
			<?php 
				echo $this->Form->input('responsavel',
					array(
						'id'=>'toggleCheck',
						'type'=>'checkbox',
						'label'=>false,
						'hiddenField' => true,
						'div'=>false, 'class'=>'text-left',
						'value' => true,
						'data-toggle-id'=>'#toogleDiv',
						'checked'=>true,
						'style'=>'display:none;'
					)
				);
			?>
		<?php endif; ?>

		<div class="row" id="toogleDiv">
			<div class="col-xs-12 col-sm-12 col-md-12">
					
				<div class="row">
					<div class="col-md-12">
						<h4>Dados necessários:</h4>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 well">
					
					<?php 
						echo $this->Form->hidden('Cadastro.id');
						echo $this->Form->hidden('Cadastro.status', array('value'=>1));
					?>

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
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-6">
							<small class="text-muted">
								Clicando no botão concluir, você confirma que possui autoridade para reivindicar essa empresa e concorda com os 
								<button type="button" class="btn-link" data-toggle="modal" data-target="#ModalTermos">
									Termos de uso
								</button>
								do site.
							</small>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php 
			# Configurações Padrões
			echo $this->Form->hidden('status', array('value'=>1));
			echo $this->Form->hidden('cidade_id', array('value'=>71));
			echo $this->Form->hidden('cep', array('value'=>'73850000'));
			echo $this->Form->hidden('User.id');
		?>

		<br>

		<?php echo $this->Form->button(__('Concluir'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

	<?php echo $this->Form->end(); ?>
	<?php echo $this->fetch('postLink'); ?>

</div>

<!-- Modal Termos -->
<?php echo $this->element('layout/termos-uso_modal');?>