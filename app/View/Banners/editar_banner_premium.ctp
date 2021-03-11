<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
</style>

<div class="banners empresa">
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
			
			<h3>Banner Premium</h3>

			<?php if(isset($contratar)): ?>
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<p>Você ainda não contratou o plano do banner premium:</p>
						<?php 
							echo $this->Html->link('contratar agora',
								array('controller'=>'contatos', 'action'=>'anunciar_empresa', $contato_id),
								array('class'=>'btn btn-primary')
							);
						?>
					</div>
				</div>

			<?php else: ?>

			<section id="sect-edit-banner_premium" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">

					<!-- Banner -->
					<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6" style="border:0px solid red">
						<div class="row">
							<?php echo $this->element('forms/form-banner_c', array('dados'=>$this->request->data['BannerC'])); ?>
						</div>
					</div>

					<!-- dicas -->
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="dica">
						<?php echo $this->element('layout/dicas/dica-banners'); ?>
						</div>
					</div>					

				</div>
			</section>

			<?php endif; ?>

		</div>

	</div>
</div>