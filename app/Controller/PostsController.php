<?php
App::uses('AppController', 'Controller');

class PostsController extends AppController {

	public $uses = array('PostDocumento');

	public $components = array(
		'Paginator',
		'FilterResults.Filter' => array(
			'auto' => array(
				'paginate' => false,
				'explode'  => true
			),
			'explode' => array(
				'character'   => ' ',
				'concatenate' => 'AND'
			)
		),
		'Tool'
	);

	public $helpers = array('Formata', 'FilterResults.Search', 'CakePtbr.Formatacao');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('termos_de_uso');
	}




/**
==========================
POST DOCUMENTO
==========================
*/
	public function documento_index(){

		# Paginate Options
		$options = array(
			'conditions'=>array(),
			'order'=>array('created'=>'DESC')
		);
		$this->paginate = $options;

		# Filtro
		Configure::load('filters');
		// $this->Filter->addFilters(Configure::read('PostDocumento')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_status' => array(
					'PostDocumento.status' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status'))
					)
				)
			)
		);

		# Mescla Conditions
		if($this->Filter->getConditions()){
			$options['conditions'] = array_merge($options['conditions'], $this->Filter->getConditions());		
			$this->Filter->setPaginate('conditions', $options['conditions']);
		}

		$this->PostDocumento->recursive = 0;
		$posts = $this->Paginator->paginate();

		$this->set('posts', $posts);
	}

	public function documento_add(){

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if ($this->PostDocumento->save($this->request->data)) {

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('action'=>'documento_index'));
			}
			else {

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_warning');
			}
		}
	}

	public function documento_edit($id=null){

		# Verifica se o registro existe
		if (!$this->PostDocumento->exists($id) AND $this->request->action!='add') {
			
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if ($this->PostDocumento->save($this->request->data)) {

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('action'=>$this->action, $id));
			}
			else {

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_warning');
			}
		}

		$options = array('conditions' => array('PostDocumento.' . $this->PostDocumento->primaryKey => $id));
		$this->request->data = $this->PostDocumento->find('first', $options);
	}

	public function documento_delete($id=null){

		$this->request->onlyAllow('post', 'delete');

		$this->PostDocumento->id = $id;
		if (!$this->PostDocumento->exists()) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		if ($this->PostDocumento->delete()) {

			$this->Session->setFlash($this->mmCrud['deleted'], 'layout/flash/flash_success');
		}
		else {

			$this->Session->setFlash($this->mmCrud['not_deleted'], 'layout/flash/flash_warning');
		}

		return $this->redirect($this->referer());
	}



/**
==========================
OUTROS
==========================
*/
	public function termos_de_uso(){

		# Termos de uso
		$termos_de_uso = $this->PostDocumento->conteudo(Configure::read('Documentos.termos_de_uso'));

		# Política de Privacidade
		$politica_privacidade = $this->PostDocumento->conteudo(Configure::read('Documentos.politica_privacidade'));

		# Seta variáveis
		$this->set('title_for_layout', 'Termos de Uso');
		$this->set('termos_de_uso', $termos_de_uso);
		$this->set('politica_privacidade', $politica_privacidade);
	}
}