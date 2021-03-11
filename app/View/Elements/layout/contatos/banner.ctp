<?php 
	$d[$model] = $data;

	# Imagem
	$url_imagem = $this->Upload->url($d, $model.'.imagem', array('style'=>'original'));
	$posicao = strpos($url_imagem, $this->webroot);
	$file = substr($url_imagem, $posicao+strlen($this->webroot)); 

	# Link do banner
	if(!empty($data['url_redirect'])){

		$link = $data['url_redirect'];
		$target = $data['url_target'];
	}
	else{

		$link = Router::url(array('controller'=>'contatos', 'action'=>'empresa', $data['contato_id']), true);
		$target = '_parent';
	}
?>
<div id="banner" class="filho">
<?php
	# Se a URL existe então exibe;
	if(file_exists($file)){

		$img =  $this->Html->image('/'.$file, array('class'=>'responsive-img'));	

		# Se redirect então cria link, se não apenas exibe a imagem
		if(!empty($link)){

			echo $this->Html->link(
				$img,
				$link,
				array(
					'target'=>$target,
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