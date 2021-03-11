<?php 
	echo $this->Js->submit('Enviar',
		array(
			'before' => $this->Js->get('#loading')->effect('fadeIn'),
			'success' => $this->Js->get('#loading')->effect('hide'),
			'update' => '#div-cad_contato',
			'url' => array('action' => 'enviacontato', 'cadastrar'),
			'class'=>'btn btn-block btn-aonde-primary'
		)
	);
	echo $this->Html->script('jquery-2.1.1.min');
	echo $this->Js->writeBuffer(array('inline' => 'true'));
?>