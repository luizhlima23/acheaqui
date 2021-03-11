<?php

class BannerComponent extends Component{

	public $components = array('Session', 'Tool');

	/**
	 * Gerencia exibições do Banner Premium, retornando o próximo á ser exibido.
	 *
	 * @param array $array (Banners)
	 * @return array $banner
	 */ 
	public function getBannerPremium(&$array) {

		$all_banners = $array;
		
		// Verifica sessão de controle, se não existir então cria uma.
		if(!$this->Session->check('Pesquisa.anuncios_globais')){

			$this->Session->write('Pesquisa.anuncios_globais', array());
		}

		// Zera a sessão caso todos banners já tenham sido exibidos
		if(count($all_banners) <= count($this->Session->read('Pesquisa.anuncios_globais'))){

			$this->Session->write('Pesquisa.anuncios_globais', array());
		}
		
		// Elimina banners já vistos pelo usuário
		$banners_vistos = $this->Session->read('Pesquisa.anuncios_globais');
		if($this->Session->check('Pesquisa.anuncios_globais')){

			$banners = array_diff_key($all_banners, $banners_vistos);
		}

		// Se já viu todos então reseta
		if(empty($banners))	$banners = $all_banners;

		if(!empty($banners)){

			$banners = $this->Tool->shuffle_assoc($banners); // Mistura os elementos
		}

		// Adiciona o novo banner a lista de banners já exibidos
		$B = each($banners);
		$return = $B['value'];
		$banners_vistos[$B['key']] = $B['value'];
		$this->Session->write('Pesquisa.anuncios_globais', $banners_vistos);

		return $return;
	}

}

?>