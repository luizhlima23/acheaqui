<?php 
App::uses('AppController', 'Controller');

class LogradourosController extends AppController{

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
	);

	public $helpers = array('Formata', 'FilterResults.Search', 'CakePtbr.Formatacao');

	public function beforeFilter() {
	    parent::beforeFilter();
	}




/**
==========================
CRUD
==========================
*/
	public function index() {

		# Paginate Options
		$options = array(
			'conditions'=>array(),
		);
		$this->paginate = $options;

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('Logradouro')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_status' => array(
					'Logradouro.status' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status'))
					)
				)
			)
		);

		# Define conditions
		$this->Filter->setPaginate('conditions', $this->Filter->getConditions()); 

		$this->Logradouro->recursive = 0;
		$this->set('logradouros', $this->Paginator->paginate());
	}

	public function view($id = null) {

		# Verifica se a função existe
		if (!$this->Logradouro->exists($id)) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		$options = array('conditions' => array('Logradouro.' . $this->Logradouro->primaryKey => $id));

		$this->Logradouro->recursive = 0;
		$this->set('logradouro', $this->Logradouro->find('first', $options));
	}

	public function add() {

		return $this->edit();
	}

	public function edit($id = null) {

		# Verifica se a existe
		if (!$this->Logradouro->exists($id) AND $this->request->action!='add') {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if ($this->Logradouro->save($this->request->data)) {

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect($this->referer());
			}
			else {

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_warning');
			}
		}

		$options = array('conditions' => array('Logradouro.' . $this->Logradouro->primaryKey => $id));
		$this->request->data = $this->Logradouro->find('first', $options);
	}

	public function delete($id = null) {

		$this->request->onlyAllow('post', 'delete');

		$this->Logradouro->id = $id;
		if (!$this->Logradouro->exists()) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}


		if ($this->Logradouro->delete()) {

			$this->Session->setFlash($this->mmCrud['deleted'], 'layout/flash/flash_success');
		}
		else {

			$this->Session->setFlash($this->mmCrud['not_deleted'], 'layout/flash/flash_warning');
		}

		return $this->redirect(array('action' => 'index'));
	}

}
