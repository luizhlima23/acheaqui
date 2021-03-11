<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
	.empresa table td{
		vertical-align: middle !important;
	}
	#div_etiqueta{}
	#div_banner-a{}
	.item{
		background: #ECEBEB;
		padding-top: 10px;
		padding-bottom: 10px;
		margin-bottom: 10px;
		min-height: 50px;
		vertical-align: middle;
	}
		.titulo{
			font-weight: bold;
			
		}
			#sect-servicos .titulo, #sect-dados .titulo{
				font-size: 16px;
			}
		.conteudo{}
		.options{}
		.titulo, .conteudo, .options{padding-top:5px;padding-bottom:5px;border:0px solid blue;}
</style>
<?php if(isset($data)): ?>

	<?php 
		$id = $data['Contato']['id'];;
		$nome = $data['Contato']['nome'];;
		
		# botão de editar
		$edit_title = '<i class="fa fa-edit"></i> editar';
		$edit_class = 'btn btn-md btn-default btn-block';
		$contrate_class = 'btn btn-md btn-success btn-block';
	?>
	<div class="empresa">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<h2 class="page-header">
					<table width="100%">
						<tr>
							<td width="80%"><?php echo $nome; ?></td>
							<td width="20%"><?php echo $this->element('layout/gerenciar_btn', array('contato_id'=>$id)); ?></td>
						</tr>
					</table>
				</h2>

				<section id="sect-servicos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						
						<h3>
							<i class="fa fa-chevron-right" style="font-size: 80%;"></i> 
							Meus serviços
						</h3>

						<div id="div_etiqueta" class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									Pacote de Etiquetas
								</div>
								<div class="conteudo col-xs-12 col-sm-8 col-md-8">
								<?php if(isset($data['Etiqueta'])): ?>

									<?php if($data['Etiqueta']['vigente']): ?>

										<em class="text-muted">
											<small>
												Início <?php echo $this->Formatacao->data($data['Etiqueta']['inicio']); ?>
											</small>
										</em>
										<br>
										<em>Expira em <?php echo $this->Formatacao->dataFormato($data['Etiqueta']['fim']); ?></em>

									<?php endif; ?>

								<?php endif; ?>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
								<?php 
									if(isset($data['Etiqueta']) and $data['Etiqueta']['vigente']){

										echo $this->Html->link($edit_title, 
											array('controller'=>'etiquetas', 'action'=>'empresa', 'contato_id'=>$id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									}
									else{

										echo $this->Html->link('Contratar', 
											array('controller'=>'anuncios', 'action'=>'anunciar_empresa', $id),
											array('class'=>$contrate_class, 'escape'=>false)
										);
									}
								?>
								</div>
							</div>
						</div>

						<div id="div_banner-a" class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									Banner Básico
								</div>
								<div class="conteudo col-xs-12 col-sm-4 col-md-4">
								<?php if(isset($data['BannerA'])): ?>

									<?php if($data['BannerA']['vigente']): ?>

										<em class="text-muted">
											<small>
												Início <?php echo $this->Formatacao->data($data['BannerA']['inicio']); ?>
											</small>
										</em>
										<br>
										<em>Expira em <?php echo $this->Formatacao->dataFormato($data['BannerA']['fim']); ?></em>

									<?php endif; ?>

								<?php endif; ?>
								</div>
								<div class="conteudo col-xs-12 col-sm-4 col-md-4">
								<?php if(isset($data['BannerA']['views'])): ?>

									<em>
										<small class="text-muted">
											Nº de exibições este mês: 
										</small>
										<?php echo $data['BannerA']['views']; ?>
									</em>
									<br>
									<em>
										<small class="text-muted">
											Mês anterior: 
										</small>
										<?php echo $data['BannerA']['views_ant']; ?>
									</em>
									<br>
									<em><small class="text-info">Em breve relatório completo</small></em>

								<?php endif; ?>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
								<?php 
									if(isset($data['BannerA']) and $data['BannerA']['vigente']){

										echo $this->Html->link($edit_title, 
											array('controller'=>'banners', 'action'=>'editar_banner_basico', 'contato_id'=>$id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									}
									else{

										echo $this->Html->link('Contratar', 
											array('controller'=>'anuncios', 'action'=>'anunciar_empresa', $id),
											array('class'=>$contrate_class, 'escape'=>false)
										);
									}
								?>
								</div>
							</div>
						</div>

						<div id="div_banner-c" class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									Banner Premium
								</div>
								<div class="conteudo col-xs-12 col-sm-4 col-md-4">
								<?php if(isset($data['BannerC'])): ?>

									<?php if($data['BannerC']['vigente']): ?>

										<em class="text-muted">
											<small>
												Início <?php echo $this->Formatacao->data($data['BannerC']['inicio']); ?>
											</small>
										</em>
										<br>
										<em>Expira em <?php echo $this->Formatacao->dataFormato($data['BannerC']['fim']); ?></em>

									<?php endif; ?>

								<?php endif; ?>
								</div>
								<div class="conteudo col-xs-12 col-sm-4 col-md-4">
								<?php if(isset($data['BannerC']['views'])): ?>

									<em>
										<small class="text-muted">
											Nº de exibições este mês: 
										</small>
										<?php echo $data['BannerC']['views']; ?>
									</em>
									<br>
									<em>
										<small class="text-muted">
											Mês anterior:
										</small>
										<?php echo $data['BannerC']['views_ant']; ?>
									</em>
									<br>
									<em><small class="text-info">Em breve relatório completo</small></em>

								<?php endif; ?>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
								<?php 
									if(isset($data['BannerC']) and $data['BannerC']['vigente']){

										echo $this->Html->link($edit_title, 
											array('controller'=>'banners', 'action'=>'editar_banner_premium', 'contato_id'=>$id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									}
									else{

										echo $this->Html->link('Contratar', 
											array('controller'=>'anuncios', 'action'=>'anunciar_empresa', $id),
											array('class'=>$contrate_class, 'escape'=>false)
										);
									}
								?>
								</div>
							</div>
						</div>

						<!-- links -->
						<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 text-left">
									<?php
										echo $this->Html->link('Meus pedidos',
											array('controller'=>'pedidos', 'action'=>'user_index'),
											array('class'=>'btn btn-link', 'escape'=>false)
										);
									?>
								</div>
							</div>
						</div>

					</div>
				</section>

				<section id="sect-dados" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						
						<h3 style="margin-top:40px">
							<i class="fa fa-chevron-right" style="font-size: 80%;"></i> 
							Dados da empresa
						</h3>

						<!-- nome/descricao -->
						<div class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									Nome e Descrição
								</div>
								<div class="conteudo col-xs-12 col-sm-8 col-md-8">
									<p style="font-size: 18px;">
										<?php echo $data['Contato']['nome']; ?>
									</p>
									<p>
										<em>
										<?php 
											if(!empty($data['Contato']['descricao'])){

												echo $data['Contato']['descricao'];
											}
											else{

												echo 'sem descrição';
											}
										?>
										</em>
									</p>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
									<?php 
										echo $this->Html->link($edit_title, 
											array('controller'=>'contatos', 'action'=>'editar_a', 'contato_id'=>$id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									?>
								</div>
							</div>
						</div>
						
						<!-- telefones -->
						<div class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									Fone(s)
								</div>
								<div class="conteudo col-xs-12 col-sm-8 col-md-8">
									<?php 
										if(!empty($data['Contato']['fone1'])){
											echo $this->Formata->fone($data['Contato']['fone1']).'<br>';
										}
										else{
											echo '<span class="text-danger">Nenhum telefone cadastrado</span>';
										}
										
										if(!empty($data['Contato']['fone2']))
											echo $this->Formata->fone($data['Contato']['fone2']).'<br>';
										
										if(!empty($data['Contato']['fone3']))
											echo $this->Formata->fone($data['Contato']['fone3']).'<br>';

										if(!empty($data['Contato']['fone4']))
											echo $this->Formata->fone($data['Contato']['fone4']).'<br>';
									?>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
									<?php 
										echo $this->Html->link($edit_title, 
											array('controller'=>'contatos', 'action'=>'editar_telefone', 'contato_id'=>$id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									?>
								</div>
							</div>
						</div>
						
						<!-- endereço -->
						<div class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									Endereço
								</div>
								<div class="conteudo col-xs-12 col-sm-8 col-md-8">
									<?php
										if(!empty($data['Contato']['end_completo'])){

											echo $data['Contato']['end_completo'];
										}
										else{

											echo '<span class="text-danger">Nenhum endereço cadadstrado</span>';
										}
									?>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
									<?php 
										echo $this->Html->link($edit_title, 
											array('controller'=>'contatos', 'action'=>'editar_endereco', 'contato_id'=>$id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									?>
								</div>
							</div>
						</div>
						
						<?php if($data['Contato']['relevancia'] > 0): ?>
						<!-- fotos da empresa -->
						<div class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									Fotos
								</div>
								<div class="conteudo col-xs-12 col-sm-8 col-md-8">
									<?php 
										$galeria = $data['ContatoImagem'];
										if(!empty($galeria)):

											echo '<div class="row">';
											foreach ($galeria as $k=>$d) {
												
												if(!empty($d['imagem'])){

													echo '<div class="col-md-2">';
													echo $this->Html->image('/'.$d['imagem'],
														array('class'=>'img-responsive')
													);
													echo '</div><br class="visible-xs">';
												}
											}
											echo '</div>';
									?>								
									<?php else: ?>

										<p><em>Nenhuma imagem cadastrada</em></p>

									<?php endif; ?>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
									<?php 
										echo $this->Html->link($edit_title, 
											array('controller'=>'uploads', 'action'=>'galeria_empresa', $id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									?>
								</div>
							</div>
						</div>
						<?php endif; ?>

						<!-- email e website -->
						<div class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									E-mail e Website
								</div>
								<div class="conteudo col-xs-12 col-sm-8 col-md-8">
									<p>
										<span class="fa fa-envelope"></span>
										<?php 
											echo (!empty($data['Contato']['email']))? $data['Contato']['email'] : '';
										?>
									</p>
									<p>
										<span class="fa fa-globe"></span>
										<?php 
											echo (!empty($data['Contato']['url_website']))? $data['Contato']['url_website'] : '';
										?>
									</p>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
									<?php 
										echo $this->Html->link($edit_title, 
											array('controller'=>'contatos', 'action'=>'editar_urls', 'contato_id'=>$id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									?>
								</div>
							</div>
						</div>

						<!-- redes sociais -->
						<div class="item col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="titulo col-xs-12 col-sm-2 col-md-2">
									Redes sociais
								</div>
								<div class="conteudo col-xs-12 col-sm-8 col-md-8">
									<p>
										<span class="fa fa-facebook-official"></span>
										<?php 
											echo (!empty($data['Contato']['url_facebook']))? $data['Contato']['url_facebook'] : '-';
										?>
									</p>
									<p>
										<span class="fa fa-twitter"></span>
										<?php 
											echo (!empty($data['Contato']['url_facebook']))? $data['Contato']['url_facebook'] : '-';
										?>
									</p>
									<p>
										<span class="fa fa-google-plus"></span>
										<?php 
											echo (!empty($data['Contato']['url_facebook']))? $data['Contato']['url_facebook'] : '-';
										?>
									</p>
								</div>
								<div class="options col-xs-12 col-sm-2 col-md-2">
									<?php 
										echo $this->Html->link($edit_title, 
											array('controller'=>'contatos', 'action'=>'editar_urls', 'contato_id'=>$id),
											array('class'=>$edit_class, 'escape'=>false)
										);
									?>
								</div>
							</div>
						</div>

						<!-- configuração -->
						<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 pai">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 text-right">
									<br>
									<?php
										$title_des = 'Após confirmar a desistência desta empresa, você não poderá mais gerencia-la e outras pessoas poderão reivindica-la.';
										$ico_info_des = '<i class="fa fa-info"></i>';
										echo $this->Html->link('não sou mais o responsável',
											array('controller'=>'contatos', 'action'=>'desistir_empresa', 'id'=>$id),
											array(
												'class'=>'text-muted', 'escape'=>false,
												'data-toggle'=>'tooltip', 'data-placement'=>'left', 
												'title'=>$title_des
											)
										);
									?>
								</div>
							</div>
						</div>

					</div>
				</section>

			</div>
		</div>
	</div>
<?php endif; ?>