<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
</style>

<div class="imagens empresa">
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
			
			<h3>Galeria de imagens</h3>

			<section id="sect-edit-galeria_imagem" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">

					<!-- Banner -->
					<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border:0px solid red">
						<div class="row">
							<?php echo $this->element('forms/form-galeria_empresa', array('cache'=>false)); ?>
						</div>
					</div>

				</div>
			</section>

		</div>

	</div>
</div>