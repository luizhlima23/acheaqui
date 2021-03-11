<?php echo $this->Html->css(array('/tags_input/bootstrap-tagsinput.css'), array('block' => 'inlineCss'));  ?>
<?php echo $this->Html->css(array('inline-tags_input.css'), array('block' => 'inlineCss'));  ?>
<?php echo $this->Html->script(array('inline-tags_input.js'), array('block' => 'inlineScripts'));  ?>

<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
</style>
<div class="etiquetas empresa">
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
			
			<h3>Etiquetas</h3>
			<?php if(isset($contratar)): ?>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<p>Você ainda não contratou o plano de Etiquetas:</p>
						<?php 
							echo $this->Html->link('contratar agora',
								array('controller'=>'contatos', 'action'=>'anunciar_empresa', $contato_id),
								array('class'=>'btn btn-primary')
							);
						?>
					</div>
				</div>
			<?php else: ?>
			<section id="sect-edit-etiquetas" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border:0px solid red">
				<div class="row">
					<?php echo $this->Form->create('Etiqueta', array('role'=>'form', 'url'=>array('controller'=>'etiquetas', 'action'=>'empresa', $contato_id))); ?>

						<!-- Tags -->
						<div class="form-group col-xs-12 col-sm-6 col-md-6" style="border:0px solid red">
							<div class="row">
								<p>Insira suas etiquetas separando-as com virgula:</p>
								<div id="wrap_tagsinput">
									<?php 
										echo $this->Form->input('tags', 
											array(
												'type'=>'text',
												'label'=>false,
												'placeholder'=>false,
												'div'=>false,
												'data-role'=>'EtiquetaTags'
											)
										);
									?>
								</div>
								<?php 
									$tags = $this->request->data['Etiqueta']['tags'];
									$tags_split = explode(',', $tags);
								?>
								<p id="tagsCount">Total: <?php echo count($tags_split);?> / 30</p>
								
								<br>

								<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
								
								<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>
							</div>
						</div>
						
						<!-- dicas -->
 						<div class="col-xs-12 col-sm-6 col-md-6">
 							<div class="dica">
								<?php echo $this->element('layout/dicas/dica-etiquetas'); ?>
 							</div>
						</div>					

						<?php 
							# Configurações Padrões
							echo $this->Form->hidden('id');
						?>

					<?php echo $this->Form->end(); ?>
				</div>
			</section>
			<?php endif; ?>
		</div>

	</div>
</div>