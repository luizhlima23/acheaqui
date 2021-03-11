<!DOCTYPE html>
<?php echo $this->Facebook->html(); ?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
	.div-endereco{
		color: #A4A4A4 ;
	}
	.fne{
		color: #A4A4A4;
	}
	p{color: #A4A4A4;
	}
	i{color:#B1DE78;}
	
</style>


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

	<title><?php echo $this->fetch('title'); ?> - ACHEAQUI</title>
	
	<?php echo $this->element('layout/SEO-meta_tags');?>
	
	<!-- CSS -->
	<?php //echo $this->AssetCompress->css('styles'); ?>
	<?php //echo $this->AssetCompress->css('select'); ?>

	<?php 
		# Bootstrap
		echo $this->Html->css(array('bootstrap', 'bootstrap-theme_aonde', 'font-awesome'));

		# Global
		echo $this->Html->css(array('global'));

		# Auto Completar
		echo $this->Html->css(array('autocomplete'));
	?>

	<!-- FAVICON -->
	<?php
		$path = $this->Html->url('/img/favicon');
		echo $this->element('layout/favicon', array('path'=>$path));
	?>

	<?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->fetch('inlineCss'); 
	?>
	
	<?php 
		// $this->Html->css('/Froala/css/froala_editor.min.css');
		// $this->Html->script('/Froala/js/froala_editor.min.js', array('toolbarInline' => false));
	?>

	<!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
	<!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<script data-ad-client="ca-pub-3243244947031769" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		
</head>
<body>

	<div id="top-menu">
		<?php echo $this->element('layout/top-menu'); ?>
	</div>
		
	<?php if( $this->here != $this->webroot ): ?>
	<div id="divPesquisa"style="margin-top: 45px;">
		<div class="container">
			<div class="row" > 
				<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:10px; margin-bottom:10px; padding-top:10px">
					<?php echo $this->element('layout/topo-busca'); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div id="divFlash">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->Session->flash('auth', array('element' => 'layout/flash/flash_danger')); ?>
	</div>

	<div id="divConteudo" class="container">
		<?php echo $this->fetch('content'); ?>
	</div>
	
	<?php if( $this->here != $this->webroot ): ?>
	<div id="footer">
		<br /><br /><br />
	</div>
	<?php endif; ?>
	
	
	
	<?php //echo $this->AssetCompress->script('scripts'); ?>
	
	<?php 
		# Jquery
		echo $this->Html->script(array('jquery-2.1.1.min', 'jquery-ui-1.10.4.custom.min'));

		# Bootstrap
		echo $this->Html->script(array('bootstrap'));
		
		# Outros
		echo $this->Html->script(array('responsive-paginate', 'global'));

		# Seta variáveis para o Js 
		echo $this->Js->set('url', Router::url('/', true)); // app.url

		echo $scripts_for_layout; 

		# Js writeBuffer 
		if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer'))
				// Grava scripts em cache
				echo $this->Js->writeBuffer(array('inline' => true));

		# Scripts Inline
		echo $this->fetch('inlineScripts'); 
	?>

	<?php echo $this->Facebook->init(); ?>
</body>
</html>