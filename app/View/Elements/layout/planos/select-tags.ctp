<?php
	if(!empty( trim($tags, '|') )){

		$tags = explode('|', $tags);
		natcasesort($tags);

		if(!is_null($tags)){

			echo "<ol>";
			foreach ($tags as $val) {
				
				$tag = mb_strtolower($val);
				$link = $tag;
				$link_class = 'btn-link';
				$plano_id = $this->request->params['pass'][0];
				echo $this->Js->link('<li>'.$link.'</li>',
					array('controller'=>'planos', 'action'=>'delete_tag', $plano_id, $tag),
					array('update'=>'#left-box', 'escape'=>false, 'class'=>$link_class)
				);
			}
			echo '</ol>';
		}
	}
?>