<?php
App::uses('AppController', 'Controller');

class EtiquetasController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
	}

	/**
	 * Editar etiquetas da Empresa
	 *
	 * @param int $contato_id;
	 */
	public function empresa($contato_id=null){

		# Variáveis para view
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');
		$this->set('contato_id', $contato_id);
		$this->set('nome', $this->Contato->get_nome($contato_id) );

		$this->set('contato_id', $contato_id);

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			# Array que será salvo no BD
			$data['Etiqueta']['id'] = $this->data['Etiqueta']['id'];
			$data['Etiqueta']['tags'] = $this->data['Etiqueta']['tags'];

			if($this->Etiqueta->save($data)){
				
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'etiquetas', 'action'=>'empresa', 'contato_id'=>$contato_id));
			}
			else{

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}
		}
		else {

			$options = array(
				'conditions' => array(
					'Etiqueta.contato_id'=>$contato_id,
					'Etiqueta.status'=>true
				),
			);
			$Etiqueta = $this->Etiqueta->find('first', $options);

			if(!empty($Etiqueta)){

				$Etiqueta['Etiqueta']['tags'] = $this->Etiqueta->tagsFormatAfterFind($Etiqueta['Etiqueta']['tags']);
				$this->request->data = $Etiqueta;
			}
			else{

				$this->set('contratar', true);
			}
		}
	}
}