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
			
			<section class="editar_empresa">
				<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>

					<h3>E-mail e Website </h3>

					<!-- E-mail -->
					<div class="row">
						<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="input-group">
								<div class="input-group-addon"><span class="fa fa-envelope"></span></div>
								<?php 
									echo $this->Form->input('email', 
										array('class'=>'form-control', 'label'=>false, 'placeholder'=>'E-mail', 'div'=>false)
									);
								?>
							</div>
						</div>
					</div>

					<!-- Website -->
					<div class="row">
						<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="input-group">
								<div class="input-group-addon"><span class="fa fa-globe"></span></div>
								<?php 
									echo $this->Form->input('url_website', 
										array('class'=>'form-control', 'label'=>false, 'placeholder'=>'Website', 'div'=>false)
									);
								?>
							</div>
						</div>
					</div>

					<h3>Redes sociais</h3>

					<!-- Facebook -->
					<div class="row">
						<div class="form-group col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="input-group">
								<div class="input-group-addon"><span class="fa fa-facebook-official"></span></div>
								<?php 
									echo $this->Form->input('url_facebook', 
										array('class'=>'form-control', 'label'=>false, 'placeholder'=>'Facebook', 'div'=>false)
									);
								?>
							</div>
						</div>
					</div>

					<!-- Twitter -->
					<div class="row">
						<div class="form-group col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="input-group">
								<div class="input-group-addon"><span class="fa fa-twitter"></span></div>
								<?php 
									echo $this->Form->input('url_twitter', 
										array('class'=>'form-control', 'label'=>false, 'placeholder'=>'Twitter', 'div'=>false)
									);
								?>
							</div>
						</div>
					</div>

					<!-- Google Plus -->
					<div class="row">
						<div class="form-group col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="input-group">
								<div class="input-group-addon"><span class="fa fa-google-plus"></span></div>
								<?php 
									echo $this->Form->input('url_google', 
										array('class'=>'form-control', 'label'=>false, 'placeholder'=>'Google+', 'div'=>false)
									);
								?>
							</div>
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