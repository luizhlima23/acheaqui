<?php

class SeoComponent extends Component{

	// public $components = array();

	public function startup(Controller $controller) {
		
		$this->controller = $controller; 
	}

	/**
	 *	Define as Meta tags do Facebook para uma Empresa
	 *
	 * @param array $og;
	 * @return void(0);
	 */
	public function setFacebookMetaTags($og=null, string $controller=null){

		if(!is_array($og)) return false;

		foreach ($og as $tag => $val) {

			$this->controller->set('fb_'.$tag, $val);
		}

		return true;
	}


}

?>