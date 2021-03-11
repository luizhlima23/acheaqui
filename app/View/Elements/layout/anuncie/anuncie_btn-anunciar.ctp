<div id="divQueroAnunciar">
	<?php 
		echo $this->Html->link('QUERO CONTRATAR',
			array('controller'=>'contatos', 'action'=>'anunciar_empresa' , 'anunciar'=>'true'),
			array('class'=>'btn btn-primary btn-lg btn-block', 'style'=>'padding:20px 10px;')
		);
	?>
</div>