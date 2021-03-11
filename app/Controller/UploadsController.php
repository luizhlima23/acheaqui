<?php
App::uses('AppController', 'Controller');

class UploadsController extends AppController {

	public $uses = array('ContatoImagem');
	
	public $components = array(
		'RequestHandler',
		'Session',
		'Cropper'
	);

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow();
	}

/**
===============================
EMPRESA - imagens de capa e etc
===============================
*/

	/**
	 * Galeria de fotos da Empresa
	 *
	 * @param int $contato_id;
	 */
	public function galeria_empresa($contato_id=null){
		
		$this->layout = 'default';

		# Variáveis para view
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');

		$relevancia = $this->Contato->relevancia($contato_id);
		if($relevancia<=0){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'gerenciar_empresa', 'contato_id'=>$contato_id));
		}

		$this->set('contato_id', $contato_id);
		$this->set('nome', $this->Contato->get_nome($contato_id) );

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		$limit = 4;
		$options = array(
			'conditions' => array(
				'ContatoImagem.contato_id'=>$contato_id,
				'ContatoImagem.status'=>true
			),
			'limit'=>$limit
		);

		$this->request->data = $this->ContatoImagem->find('all', $options);

		$count = count($this->request->data);
		if($count < $limit){

			for ($i=$count; $i < $limit; $i++) { 
				
				$arr['ContatoImagem'] = array(
					'id'=>null,
					'contato_id'=>$contato_id,
					'imagem'=>null
				);
				array_push($this->request->data, $arr);
			}
		}
	}

	/**
	 * Upload de fotos para uma empresa
	 *
	 * @param int $contato_id;
	 */
	public function ajax_galeria_empresa(){

		$this->request->onlyAllow('ajax');
		$this->layout = 'ajax';

		if($this->request->is('ajax')){

			if(!in_array('ContatoImagem', $this->uses)) $this->loadmodel('ContatoImagem');
			
			// cria o registro
			$id = (isset($this->request->data['avatar_id']))? $this->request->data['avatar_id'] : null;
			$contato_id = (isset($this->request->data['avatar_contato_id']))? $this->request->data['avatar_contato_id'] : null;
			if(!$this->ContatoImagem->exists($id)){

				$this->ContatoImagem->create();
				$new['ContatoImagem'] = array('id'=>$id, 'contato_id'=>$contato_id);
				if( $this->ContatoImagem->save($new)){

					$id = $this->ContatoImagem->id;
				}
				$this->ContatoImagem->clear();
			}
			$this->ContatoImagem->id = $id;
			
			// variáveis de entrada
			$capa = (isset($this->request->data['avatar_capa']))? $this->request->data['avatar_capa'] : false;
			$status = (isset($this->request->data['avatar_status']))? $this->request->data['avatar_status'] : false;
			$name = $contato_id.'_'.$id.'_'.sha1($id.date('YmdHis').Configure::read('Security.salt'));

			// vars for cropper method
			$data =	(isset($this->request->data['avatar_data']))? $this->request->data['avatar_data'] : null;
			$file =	(isset($_FILES['avatar_file']))? $_FILES['avatar_file'] : null;
			$dir = 'uploads/empresa/fotos/';
			$src =	$this->ContatoImagem->field('imagem');
			$this->Session->write('src', $src);

			// se existe, então tenta fazer o upload e salvar
			if($this->ContatoImagem->exists()){
				
				// crop and/or upload
				$options = array('dir'=>$dir, 'src'=>$src, 'name'=>$name, 'width'=>768, 'height'=>768);
				$response = $this->Cropper->cropper_galeria_empresa($data, $file, $options);

				if(!empty($response['result'])){

					// variável a ser salva no BD
					$ContatoImagem['ContatoImagem'] = array(
						'id'=>$id,
						'capa'=>$capa,
						'status'=>$status,
						'imagem'=>$response['result']
					);					

					if($this->ContatoImagem->save($ContatoImagem)){

						$response['result'] = $this->webroot.$response['result'];

						$response['id'] = $this->ContatoImagem->id;
						$response['contato_id'] = $contato_id;
					}
					else{

						$response = array('state'=>0);
					}
				}
			}
			else{

				$response = array('state'=>0);
			}

			echo json_encode($response);
		}

		$this->render(false);
	}

	/**
	 * Excluir o arquivo de imagem e o registro no Banco de dados;
	 * @param int $id;
	 */
	public function delete_imagem_empresa($id=null){

		$this->request->onlyAllow('post', 'delete_imagem_empresa');

		if(!in_array('ContatoImagem', $this->uses)) $this->loadmodel('ContatoImagem');
		$this->ContatoImagem->id = $id;

		// se existe
		if (!$this->ContatoImagem->exists($id)) {
			
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/center_flash_danger');
			$this->redirect(array('controller'=>'mensagens', 'action'=>'mensagem'));
		}

		// verifica o responsável;
		$contato_id = $this->ContatoImagem->field('contato_id');
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		// verifica arquivo
		$file_src = $this->ContatoImagem->field('imagem');

		if(file_exists(WWW_ROOT.$file_src)){

			if(unlink(WWW_ROOT.$file_src)){

				if($this->ContatoImagem->delete()){

					$this->Session->setFlash('Imagem excluida com sucesso!', 'layout/flash/flash_success');
					$this->redirect(array('controller'=>'uploads', 'action'=>'galeria_empresa', $contato_id));
				}

				$this->Session->setFlash('Houve uma falha, mas o arquivo foi exluido.', 'layout/flash/flash_warning');
				$this->redirect(array('controller'=>'uploads', 'action'=>'galeria_empresa', $contato_id));
			}
			else{

				$this->Session->setFlash('Falha ao excluir o arquivo.', 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'uploads', 'action'=>'galeria_empresa', $contato_id));
			}
		}
		else{

			$this->Session->setFlash('Falha ao excluir. O arquivo da imagem não foi encontrado.', 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'uploads', 'action'=>'galeria_empresa', $contato_id));
		}
	}

}