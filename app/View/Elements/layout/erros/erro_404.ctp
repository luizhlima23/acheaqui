<style type="text/css">
	.vertical-center{min-height:70%;min-height:70vh;}
</style>
<div class="vertical-center">
	<div id="centerBox" class="container text-center">
		
		<div id="divError" class="row text-center">
			<div class="logo col-xs-10 col-sm-4 col-sm-offset-1 col-md-2 col-md-offset-3 text-right">
				<?php
					$errorLogo = $this->Html->image('layout/AONDE-site-ico-404.png', array('height'=>'130px', 'width'=>'110px', 'class'=>'responsive-img'));
					echo $this->Html->link($errorLogo,
						array('controller'=>'contatos', 'action'=>'home'),
						array('escape'=>false)
					);
				?>
			</div>
			<div class="col-xs-10 col-sm-6 col-md-4 text-left">
				<h4 class="title">Ops! Página não encontrada <small class="text-muted">(erro 404)</small></h4>
				<strong><?php echo __('Possíveis motivos:'); ?></strong>
				<ul style="margin-left:17px;">
					<li><?php echo __('O conteúdo não está mais no ar;'); ?></li>
					<li><?php echo __('A página mudou de endereço;'); ?></li>
					<li><?php echo __('Você digitou o endereço errado.'); ?></li>
				</ul>
				<?php 
					echo $this->Html->link('Voltar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); 
				?>
			</div>
		</div>

	</div>
</div>