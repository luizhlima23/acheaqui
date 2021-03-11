<?php
	$d['BannerC'] = $banner_premium;

	# Imagem
	$url_imagem = $this->Upload->url($d, 'BannerC.imagem', array('style'=>'original'));
	$posicao = strpos($url_imagem, $this->webroot);
	$file = substr($url_imagem, $posicao+strlen($this->webroot)); 

	# Link do banner
	if(!empty($banner_premium['url_redirect'])){

		$link = $banner_premium['url_redirect'];
		$target = $banner_premium['url_target'];
	}
	else{

		$link = Router::url(array('controller'=>'contatos', 'action'=>'empresa', $banner_premium['contato_id']), true);
		$target = '_parent';
	}
?>
<?php if(file_exists($file)): ?>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="row">
					<?php 
						$img =  $this->Html->image('/'.$file, array('class'=>'responsive-img over-clique', 'style'=>'max-height:130px'));

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
					?>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>