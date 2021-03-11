<?php 
App::uses('AppController', 'Controller');

class LogPesquisasController extends AppController{

	public $uses = array('LogPesquisa');

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

    public $helpers = array('FilterResults.Search', 'CakePtbr.Formatacao');
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}


/*	
==========================
FUNÇÕES DE CRUD
==========================
*/

	public function index() {

		$options = array(
			'order'=>array(
				'LogPesquisa.created'=>'DESC'
			)
		);
		$this->paginate = $options;
		
		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('LogPesquisa')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_mobile' => array(
					'LogPesquisa.is_mobile' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status_2'))
					)
				)
			)
		);
		$this->Filter->setPaginate('conditions', $this->Filter->getConditions());	

		$this->LogPesquisa->recursive = 1;
		$this->set('logs', $this->Paginator->paginate());
	}

	public function view($id = null){
		
		if (!$this->LogPesquisa->exists($id)) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('action' => 'index'));
		}

		$this->LogPesquisa->recursive = 1;
		$options = array('conditions' => array('LogPesquisa.' . $this->LogPesquisa->primaryKey => $id));
		
		$this->set('log', $this->LogPesquisa->find('first', $options));
	}

}

?>