<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">

		<!-- Brand -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-menu_user" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php

				# Anunciar 
				$ico_chat = '<i class="fa fa-bullhorn"></i>&nbsp;';
				echo $this->Html->link($ico_chat.' Anunciar',
					array('controller'=>'anuncios', 'action'=>'anunciar_empresa', 'admin'=>false,'plugin'=>false),
					array('class'=>'navbar-brand destaque', 'escape'=>false)
				);

				# Cadastrar Local
				$ico_lapis = '<i class="fa fa-shopping-bag"></i>&nbsp;';
				echo $this->Html->link($ico_lapis.' Cadastrar <span class="hidden-xs">empresa</span>',
					array('controller'=>'contatos', 'action'=>'cadastrar_empresa', 'admin'=>false,'plugin'=>false),
					array('class'=>'navbar-brand', 'escape'=>false)
				);
			?>
		</div>

		<!-- MENU -->
		<div class="collapse navbar-collapse" id="top-menu_user">
			
			<br class="visible-xs">
			<!-- left (xs, sm, md) -->
			<ul class="nav navbar-nav">
				<li class="dropdown visible-xs">
					<?php 
						echo $this->Html->link('Home', 
							array('controller'=>'contatos', 'action'=>'home', 'admin'=>false,'plugin'=>false),
							array('escape'=>false)
						);
					?>							
				</li>
				<li class="dropdown">
					<?php 
						# Contato
						$ico_contato = '<i class="fa fa-paper-plane hidden-xs"></i>&nbsp;';
						echo $this->Html->link($ico_contato.' Contato',
							array('controller'=>'mensagens', 'action'=>'contato', 'admin'=>false,'plugin'=>false),
							array('escape'=>false)
						);
					?>							
				</li>
				<li class="dropdown">
					<?php 
						# Termos de uso
						$ico_termos = '<i class="fa fa-file-text hidden-xs"></i>&nbsp;';
						echo $this->Html->link($ico_termos.' Termos de Uso',
							array('controller'=>'posts', 'action'=>'termos_de_uso', 'admin'=>false,'plugin'=>false),
							array('escape'=>false)
						);
					?>							
				</li>
			</ul>

			<!-- right (xs, sm, md) -->
			<ul class="nav navbar-nav navbar-right">

				<!-- Admin (sm, md) -->
				<?php
					if(isset($admin_menu) and !empty($admin_menu)){

						$admin_link = $this->Html->link('<span class="fa fa-desktop hidden-xs"></span>&nbsp; Painel', 
							array('controller'=>'dashboards', 'action'=>'index', 'plugin'=>false, 'admin'=>false),
							array('escape'=>false)
						);
						echo $this->Html->tag('li', $admin_link);
					}
				?>

				<!-- User (sm, md) -->
				<?php if(AuthComponent::user('id')): ?>
				<li class="dropdown hidden-xs">
					<?php
						$pic_user = '<i class="fa fa-user-circle"></i>';
						if(AuthComponent::user('url_img')){
							$pic_user = $this->Html->image(
								AuthComponent::user('url_img'), 
								array('class'=>'img_user responsive-img')
							);
						}
					?>
					<a href="javascript:void(0);" class="dropdown-toggle left-image" data-toggle="dropdown">
						<?php echo $pic_user; ?>&nbsp;&nbsp;Minha conta
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<?php 
							foreach ($user_menus as $M => $D) {

								$each = each($D);
								$links = $each['value'];
								foreach ($links as $m => $link) {
									
									echo '<li>';
									echo $this->Html->link(__($m),
										$link,
										array('escape'=>false)
									);
									echo '</li>';
								}
								echo '<li class="divider"></li>';
							}
						?>
						<li class="hidden-xs">
							<?php 
								$menu_sair = $this->Html->tag('i', '', array('class'=>'fa fa-sign-out')).'&nbsp;&nbsp;'.__('Sair');
								echo $this->Facebook->logout(
									array(
										'redirect'=>array('controller'=>'users', 'action'=>'logout', 'admin'=>false,'plugin'=>false),
										'label'=>$menu_sair,
										'escape'=>false
									)
								);
							?>
						</li>
					</ul>
				</li>
				<?php else: ?>
				<li class="dropdown hidden-xs">
					<?php
						$ico_login = '<i class="fa fa-user-circle"></i>&nbsp;&nbsp;';
						echo $this->Html->link($ico_login.' Login',
							array('controller'=>'users', 'action'=>'login', 'admin'=>false,'plugin'=>false),
							array('escape'=>false)
						);
					?>
				</li>
				<?php endif; ?>

				<!-- User (xs) -->
				<?php if(AuthComponent::user('id')): ?>
				<li class="dropdown open visible-xs">
					<ul class="dropdown-menu">
						<?php 
							foreach ($user_menus as $M => $D) {

								$each = each($D);
								$links = $each['value'];
								foreach ($links as $m => $link) {
									
									echo '<li>';
									echo $this->Html->link(__($m),
										$link,
										array('escape'=>false)
									);
									echo '</li>';
								}
								echo '<li class="divider"></li>';
							}
						?>
						<li class="visible-xs">
							<?php 
								echo $this->Facebook->logout(
									array(
										'redirect'=>array('controller'=>'users', 'action'=>'logout', 'admin'=>false,'plugin'=>false),
										'label'=>'Sair',
										'escape'=>false
									)
								);
							?>
						</li>
					</ul>
				</li>
				<?php else: ?>
				<li class="dropdown open visible-xs">
					<?php
						echo $this->Html->link('Login',
							array('controller'=>'users', 'action'=>'login', 'admin'=>false,'plugin'=>false),
							array('escape'=>false)
						);
					?>
				</li>
				<?php endif; ?>
			</ul>
			<br class="visible-xs">

		</div><!-- /.navbar-collapse -->


	</div><!-- /.container-fluid -->
</nav>