<?php 
	$dominio =  $this->Html->url('/', true);

	# URL da imagem
	$url_img = (strpos($Banner['imagem'], 'http') OR strpos($Banner['imagem'], 'https'))?
					$Banner['imagem'] : 
					$dominio.ltrim($Banner['imagem'], '/');
?>
<div id="banner" class="filho text-left">
<?php
	# Se a URL existe então exibe;
	if($this->Formata->url_exists($url_img)){

		$img = $this->Html->image($url_img,
			array(
				'class'=>'responsive-img',
				'style'=>'max-height:100px;',
				'alt'=>$Banner["titulo"]
			)
		);

		# Se redirect então cria link, se não apenas exibe a imagem
		if(!empty($Banner['url_redirect'])){

			echo $this->Html->link(
				$img,
				$Banner['url_redirect'],
				array(
					'target'=>$Banner['url_target'],
					'escape'=>false,
					'full_base' => true
				)
			);
		}
		else{

			echo $img;
		}
	}
?>
</div>