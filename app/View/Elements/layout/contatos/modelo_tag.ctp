<?php
	$limite = (isset($limite))? $limite : 15;
	$tags = array_filter(explode('|', $tags));
	$tags_view = array_slice($tags, 0, $limite);
	for ($i=0; $i <=count($tags) ; $i++) { 
		
		if(!empty($tags_view[$i])){
			$tag = $tags_view[$i];
			$link = $this->Html->link($tag,
				array(
					'controller'=>'contatos',
					'action'=>'detalhes',
					'cidade'=>'cristalina',
					'slug'=>Inflector::slug(mb_strtolower($nome), '-'),
					'id'=>$id,
				)
			);
			echo '<span class="label-tag">'.$tag.'</span>';
		}
	}
	if(count($tags) > $limite){
		echo '...';
	}
	if(count($tags) >= 1){
		$link = $this->Html->link('ver mais',
			array(
				'controller'=>'contatos',
				'action'=>'detalhes',
				'cidade'=>'cristalina',
				'slug'=>Inflector::slug(mb_strtolower($nome), '-'),
				'id'=>$id,
			)
		);
		echo $this->Html->tag('span', $link, array('class'=>'label-mais'));
	}
?>