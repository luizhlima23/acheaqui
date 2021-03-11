<?php 
	echo $this->Html->script(
		array('bootstrap-select.min.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->css(array('bootstrap-select'), array('block' => 'inlineCss'));
?>
<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
</style>

<div class="contatos empresa">
	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<h2 class="page-header">
				<table width="100%">
					<tr>
						<td width="80%">
						<?php echo $this->Html->link($nome, array('controller'=>'contatos', 'action'=>'gerenciar_empresa', $contato_id)); ?>
						</td>
						<td width="20%"><?php echo $this->element('layout/gerenciar_btn', array('contato_id'=>$contato_id)); ?></td>
					</tr>
				</table>
			</h2>
			
			<h3>Endereço</h3>

			<section class="editar_empresa">
				<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>

					<!-- Endereço -->
					<div class="row">
						<div class="form-group required col-md-6">
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
					</div>
					<div class="row">
						<div class="form-group col-md-2">
							<?php echo $this->Form->input('end_num', array('class' => 'form-control', 'label' => 'Número'));?>
						</div>
						<div class="form-group col-md-4">
							<?php echo $this->Form->input('end_comp', array('class' => 'form-control', 'label' => 'Complemento', 'placeholder'=>'ex.: Qd x Apt x'));?>
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
										'empty'=>':: Selecione aqui',
										'multiple'=>false,
										'options'=>$bairros,
										'data-live-search'=>true,
										'required'=>false
									)
								);
							?>
						</div>
						<div class="form-group required col-md-4">
							<?php echo $this->Form->input('end_ref', array('class' => 'form-control', 'label' => 'Referência', 'placeholder'=>'ex.: próximo ao hospital municipal'));?>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-4">
							<?php
								echo $this->Form->input('cidade_id',
									array(
										'class' => 'form-control',
										'label'=>'Cidade',
										'empty'=>false,
										'multiple'=>false,
										'options'=>array(71=>'Cristalina - GO'),
										'disabled'=>true
									)
								);
							?>
						</div>
						<div class="form-group col-md-2">
							<?php echo $this->Form->input('cep', array('class' => 'form-control', 'label' => 'CEP', 'placeholder'=>false, 'value'=>'73850-000', 'disabled'=>true));?>
						</div>
					</div>

					<?php 
						# Configurações Padrões
						echo $this->Form->hidden('id');
					?>
					<br />

					<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
					
					<?php echo $this->Html->link('cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

				<?php echo $this->Form->end(); ?>
			</section>

		</div>
	</div>
</div>