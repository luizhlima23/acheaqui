<?php

	# MAIS - Botão para acessar perfil da contato
	if(isset($slug)){

		$ico_mais = '<i class="fa fa-plus-circle btn-icon_white btn-mais_info"></i>';
		echo $this->Html->link(
			$ico_mais,
			array(
				'controller'=>'contatos',
				'action'=>'empresa',
				'var'=>$slug,
			),
			array('escape'=>false, 'title'=>'Ver mais informações')
		);

	}
?>