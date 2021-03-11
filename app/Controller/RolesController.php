<?php
App::uses('AppController', 'Controller');

class RolesController extends AppController {

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
		)
	);

	public $helpers = array('Formata', 'FilterResults.Search', 'CakePtbr.Formatacao');

	public function beforeFilter() {
	    parent::beforeFilter();
	}

	

/*  
==========================
FUNÇÕES DE CRUD
==========================
*/

	public function index(){

		# Paginate Options
		$options = array(
			'conditions'=>array(),
			'order'=>'ordem ASC'
		);
		$this->paginate = $options;

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('Role')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_status' => array(
					'Role.status' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status'))
					)
				)
			)
		);

		# Define conditions
		$this->Filter->setPaginate('conditions', $this->Filter->getConditions()); 

		$this->set('roles', $this->Paginator->paginate());
	}

	public function view($id = null) {

		# Verifica se a função existe
		if (!$this->Role->exists($id) OR $id == 1) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
		$this->set('role', $this->Role->find('first', $options));

		# Count usuários desta função
		$count_option = array(
			'conditions'=>array(
				'User.role_id'=>$id
			)
		);

		if(!in_array('User', $this->uses)) $this->loadModel('User');
		$users_count = $this->User->find('count', $count_option);
		$this->set('users_count', $users_count);
	}

	public function add() {
		return $this->edit();        
	}

	public function edit($id = null) {

		# Verifica se a Função existe
		if (!$this->Role->exists($id) AND $this->request->action!='add') {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if ($this->Role->save($this->request->data)) {

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect($this->referer());
			}
			else {

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_warning');
			}
		}

		$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
		$this->request->data = $this->Role->find('first', $options);

		# Admin Menus
		$this->set('role_menus', $this->_listaRolesMenu());
	}

	public function delete($id = null) {

		$this->request->onlyAllow('post', 'delete');

		$this->Role->id = $id;
		if (!$this->Role->exists() OR $id == 1) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}


		if ($this->Role->delete()) {

			$this->Session->setFlash($this->mmCrud['deleted'], 'layout/flash/flash_success');
		}
		else {

			$this->Session->setFlash($this->mmCrud['not_deleted'], 'layout/flash/flash_warning');
		}

		return $this->redirect(array('action' => 'index'));
	}

	protected function _listaRolesMenu(){
		
		$role_menus = Configure::read('Role.menu');
		$keys = array_keys($role_menus);
		foreach ($keys as $k) {
			$role_menus[$k] = $k;
		}

		return $role_menus;
	}
}