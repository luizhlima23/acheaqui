<?php
	$ico_smile = $this->Html->image('layout/AONDE-site-ico-SMILE.png', array('class'=>'responsive-img', 'width'=>'24px', 'height'=>'24px'));
	echo $this->Js->link('<strong style="letter-spacing:-1px">Cadastre empresas aqui '.$ico_smile.' é Grátis<span class="hidden-xs"> e ajuda a todos</span>!</strong>',
		array('action' => 'enviacontato', 'formulario'),
		array(
			'before' => $this->Js->get('#fom-cad_contato')->effect('fadeIn').$this->Js->get('#loading')->effect('fadeIn'),
			'success' => $this->Js->get('#loading')->effect('hide'),
			'update' => '#div-cad_contato',
			'escape'=>false
		)
	);
	echo $this->Html->script('jquery-2.1.1.min');
	echo $this->Js->writeBuffer(array('inline' => 'true'));
?>