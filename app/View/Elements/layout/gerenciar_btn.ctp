<?php 
	echo $this->Html->link('Editor visual',
		array('controller'=>'contatos', 'action'=>'empresa_editor_visual', 'contato_id'=>$contato_id),
		array('class'=>'btn btn-md btn-primary pull-right', 'escape'=>false)
	);
?>