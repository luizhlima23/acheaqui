<?php
	$limite = (isset($limite))? $limite : 15;
	$tags = array_filter(explode('|', $tags));
	$tags_view = array_slice($tags, 0, $limite);
	for ($i=0; $i <=count($tags) ; $i++) { 
		
		if(!empty($tags_view[$i])){
			$tag = $tags_view[$i];
			$link = $this->Html->link($tag,
				'javascript: void(0)'
			);
				// array('class'=>'valuesubmit', 'data-param'=>$tag)
			echo '<span>'.$link.'</span>';
		}
	}
	if(count($tags) > $limite){
		echo '...';
	}
?>