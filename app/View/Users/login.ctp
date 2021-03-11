<?php echo $this->Html->css(array('bootstrap-social.css')); ?>
<h2 class="page-header"><?php echo __('Acesse sua conta'); ?></h2>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="row">
			
			<div id="div-login" class="col-xs-12 col-sm-6 col-md-4">
				<?php
					$icon_fb = '<span class="fa fa-facebook"></span>';
					$options = array(
						'label' => $icon_fb.''.__('Login com Facebook'),
						'custom' => true,
						// 'redirect' => array('controller'=>'dashboards', 'action'=>'index', 'plugin'=>false),
						'img' => false,
						'id' => '',
						'class' => 'btn btn-lg btn-block btn-social btn-facebook',
					);
					echo $this->Facebook->login($options);
				?>
				<br>
				<strong class="text-muted">&nbsp;&nbsp;&nbsp;ou use seu E-mail</strong>
				<br><br>
				<?php echo $this->element('forms/form-login'); ?>
				<br>
				<br>
				<?php echo $this->Html->link('Me cadastrar', array('controller'=>'users', 'action'=>'cadastro_usuario'), array('class'=>'btn btn-link')); ?>
			</div>

		</div>
	</div>
</div>