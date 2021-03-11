<?php 

$data = array();

if(!empty($contatos)) {

	$count_contatos = count($contatos);
	if($count_contatos > 3) array_pop($contatos);
	foreach ($contatos as $d){
		
		$nome = mb_strtolower($d['Contato']['nome']);

		$data[] = array(
			'label'=>$nome,
			'category'=>'',
			'class'=>'empresa'
		);
	}

	# Se houver mais resultados, então inserir a linha de mais...
	if($count_contatos > 3 AND 1==1){

		$link_mais = $this->Html->link('<strong>ver mais...</strong>',
			'javascript: void(0)',
			array('escape'=>false)
		);
		$data[] = array(
			'label'=>$q,
			'category'=>'vermais',
			'link'=>$link_mais,
			'class'=>'categoria'
		);
	}
}

if(!empty($tags)) {

	foreach ($tags as $t){
		
		$tag = mb_strtolower($t['Tag']['tag']);

		$data[] = array(
			'label'=>'<span class="ui-menu-tag">'.$tag.'</span>',
			'value'=>$tag,
			'category'=>'',
			'class'=>'tag'
		);
	}
}

echo json_encode($data);

?>