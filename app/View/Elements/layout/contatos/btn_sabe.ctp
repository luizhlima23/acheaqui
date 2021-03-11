<?php
	$nome = isset($nome)? $nome:'';
	$end = isset($end)? $end:'';
	$fone = isset($fone)? $fone:'';
	$ico_sabe = $this->Html->image('layout/AONDE-site-ico-SABEFONE.png', array('class'=>'responsive-img', 'width'=>'62px', 'height'=>'21px'));
	echo $this->Js->link($ico_sabe,
		array('action' => 'enviacontato', 'formulario', $nome, $end, $fone),
		array(
			'before' => $this->Js->get('#fom-cad_contato')->effect('fadeIn').$this->Js->get('#loading')->effect('fadeIn'),
			'success' => $this->Js->get('#loading')->effect('hide'),
			'update' => '#div-cad_contato',
			'escape'=>false,
			'style'=>'color:white'
		)
	);
	echo $this->Html->script('jquery-2.1.1.min');
	echo $this->Js->writeBuffer(array('inline' => 'true'));
?>