<div id="div-cad_contato" class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

	<?php 
		$ico_smile = $this->Html->image('layout/AONDE-site-ico-SMILE.png', array('class'=>'responsive-img', 'width'=>'24px', 'height'=>'24px'));
		echo $this->Html->link(
			'<strong style="letter-spacing:-1px">Cadastre empresas aqui '.$ico_smile.' é Grátis<span class="hidden-xs"> e ajuda a todos</span>!</strong>',
			array('controller' => 'contatos', 'action' => 'cadastrar_estabelecimento'),
			array('escape'=>false)
		);
	?>

</div>