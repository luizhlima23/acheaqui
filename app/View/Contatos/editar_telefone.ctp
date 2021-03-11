<?php 
	echo $this->Html->script(
		array('inline-input_mask.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('/js/inputmask/inputmask.js', '/js/inputmask/inputmask.date.extensions.js', '/js/inputmask/inputmask.phone.extensions.js', '/js/inputmask/jquery.inputmask.js'), 
		array('block' => 'inlineScripts')
	);
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
			
			<h3>Telefones</h3>

			<section class="editar_empresa">
				<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>

					<!-- Principal -->
					<div class="row">
						<div class="form-group text-muted col-xs-3 col-sm-2 col-md-1 col-lg-1">
							<?php echo $this->Form->input('ddd1', array('class' => 'form-control', 'label' => 'DDD', 'placeholder'=>false, 'value'=>'61', 'disabled'));?>
						</div>
						<div class="form-group col-xs-9 col-sm-3 col-md-2 col-lg-2">
							<?php echo $this->Form->input('fone1', array('class' => 'form-control phone-mask', 'label' => 'Telefone Principal', 'placeholder'=>false));?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="form-group text-muted col-xs-3 col-sm-2 col-md-1 col-lg-1">
							<?php echo $this->Form->input('ddd2', array('class' => 'form-control', 'label' => false, 'placeholder'=>false, 'value'=>'61', 'disabled'));?>
						</div>
						<div class="form-group required col-xs-9 col-sm-3 col-md-2 col-lg-2">
							<?php echo $this->Form->input('fone2', array('class' => 'form-control phone-mask', 'label' => false, 'placeholder'=>'telefone 2'));?>
						</div>
					</div>
					<div class="row">
						<div class="form-group text-muted col-xs-3 col-sm-2 col-md-1 col-lg-1">
							<?php echo $this->Form->input('ddd3', array('class' => 'form-control', 'label' => false, 'placeholder'=>false, 'value'=>'61', 'disabled'));?>
						</div>
						<div class="form-group required col-xs-9 col-sm-3 col-md-2 col-lg-2">
							<?php echo $this->Form->input('fone3', array('class' => 'form-control phone-mask', 'label' => false, 'placeholder'=>'telefone 3'));?>
						</div>
					</div>
					<div class="row">
						<div class="form-group text-muted col-xs-3 col-sm-2 col-md-1 col-lg-1">
							<?php echo $this->Form->input('ddd4', array('class' => 'form-control', 'label' => false, 'placeholder'=>false, 'value'=>'61', 'disabled'));?>
						</div>
						<div class="form-group required col-xs-9 col-sm-3 col-md-2 col-lg-2">
							<?php echo $this->Form->input('fone4', array('class' => 'form-control phone-mask', 'label' => false, 'placeholder'=>'telefone 4'));?>
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