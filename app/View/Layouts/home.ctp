<!DOCTYPE html>
<?php echo $this->Facebook->html(); ?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<?php echo $this->Html->charset(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Language" content="pt-BR">
	<meta name="language" content="pt-br">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=yes">
	<link rel="alternate" hreflang="pt-br" href="https://aonde.info/" />
	<link rel="canonical" href="https://aonde.info/" />
	
	<meta name="format-detection" content="telephone=no">

	<link rel="dns-prefetch" href="//apis.google.com">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
	<link rel="dns-prefetch" href="//connect.facebook.net">
	<link rel="dns-prefetch" href="//platform.twitter.com">
	<link rel="dns-prefetch" href="//static.ak.facebook.com">
	<link rel="dns-prefetch" href="//s-static.ak.facebook.com">
	<link rel="dns-prefetch" href="//google-analytics.com">
	<link rel="dns-prefetch" href="//www.google-analytics.com">
	
	<title><?php echo ($this->here == $this->webroot)? $title_for_layout : $title_for_layout.' - AONDE'; ?></title>
	
	<?php echo $this->element('layout/SEO-meta_tags');?>
	
	<!-- CSS -->
	<?php //echo $this->AssetCompress->css('styles'); ?>
	<?php 
		# Bootstrap
		echo $this->Html->css(array('bootstrap.min', 'bootstrap-theme_aonde', 'font-awesome'));

		# Global
		echo $this->Html->css(array('global'));

		# Auto Completar
		echo $this->Html->css(array('autocomplete'));
	?>
	
	<!-- FAVICON -->
	<?php
		//$path = $this->Html->url('/img/favicon');
		//echo $this->element('layout/favicon', array('path'=>$path));
	?>

	<?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->fetch('inlineCss'); 
	?>

	<!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
	<!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<link rel="manifest" href="/manifest.json">
	
	<script data-ad-client="ca-pub-3243244947031769" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>
<body>

	<div id="top-menu">
		<?php echo $this->element('layout/top-menu'); ?>
	</div>
	
	<?php if( $this->here != $this->webroot ): ?>
	<div id="divPesquisa" style="margin-top: 45px;">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:10px">
					<?php echo $this->element('layout/topo-busca'); ?>
				</div>
			</div>
			<?php if(isset($sugestoes)): ?>
			<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						
						<div class="col-sm-6 col-sm-offset-3 col-md-5 col-md-offset-2">
							<small>Sugestões de pesquisa:</small>
							<strong>
							<?php
								$i=0;
								foreach ($sugestoes as $p) {

									$i++;
									echo $this->Html->link($p,
										'javascript: void(0);',
										array('class'=>'valuesubmit link-primary', 'data-param'=>$p, 'style'=>'color:#ffcc29;')
									);
									echo ($i<count($sugestoes))? ', ' : '';
								}
							?>
							</strong>
						</div>

					</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

	<div id="divFlash">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth', array('element' => 'layout/flash/flash_danger')); ?>
	</div>

	<div id="divConteudo">
		<?php echo $this->fetch('content'); ?>
	</div>
	
	<?php if(isset($banner_premium)): ?>
		<!-- PREMIUM -->	
		<div id="divAnuncioGlobal" class="text-center">
			<?php echo $this->element('layout/contatos/anuncio_premium', array('banner_premium'=>$banner_premium['BannerC'])); ?>
		</div>
		<?php if( $this->here != $this->webroot ): ?>
			<div style="height:140px;width:100%;"></div>
		<?php endif; ?>
	<?php endif; ?>

	<?php //echo $this->AssetCompress->script('scripts'); ?>
	<?php 
		# Jquery
		echo $this->Html->script(array('jquery-2.1.1.min', 'jquery-ui-1.10.4.custom.min'));

		# Jquery mobile
		if($this->request->is('mobile') ){

			// echo $this->Html->script(array('https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js'));
		}

		# Bootstrap
		echo $this->Html->script(array('bootstrap'));

		# Outros
		echo $this->Html->script(array('responsive-paginate', 'global'));

	?>

	<!-- Home Scripts -->
	<script>
	$(document).ready(function(){
		
		// INPUT TOOGLE
		<?php if( $this->request->is('mobile') ): ?>

			$("#inpBusca").on("focus", function() {
				$("#imgLogo").hide(0);
				$("#divDiversos").hide(0);
				$("#divAnuncioGlobal").hide(0);
				$("#homeBox").removeClass('vertical-center');
			});

			$("#inpBusca").on("blur", function() {

				setTimeout(function(){
					$("#homeBox").addClass('vertical-center');
					$("#imgLogo").delay(0).show(0);
					$("#divAnuncioGlobal").delay(0).show(0);
				}, 100);				
			});

		<?php else: ?>

			<?php if( $this->here != $this->webroot AND $this->request->params['action'] === 'pesquisa'): ?>
				window.onload = function(){
					var campo = document.getElementById('inpBusca');
					var str_length = campo.value.length;
					campo.focus();
					campo.selectionStart = str_length;
					return false;
				};
			<?php endif; ?>

		<?php endif; ?>
		
	});
	</script>
	<?php
		# Seta variáveis para o Js 
		echo $this->Js->set('url', Router::url('/', true)); // app.url

		echo $scripts_for_layout; 

		# Js writeBuffer 
		if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer'))
				// Writes cached scripts
				echo $this->Js->writeBuffer(array('inline' => true));

		# Scripts Inline
		echo $this->fetch('inlineScripts'); 
	?>

	<!-- Google analytics -->
	<?php echo $this->element('gnalytics'); ?>

	<?php echo $this->Facebook->init(); ?>
</body>
</html>