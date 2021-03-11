<?php
	$msg_esgotado = '<strong>ESGOTADO</strong><br>Interessados entrar em contato.';
	$link_esgotado = $this->Html->link($msg_esgotado, 
		array('controller'=>'pages', 'action'=>'display', 'contato'),
		array('class'=>'text-center btn-danger btn-block', 'style'=>'padding:10px;', 'escape'=>false)
	);
?>
<?php if(isset($pacotes)): ?>

	<?php echo $this->Html->css(array('inline-anuncie.css')); ?>

	<div id="wrap_anuncie">
		
		<br>

		<!-- HEADER --> 
		<section class="row ">
			<div class="hidden-xs hidden-sm col-md-3 text-right">
				<?php
					echo $this->Html->image('layout/AONDE-site-ico-comprador.png', 
						array('class'=>'responsive-img', 'width'=>'120px', 'style'=>'margin-top:50px')
					);
				?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 text-center">
				<h1 class="text-orange hidden-xs" style="font-size: 50px; line-height: 85%;">
					<strong>Destaque-se em meio aos concorrentes!</strong><br>
					<small>contrate um pacote de publicidade</small>
				</h1>
				<h1 class="text-orange visible-xs" style="font-size: 25px; line-height: 85%;">
					<strong>Destaque-se em meio aos concorrentes!</strong><br>
					<small>contrate nossos serviços de publicidade</small>
				</h1>
			</div>
			<div class="hidden-xs hidden-sm col-md-3 text-left">
				<?php
					echo $this->Html->image('layout/AONDE-site-ico-vendedor.png', 
						array('class'=>'responsive-img', 'width'=>'120px', 'style'=>'margin-top:35px')
					);
				?>
			</div>
			<div class="col-xs-12 col-sm-12 visible-xs visible-sm text-center">
				<?php
					echo $this->Html->image('layout/AONDE-site-ico-comprador_vendedor.png', 
						array('class'=>'responsive-img', 'width'=>'240px', 'style'=>'margin-top:10px;')
					);
				?>
			</div>
		</section>
		
		<!-- EMPRESA SELECIONADA --> 
		<?php if(isset($empresa_selecionada)): $s = $empresa_selecionada; ?>
		<section class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<h2 style="line-height: 100%;">
					<strong class="text-info">
						<small>Empresa selecionada:<br class="visible-xs">
						<strong><?php echo $s['Contato']['nome']; ?></strong>
						</small>
					</strong>
				</h2>
			</div>
		</section>
		<?php endif; ?>

		<?php
			# FORM do Pedido:
			echo $this->Form->create('Pedido', array('url'=>array('controller'=>'pedidos', 'action'=>'gerar_pedido'), 'role'=>'form'));
		?>
	
			<!-- PRODUTOS / SERVIÇOS -->
			<section class="row">
				<!-- ETIQUETAS -->
				<div class="col-xs-12 col-sm-4 col-md-4 box">
					<?php echo $this->element('layout/anuncie/anuncie_etiqueta', array('dados'=>$pacotes['01'], 'link_esgotado'=>$link_esgotado)); ?>
				</div>
				<!-- BANNER BÁSICO -->
				<div class="col-xs-12 col-sm-4 col-md-4 box">
					<?php echo $this->element('layout/anuncie/anuncie_banner-basico', array('dados'=>$pacotes['02'], 'link_esgotado'=>$link_esgotado)); ?>
				</div>
				<!-- BANNER PREMIUM -->
				<div class="col-xs-12 col-sm-4 col-md-4 box">
					<?php echo $this->element('layout/anuncie/anuncie_banner-premium', array('dados'=>$pacotes['03'], 'link_esgotado'=>$link_esgotado)); ?>
				</div>
			</section>

			<div class="row">
				<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
					<br><br>
					<?php 
						echo $this->Form->button(__('CONTINUAR'),
							array(
								'type'=>'submit', 'class'=>'btn btn-primary btn-block btn-lg', 'style'=>'padding:20px 10px;'
							)
						);
					?>
				</div>
			</div>
			
			<?php
				echo $this->Form->hidden('Pedido.contato_id');
			?>

		<?php echo $this->Form->end(); ?>

	</div>

<?php endif; ?>