<?php echo $this->Html->css(array('bootstrap-social.css')); ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<h2 class="page-header">Atenção</h2>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6">
			
		<div class="alert alert-info">
			Esta função está em desenvolvimento, curta nossa fanpage e fique por dentro da ativação desta e outras funções.
		</div>

	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6">
			
		<?php
			$icon_fb = '<span class="fa fa-facebook"></span>';
			echo $this->Html->link($icon_fb.' aonde.info', 
				'https://www.facebook.com/aonde.info/',
				array('escape'=>false, 'class'=>'btn btn-xs btn-facebook', 'target'=>'_blank')
			);

			echo '<br><br>Ou: <br><br>';
			
			$fb_like_options = array(
				'href'=>'https://www.facebook.com/aonde.info/',
				'show_faces'=>'true',
				// 'font'=>' tahoma', //arial, lucida grande, segoe ui, tahoma, trebuchet ms, verdana
				'layout'=>'standard', //button_count, standard, default: standard
				'action'=>'like', //like or recommend, default: like
				'colorscheme'=>'dark', //dark or light, default: light
			);
			// echo $this->Facebook->like($fb_like_options);
			
			echo $this->Facebook->likebox('https://www.facebook.com/aonde.info/');
		?>

	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6">
		
		<br>
		<?php
			echo $this->Html->link('voltar', 
				$referer,
				array('class'=>'btn btn-link')
			);
		?>

	</div>
</div>