<?php echo $this->Html->css(array('inline-detalhes', 'inline-social_buttons'), array('block' => 'inlineCss')); ?>
<?php if(isset($contato)): ?>

	<?php 
		# Parâmetros da view
		$icon_cfg = '<i class="fa fa-wrench fa-1x"></i>';
		$gerenciar = (isset($gerenciar))? $gerenciar : false;
	?>
	<div id="Perfil">

		<?php if(!empty($contato)): ?>
			
			<section id="sect-header">
				
				<br>

				<!-- CAPA -->
				<div id="capa" class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
						<div id="div-capa" class="row">
							<?php 
								echo $this->Html->image('layout/AONDE-CAPA-em-breve.png', 
									array('class'=>'capa-img responsive-img')
								);
							?>
							<div id="capa-header" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<?php
									$id = $contato['Contato']['id'];
									$display = $contato['Contato']['nome'];
									$options = array(
										'texto'=>'<i class="fa fa-ellipsis-v fa-2x btn-icon_white"></i>',
										'class'=>'item-options',
										'caret'=>false
									);
									$ico_edit = '<i class="fa fa-pencil nav-icon"></i>';
									$ico_report = '<i class="fa fa-	n nav-icon"></i>';
									$ico_flag = '<i class="fa fa-flag nav-icon"></i>';
									$ico_close = '<i class="fa fa-window-close nav-icon"></i>';
									$ico_ban = '<i class="fa fa-ban nav-icon"></i>';
									$menu = array(
										$ico_edit.__('corrigir') => array(
											'tipo'=>'link', 
											'url'=>array('controller'=>'correcoes', 'action'=>'sugerir_correcao', 'contato_id'=>$id)
										),
										$ico_ban.__('denunciar') => array(
											'tipo'=>'link', 
											'url'=>array('controller'=>'correcoes', 'action'=>'denunciar', 'contato_id'=>$id)
										),
										$ico_close.__('não existe') => array(
											'tipo'=>'link', 
											'url'=>array('controller'=>'correcoes', 'action'=>'informar_inexistencia', 'contato_id'=>$id)
										),
									);

									echo $this->element('layout/btn-dropdown', array('options'=>$options, 'menu'=>$menu));
								?>
							</div>
							<div id="capa-footer" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<h1 class="title">
									<?php echo $this->Formata->nome($contato['Contato']['nome']); ?>
								</h1>
							</div>
						</div>
					</div>
				</div>

				
				
				<!-- DESCRIÇÃO -->
				<?php if(!empty($contato['Contato']['descricao']) or $gerenciar): ?>
				<div id="descricao" class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
						<?php
							if (!empty($contato['Contato']['descricao'])) {
							 	
								echo $this->Html->tag('p', $contato['Contato']['descricao']);
							}
							else{

								echo $this->Html->tag('p', 'Descrição da empresa não cadastrada');
							} 
						?>	 
						<?php
							if($gerenciar){

								echo $this->Html->link($icon_cfg, 
									array('controller'=>'contatos', 'action'=>'editar_a', $contato['Contato']['id']),
									array('class'=>'btn btn-lg btn-edit', 'escape'=>false)
								);
							}
						?>
					</div>

				</div>
				<?php endif; ?>
			</section>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
					<hr class="row">
				</div>
			</div>

			
			<!-- ETIQUETAS -->
			<?php if(!empty($contato['Etiqueta']['tags']) OR $gerenciar): ?>
			<section id="sect-etiquetas">
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
						<div class="row">
							
							<!-- icon -->
							<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 text-center">
								<div class="row"><i class="fa fa-tags fa-2x"></i></div>
							</div>
							
							<!-- etiquetas (xs, sm, md) -->
							<div class="col-xs-10 col-sm-11 col-md-11 col-lg-11 clear-left">
								<?php if(!empty($contato['Etiqueta']['tags'])): ?>

									<div class="div-tags">
										<?php echo $this->element('layout/contatos/etiqueta', array('tags'=>$contato['Etiqueta']['tags'], 'limite'=>30)); ?>
									</div>
									<?php
										if($gerenciar){

											echo $this->Html->link($icon_cfg, 
												array('controller'=>'etiquetas', 'action'=>'empresa', 'contato_id'=>$contato['Contato']['id']),
												array('class'=>'btn btn-lg btn-edit', 'escape'=>false)
											);
										}
									?>

								<?php elseif($gerenciar): ?>

									<?php 
										echo $this->Html->link('Insira suas etiquetas', 
											array('controller'=>'etiquetas', 'action'=>'empresa', 'contato_id'=>$contato['Contato']['id']),
											array('class'=>'btn-block btn-yellow', 'escape'=>false)
										).'<br>';
									?>

								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>

			</section>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
					<hr class="row">
				</div>
			</div>
			<?php endif; ?>

			
			<!-- BANNER BÁSICO -->
			<?php if(!empty($contato['BannerA']['imagem']) OR $gerenciar): ; ?>
			<section id="sect-banner_basico">
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
						<div class="row">
							
							<!-- banner básico (xs, sm, md) -->
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<?php 
									if(!empty($contato['BannerA']['imagem'])){

										echo $this->element('layout/contatos/banner', array('data'=>$contato['BannerA'], 'model'=>'BannerA'));
										
										if($gerenciar){

											echo $this->Html->link($icon_cfg, 
												array('controller'=>'banners', 'action'=>'editar_banner_basico', 'contato_id'=>$contato['Contato']['id']),
												array('class'=>'btn btn-lg btn-edit', 'escape'=>false)
											);
										}
									}
									elseif($gerenciar){

										echo $this->Html->link('Insira seu banner', 
											array('controller'=>'banners', 'action'=>'editar_banner_basico', 'contato_id'=>$contato['Contato']['id']),
											array('class'=>'btn-block btn-yellow', 'escape'=>false)
										);
									}
								?>
							</div>

						</div>
					</div>
				</div>

			</section>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
					<hr class="row">
				</div>
			</div>
			<?php endif; ?>


			<!-- LOCAL / ENDEREÇO -->
			<?php 
				# Endereço
				$local = (!empty($contato['Contato']['endereco']))? $this->Formata->endereco($contato['Contato']['endereco']) : '';

				# Referência
				$local .= (!empty($contato['Contato']['end_ref']))? '<small><em> ( '.$this->Formata->endereco($contato['Contato']['end_ref']).' )</em></small>' : '';

				# Cidade e Sigla de Estado
				$local .= (!empty($contato['Cidade']['nome']))? '<br>'.$contato['Cidade']['nome'].'/'.$contato['Cidade']['estado_sigla'] : '';

				# CEP
				$local .= (!empty($contato['Contato']['cep']))? ' - CEP '.$contato['Contato']['cep'] : '';
			?>
			<?php if(!empty($local OR $gerenciar)): ?>
			<section id="sect-endereco">
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
						<div class="row">
							
							<!-- icon -->
							<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 text-center">
								<div class="row"><i class="fa fa-map-marker fa-2x"></i></div>
							</div>
							
							<!-- local (xs, sm, md) -->
							<div class="col-xs-10 col-sm-11 col-md-11 col-lg-11 clear-left">
								<?php if(!empty($local)): ?>

									<div class="div-endereco">
										<?php echo $local; ?>
									</div>
									<?php
										if($gerenciar){

											echo $this->Html->link($icon_cfg, 
												array('controller'=>'contatos', 'action'=>'editar_endereco', $contato['Contato']['id']),
												array('class'=>'btn btn-lg btn-edit', 'escape'=>false)
											);
										}
									?>

								<?php elseif($gerenciar): ?>

									<?php 
										echo $this->Html->link('Insira seu endereço', 
											array('controller'=>'contatos', 'action'=>'editar_endereco', $contato['Contato']['id']),
											array('class'=>'btn-block btn-yellow', 'escape'=>false)
										).'<br>';
									?>

								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>

			</section>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
					<hr class="row">
				</div>
			</div>
			<?php endif; ?>


			<!-- TELEFONES -->
			<?php if(!empty($contato['Contato']['fone1'] OR $gerenciar)): ?>
			<section id="sect-telefones">
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
						<div class="row">
							
							<!-- icon -->
							<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 text-center">
								<div class="row"><i class="fa fa-phone fa-2x"></i></div>
							</div>
							
							<!-- telefones (xs, sm, md) -->
							<div class="col-xs-10 col-sm-11 col-md-11 col-lg-11 clear-left">
								<?php if(!empty($contato['Contato']['fone1'])): ?>
									
									<div class="fne">
										<?php echo $this->element('layout/contatos/fone', array('fones'=>$contato['Contato'])); ?>
									</div>
									<?php
										if($gerenciar){

											echo $this->Html->link($icon_cfg, 
												array('controller'=>'contatos', 'action'=>'editar_telefone', $contato['Contato']['id']),
												array('class'=>'btn btn-lg btn-edit', 'escape'=>false)
											);
										}
									?>

								<?php elseif($gerenciar): ?>

									<?php 
										echo $this->Html->link('Insira seus telefones', 
											array('controller'=>'contatos', 'action'=>'editar_telefone', $contato['Contato']['id']),
											array('class'=>'btn-block btn-yellow', 'escape'=>false)
										).'<br>';
									?>

								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>

			</section>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
					<hr class="row">
				</div>
			</div>
			<?php endif; ?>
			

			<!-- HORARIOS DE FUNCIONAMENTO -->
			<?php $horarios = ''; ?>
			<?php if(!empty($horarios OR $gerenciar)): ?>
			<section id="sect-horarios">
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
						<div class="row">
							
							<!-- icon -->
							<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 text-center">
								<div class="row"><i class="fa fa-clock-o fa-2x"></i></div>
							</div>
							
							<!-- horarios (xs, sm, md) -->
							<div class="col-xs-10 col-sm-11 col-md-11 col-lg-11 clear-left">
								<?php if(!empty($horarios)): ?>
									
										Horarios de funcionamento
										<?php
											if($gerenciar){

												echo $this->Html->link($icon_cfg, 
													array('controller'=>'pages', 'action'=>'display', 'em_desenvolvimento'),
													array('class'=>'btn btn-lg btn-edit', 'escape'=>false)
												);
											}
										?>

								<?php elseif($gerenciar): ?>

									<?php 
										echo $this->Html->link('Insira seus horários de Funcionamento', 
											array('controller'=>'pages', 'action'=>'display', 'em_desenvolvimento'),
											array('class'=>'btn-block btn-yellow', 'escape'=>false)
										);
									?>

								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>

			</section>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
					<hr class="row">
				</div>
			</div>
			<?php endif; ?>
			

			<!-- DESTAQUES -->
			<?php $destaques = ''; ?>
			<?php if(!empty($destaques OR $gerenciar)): ?>
			<section id="sect-destaques">
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
						<div class="row">
							
							<!-- icon -->
							<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1 text-center">
								<div class="row"><i class="fa fa-star-o fa-2x"></i></div>
							</div>
							
							<!-- destaques (xs, sm, md) -->
							<div class="col-xs-10 col-sm-11 col-md-11 col-lg-11 clear-left">
								<?php if(!empty($destaques)): ?>
									
									<div class="destaques">
										Destaques
										<?php
											if($gerenciar){

												echo $this->Html->link($icon_cfg, 
													array('controller'=>'pages', 'action'=>'display', 'em_desenvolvimento'),
													array('class'=>'btn btn-lg btn-edit', 'escape'=>false)
												);
											}
										?>
									</div>

								<?php elseif($gerenciar): ?>

									<?php 
										echo $this->Html->link('Insira seus destaques', 
											array('controller'=>'pages', 'action'=>'display', 'em_desenvolvimento'),
											array('class'=>'btn-block btn-yellow', 'escape'=>false)
										);
									?>

								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>

			</section>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
					<hr class="row">
				</div>
			</div>
			<?php endif; ?>
			


			
			<?php echo $this->element('layout/contatos/not_results'); ?>

		<?php endif; ?>

	</div>

	<!-- BANNER PREMIUM -->
	<?php if(!empty($contato['BannerC']['imagem']) OR $gerenciar): ?>
	<section id="sect-banner_premium" class="row text-center">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row">
			<?php 
				if(!empty($contato['BannerC']['imagem'])){

					echo $this->element('layout/contatos/anuncio_premium', array('banner_premium'=>$contato['BannerC']));

					if($gerenciar){

						echo $this->Html->link($icon_cfg, 
							array('controller'=>'banners', 'action'=>'editar_banner_premium', 'contato_id'=>$contato['Contato']['id']),
							array('class'=>'btn btn-lg btn-edit', 'escape'=>false)
						);
					}
				}
				elseif($gerenciar){

					echo $this->Html->link('Insira seu banner premium', 
						array('controller'=>'banners', 'action'=>'editar_banner_premium', 'contato_id'=>$contato['Contato']['id']),
						array('class'=>'btn-block btn-yellow', 'escape'=>false, 'style'=>'padding:60px 20px;max-width:750px;margin:0 auto;')
					);
				}
			?>
			</div>
		</div>
	</section>
	<?php endif; ?>


<?php endif; ?>