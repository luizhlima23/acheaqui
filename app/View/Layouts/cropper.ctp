<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		// bootstrap
		echo $this->Html->css(
			array(
				'http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css',
				'https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.css'
			)
		);

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->fetch('inlineCss'); 
	?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div id="container">

		<div class="header">
			
		</div>
		
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<div class="col-xs-12">
				<?php echo $this->fetch('content'); ?>
			</div>

		</div>

		<div id="footer">
			
		</div>

	</div>

	<?php
		# Scripts
		echo $this->Html->script(array(
				'https://code.jquery.com/jquery-1.12.4.min.js',
				'http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',
				'https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.js'
			)
		);

		# Scripts Inline
		echo $this->fetch('inlineScripts'); 
	?>

</body>
</html>
