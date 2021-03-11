	<!-- ROBOTS -->
	<?php 
		$meta_robots = (isset($meta_robots))? $meta_robots : false;
		$meta_robots = ($meta_robots===true)? 'index, follow' : 'noindex, nofollow';
	?>
	<meta name='robots' content='<?php echo $meta_robots; ?>'>
	<meta name='googlebot' content='<?php echo $meta_robots; ?>'>

	<?php if(isset($meta_publisher)): ?>
		<link rel="publisher" href="<?php echo $meta_publisher; ?>">
	<?php endif; ?>

	<?php 
		# DEFAULT
	
		// description		=> 
		// keywords			=> Palavras-chave para a página
		// author			=> Autor do site
		// version			=> Versão
		
		if(isset($meta_default)){

			foreach ($meta_default as $k => $v) {
				
				echo "<meta name='$k' content='$v'>";
			}
		} 
	?>
	<meta name="author" content="<?php echo Configure::read('Application.author'); ?>"/>
	<meta name="version" content="<?php echo Configure::read('Application.version'); ?>"/>

	<?php 
		# FACEBOOK

		// og:title 			=> Royal Branding
		// og:site_name 		=> Aonde
		// og:url				=> http://www.aonde.info/cristalina/royal-branding
		// og:description		=> 
		// og:image 			=> Router::url('/img/layout/AONDE-cristalina-go-ICONE.png', true)
		// og:image:width		=> 68
		// og:image:height 		=> 68
		// og:image:type 	 	=> image/png
		// og:type				=> website
		// og:locale			=> pt_BR
		
		# site_name
		if(!isset($meta_facebook['og:site_name']))
			$meta_facebook['og:site_name'] = Configure::read('Application.name');

		# images
		if(!empty($meta_galeria)){

			foreach ($meta_galeria as $k=>$m) {
				
				$img = Router::url('/'.$m['imagem'], true);
				echo "<meta property='og:image' content='$img'>";
				echo "<meta property='og:image:width' content='768'>";
				echo "<meta property='og:image:height' content='768'>";
				echo "<meta property='og:image:type' content='image/jpeg'>";
			}
		}

		# locale
		if(!isset($meta_facebook['og:locale']))
			$meta_facebook['og:locale'] = 'pt_BR';

		# TAGS
		if(isset($meta_facebook)){

			foreach ($meta_facebook as $k => $v) {
				
				echo "<meta property='$k' content='$v'>";
			}
		} 
	?>

	<?php 
		# FACEBOOK - BUSINESS

		// place:location:latitude 						=> -16.770517
		// place:location:longitude 					=> -47.610462
		// business:contact_data:street_address 		=> Rua Aymorés
		// business:contact_data:locality		 		=> Cristalina
		// business:contact_data:region 		 		=> Goiás
		// business:contact_data:country_name		 	=> Brasil
		// business:contact_data:postal_code		 	=> 73850000
		// business:contact_data:email 				 	=> contato@royalbranding.com.br
		// business:contact_data:phone_number		 	=> +55 (61) 3612-3484
		// business:contact_data:website			 	=> www.royalbranding.com.br

		# TAGS
		if(isset($meta_fb_business)){

			foreach ($meta_fb_business as $k => $v) {
				
				echo "<meta property='$k' content='$v'>";
			}
		} 
	?>

	<?php 
		# TWITTER

		// twitter:card 			=> summary
		// twitter:site				=> @aonde
		// twitter:domain			=> www.aonde.info
		// twitter:url				=> http://www.aonde.info/cristalina/royal-branding
		// twitter:title 			=> Royal Branding
		// twitter:description		=> Encontre o telefone ou o endereço de contato Royal Branding Centro em Cristalina
		// twitter:creator			=> Royal Branding

		# TAGS
		if(isset($meta_twitter)){

			foreach ($meta_twitter as $k => $v) {
				
				echo "<meta name='$k' content='$v'>";
			}
		} 
	?>

	<?php 
		# GOOGLE PLUS

		// name					=> Aonde
		// description			=> 
		// image				=> https://website.com/image250X250.png

		# TAGS
		if(isset($meta_google)){

			foreach ($meta_google as $k => $v) {
				
				echo "<meta itemprop='$k' content='$v'>";
			}
		} 
	?>
		
	<!-- CHROME -->
	<meta name="theme-color" content="#EE3F23">

	<!-- APPLE -->
	<meta name="apple-mobile-web-app-capable" content="yes"/>
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="apple-mobile-web-app-title" content="<?php echo Configure::read('Application.name'); ?>"/>

	<!-- MICROSOFT -->
	<meta name="application-name" content="<?php echo Configure::read('Application.name'); ?>"/>
	<meta name="msapplication-TileColor" content="#EE3F23"/>
	<meta name="msapplication-TileImage" content="<?php echo Router::url('/img/favicon/ms-icon-144x144.png', true) ?>"/>
