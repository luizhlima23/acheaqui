<?php
	$menus = array(
		'Serviços contratados' => array(
			'Etiquetas' => array('controller'=>'etiquetas', 'action'=>'empresa', 'contato_id'=>$contato_id), 
			'Banner Básico' => array('controller'=>'banners', 'action'=>'editar_banner_basico', 'contato_id'=>$contato_id), 
			'Banner Rotativo' => array('controller'=>'banners', 'action'=>'editar_banner_rotativo', 'contato_id'=>$contato_id), 
			'Banner Premium' => array('controller'=>'banners', 'action'=>'editar_banner_premium', 'contato_id'=>$contato_id), 
		),
		'Informações da Empresa' => array(
			'Nome / Descrição' => array('controller'=>'contatos', 'action'=>'editar_a', $contato_id), 
			'Endereço' => array('controller'=>'contatos', 'action'=>'editar_endereco', $contato_id), 
			'Telefones' => array('controller'=>'contatos', 'action'=>'editar_telefone', $contato_id), 
			'<span class="text-muted">Horários de Funcionamento </span>' => array('controller'=>'contatos', 'action'=>'#'), 
			'<span class="text-muted">Destaques </span>' => array('controller'=>'contatos', 'action'=>'#'), 
		),
	);
	echo $this->element('layout/panel-nav', array('menus'=>$menus));
?>