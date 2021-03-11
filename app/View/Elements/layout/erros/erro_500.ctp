<style type="text/css">
	.vertical-center{min-height:75%;min-height:75vh;}
</style>
<div class="vertical-center">
	<div id="centerBox" class="container text-center">
		
		<div id="divError" class="row text-center">
			<div class="col-xs-12 col-sm-4 col-sm-offset-1 col-md-2 col-md-offset-3 text-center">
				<?php
					$errorLogo = $this->Html->image('layout/AONDE-site-ico-404.png', array('class'=>'responsive-img', 'height'=>'130px', 'width'=>'110px'));
					echo $this->Html->link($errorLogo,
						array('controller'=>'contatos', 'action'=>'home'),
						array('escape'=>false, 'class'=>'pull-right')
					);
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4 text-left">
				<h4 class="title">Ops! Erro interno <small class="text-muted">(erro 500)</small></h4>
				<strong><?php echo __('Desculpe:'); ?></strong>
				<ul style="margin-left:17px;">
					<li><?php echo __('Nós já estamos consertando;'); ?></li>
				</ul>
			</div>
		</div>

	</div>
</div>