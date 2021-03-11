<?php
App::uses('AppController', 'Controller');

class BannersController extends AppController {

	public $uses = array('BannerA', 'BannerB', 'BannerC');

	# https://github.com/rickydunlop/Uploader
	public $helpers = array('Uploader.Upload');

	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
==========================
BÁSICO
==========================
*/
	/**
	 * Excluir arquivo de imagem e limpar o campo na tabela
	 *
	 * @param int $banner_id;
	 */
	public function delete_banner_basico_img($banner_id=null){

		$this->request->onlyAllow('post', 'delete_banner_basico_img');

		# Verifica se o banner existe
		$this->BannerA->id = $banner_id;
		if (!$this->BannerA->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Contato_id
		$contato_id = $this->BannerA->field('contato_id');

		# Verifica responsável;
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Dados da Imagem
		$imagem = $this->BannerA->field('imagem');
		$ext = substr($imagem, -4);
		$imagem = sha1($imagem . Configure::read('Security.salt'));
		
		# Tenta excluir o arquivo
		App::uses('File', 'Utility');

		$dir = WWW_ROOT.'uploads'.DS.'banners'.DS.'basico';
		$File = new File($dir.DS.$banner_id.'_original-'.$imagem.$ext, false, 0777);
		if($File->delete()){

			# Atualiza campos da imagem
			$this->BannerA->saveField('imagem', null, array('callbacks'=>false));

			$this->Session->setFlash('O Banner foi removido.', 'layout/flash/flash_success');
		}
		else{

			$this->Session->setFlash($this->mmCrud['file_not_found'], 'layout/flash/flash_danger');
		}
		$this->redirect(array('controller'=>'banners', 'action'=>'editar_banner_basico', 'contato_id'=>$contato_id));
	}

	/**
	 * Editar banner básico
	 *
	 * @param int $contato_id;
	 */
	public function editar_banner_basico($contato_id=null){

		# Variáveis para view
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');
		$this->set('contato_id', $contato_id);
		$this->set('nome', $this->Contato->get_nome($contato_id) );

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			# Define o campo TARGET
			if(isset($this->request->data['BannerA']['url_redirect'])){

				$this->request->data['BannerA']['url_target'] = ($this->verificarLink($this->request->data['BannerA']['url_redirect']))? '_parent' : '_blank';
			}

			# Salva os dados
			if($this->BannerA->save($this->request->data)){
				
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'banners', 'action'=>'editar_banner_basico', 'contato_id'=>$contato_id));
			}
			else{
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}		
		}
		else {

			$options = array(
				'conditions' => array(
					'BannerA.contato_id'=>$contato_id,
					'BannerA.status'=>true
				),
			);
			$BannerA = $this->BannerA->find('first', $options);

			if(!empty($BannerA)){

				$this->request->data = $BannerA;
			}
			else{

				$this->set('contratar', true);
			}
		}
	}


/**
==========================
ROTATIVO
==========================
*/
	/**
	 * Excluir arquivo de imagem e limpar o campo na tabela
	 *
	 * @param int $banner_id;
	 */
	public function delete_banner_rotativo_img($banner_id=null){

		$this->Session->setFlash('Função em desenvolvimento!', 'layout/flash/flash_danger');
		$this->redirect($this->referer());

		$this->request->onlyAllow('post', 'delete_banner_rotativo_img');

		# Verifica se o banner existe
		$this->BannerB->id = $banner_id;
		if (!$this->BannerB->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Contato_id
		$contato_id = $this->BannerB->field('contato_id');

		# Verifica responsável;
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Dados da Imagem
		$imagem = $this->BannerB->field('imagem');
		$ext = substr($imagem, -4);
		$imagem = sha1($imagem . Configure::read('Security.salt'));
		
		# Tenta excluir o arquivo
		App::uses('File', 'Utility');

		$dir = WWW_ROOT.'uploads'.DS.'banners'.DS.'rotativo';
		$File = new File($dir.DS.$banner_id.'_original-'.$imagem.$ext, false, 0777);
		if($File->delete()){

			# Atualiza campos da imagem
			$this->BannerB->saveField('imagem', null, array('callbacks'=>false));

			$this->Session->setFlash('O Banner foi removido.', 'layout/flash/flash_success');
		}
		else{

			$this->Session->setFlash($this->mmCrud['file_not_found'], 'layout/flash/flash_danger');
		}
		$this->redirect(array('controller'=>'banners', 'action'=>'editar_banner_rotativo', 'contato_id'=>$contato_id));
	}

	/**
	 * Editar banner básico
	 *
	 * @param int $contato_id;
	 */
	public function editar_banner_rotativo($contato_id=null){

		$this->Session->setFlash('Função em desenvolvimento!', 'layout/flash/flash_danger');
		$this->redirect($this->referer());

		# Variáveis para view
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');
		$this->set('contato_id', $contato_id);
		$this->set('nome', $this->Contato->get_nome($contato_id) );

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if(isset($this->request->data['BannerB']['url_redirect'])){

				$this->request->data['BannerB']['url_target'] = ($this->verificarLink($this->request->data['BannerB']['url_redirect']))? '_parent' : '_blank';
			}

			# Salva os dados
			if($this->BannerB->save($this->request->data)){
				
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'banners', 'action'=>'editar_banner_rotativo', 'contato_id'=>$contato_id));
			}
			else{
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}		
		}
		else {

			$options = array(
				'conditions' => array(
					'BannerB.contato_id'=>$contato_id,
					'BannerB.status'=>true
				),
			);
			$BannerB = $this->BannerB->find('first', $options);

			if(!empty($BannerB)){

				$this->request->data = $BannerB;
			}
			else{

				$this->set('contratar', true);
			}
		}
	}


/**
==========================
PREMIUM
==========================
*/
	/**
	 * Excluir arquivo de imagem e limpar o campo na tabela
	 *
	 * @param int $banner_id;
	 */
	public function delete_banner_premium_img($banner_id=null){

		$this->request->onlyAllow('post', 'delete_banner_premium_img');

		# Verifica se o banner existe
		$this->BannerC->id = $banner_id;
		if (!$this->BannerC->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Contato_id
		$contato_id = $this->BannerC->field('contato_id');

		# Verifica responsável;
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Dados da Imagem
		$imagem = $this->BannerC->field('imagem');
		$ext = substr($imagem, -4);
		$imagem = sha1($imagem . Configure::read('Security.salt'));
		
		# Tenta excluir o arquivo
		App::uses('File', 'Utility');

		$dir = WWW_ROOT.'uploads'.DS.'banners'.DS.'premium';
		$File = new File($dir.DS.$banner_id.'_original-'.$imagem.$ext, false, 0777);
		if($File->delete()){

			# Atualiza campos da imagem
			$this->BannerC->saveField('imagem', null, array('callbacks'=>false));

			$this->Session->setFlash('O Banner foi removido.', 'layout/flash/flash_success');
		}
		else{

			$this->Session->setFlash($this->mmCrud['file_not_found'], 'layout/flash/flash_danger');
		}
		$this->redirect(array('controller'=>'banners', 'action'=>'editar_banner_premium', 'contato_id'=>$contato_id));
	}

	/**
	 * Editar banner básico
	 *
	 * @param int $contato_id;
	 */
	public function editar_banner_premium($contato_id=null){

		# Variáveis para view
		if(!in_array('Contato', $this->uses)) $this->loadmodel('Contato');
		$this->set('contato_id', $contato_id);
		$this->set('nome', $this->Contato->get_nome($contato_id) );

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($contato_id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if(isset($this->request->data['BannerC']['url_redirect'])){

				$this->request->data['BannerC']['url_target'] = ($this->verificarLink($this->request->data['BannerC']['url_redirect']))? '_parent' : '_blank';
			}

			# Salva os dados
			if($this->BannerC->save($this->request->data)){
				
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'banners', 'action'=>'editar_banner_premium', 'contato_id'=>$contato_id));
			}
			else{
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}		
		}
		else {

			$options = array(
				'conditions' => array(
					'BannerC.contato_id'=>$contato_id,
					'BannerC.status'=>true
				),
			);
			$BannerC = $this->BannerC->find('first', $options);

			if(!empty($BannerC)){

				$this->request->data = $BannerC;
			}
			else{

				$this->set('contratar', true);
			}
		}
	}
}