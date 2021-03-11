<?php
App::uses('AppController', 'Controller');

class AnunciosController extends AppController{

	public $components = array(
		'Session'
	);

	public function beforeFilter() {
	    parent::beforeFilter();

	    $this->Auth->allow('anunciar_empresa');
	}

/**
==========================
CADASTRO E DIVULGAÇÃO
==========================
*/
	/**
	 * Página de anúncios do Guia.
	 *
	 * @access public
	 */
	public function anunciar_empresa($contato_id=null){

		# EMPRESA JÁ SELECIONADA 

			if(!is_null($contato_id)){

				$this->request->data['Pedido']['contato_id'] = $contato_id;

				if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');

				// Consulta dados da empresa para View
					$this->Contato->id = $contato_id;
					$contato_nome = $this->Contato->field('nome');
					$empresa_selecionada['Contato'] = array(
						'id'=>$contato_id,
						'nome'=>$contato_nome
					);
					$this->set('empresa_selecionada', $empresa_selecionada);
			}
		

		// pacotes de serviços 
		$this->set('pacotes', $this->pacotes);
	}




}
?>