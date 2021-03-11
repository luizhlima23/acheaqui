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
			
			<h3>Nome e Descrição</h3>

			<section class="editar_empresa">
				<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>

					<!-- Nome -->
					<div class="row">
						<div class="form-group col-md-6">
							<?php echo $this->Form->input('nome', array('class' => 'form-control', 'label' => 'Nome', 'placeholder'=>false));?>
						</div>
					</div>

					<!-- Descrição -->
					<div class="row">
						<div class="form-group col-md-6">
							<?php 
								$alert_description = '<span class="fa fa-exclamation-circle text-info" data-toggle="tooltip" data-placement="right" title="Exibido apenas na página de anunciante."></span>';
								echo $this->Form->input('descricao', 
									array(
										'type'=>'text', 'class' => 'form-control', 
										'label' => 'Descrição '.$alert_description, 'placeholder'=>false, 
										'rows'=>10
									)
								);
							?>
							<small class="pull-right"><em class="text-muted">max 500 caracteres</em></small>
						</div>
					</div>

					<?php 
						# Configurações Padrões
						echo $this->Form->hidden('id');
					?>

					<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
					
					<?php echo $this->Html->link('cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

				<?php echo $this->Form->end(); ?>
			</section>

		</div>
	</div>
</div>