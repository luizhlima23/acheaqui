<?php
	$ico_close = $this->Html->image('layout/AONDE-site-ico-FECHAR.png', array('class'=>'responsive-img', 'width'=>'20px', 'height'=>'20px'));
	echo $this->Js->link('<strong>Fechar '.$ico_close.'</strong>',
		array('action' => 'enviacontato', 'fechar'),
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
<br /><br />