<?php
App::uses('AppController', 'Controller');

class BairrosController extends AppController {

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
        'Session'
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
		$this->Filter->addFilters(Configure::read('Bairro')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_status' => array(
					'Bairro.status' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status'))
					)
				)
			)
		);

		# Define conditions
		$this->Filter->setPaginate('conditions', $this->Filter->getConditions()); 

		$this->Bairro->recursive = 0;
		$this->set('bairros', $this->Paginator->paginate());
	}

	public function view($id = null) {

		# Verifica se a função existe
		if (!$this->Bairro->exists($id)) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		$options = array('conditions' => array('Bairro.' . $this->Bairro->primaryKey => $id));

		$this->Bairro->recursive = 0;
		$this->set('bairro', $this->Bairro->find('first', $options));
	}

	public function add() {

		return $this->edit();
	}

	public function edit($id = null) {

		# Verifica se a existe
		if (!$this->Bairro->exists($id) AND $this->request->action!='add') {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if ($this->Bairro->save($this->request->data)) {

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect($this->referer());
			}
			else {

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_warning');
			}
		}

		$options = array('conditions' => array('Bairro.' . $this->Bairro->primaryKey => $id));
		$this->request->data = $this->Bairro->find('first', $options);

		# variáveis para View
		$cidades = $this->Bairro->Cidade->find('list');
		$this->set(compact('cidades'));
	}

	public function delete($id = null) {

		$this->request->onlyAllow('post', 'delete');

		$this->Bairro->id = $id;
		if (!$this->Bairro->exists()) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}


		if ($this->Bairro->delete()) {

			$this->Session->setFlash($this->mmCrud['deleted'], 'layout/flash/flash_success');
		}
		else {

			$this->Session->setFlash($this->mmCrud['not_deleted'], 'layout/flash/flash_warning');
		}

		return $this->redirect(array('action' => 'index'));
	}

}
