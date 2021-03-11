<?php
App::uses('AppController', 'Controller');

class LoggersController extends AppController {

	public $uses = array('Logger', 'User');

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

	public $helpers = array('Formata', 'CakePtbr.Formatacao', 'FilterResults.Search', 'Empresa', 'Auditor');

	public function beforeFilter(){
		
		parent::beforeFilter();
	}
	



/*	
====================================
CRUD
====================================
*/
	public function index() {

		# Relacionamento
		$this->Logger->bindModel(
			array(
				'belongsTo' => array(
					'User' => array(
						'className' => 'User',
						'foreignKey' => 'responsible_id',
						'conditions' => array(),
						'fields' => array('User.id', 'User.nome', 'User.sbnome'),
					),
				)
			),
			false
		);

		# Paginate Options
		$options = array(
			'conditions'=>array(),
			'order'=>array('created'=>'DESC')
		);
		$this->paginate = $options;
		
		# Variáveis da função
		$types = array(1=>'Criou' , 2=>'Modificou' , 3=>'Deletou');

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('Log')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_act' => array(
					'Logger.type' => array(
						'select' => $this->Filter->select('Todas', $types)
					)
				),
			)
		);

		# Mescla Conditions
		if($this->Filter->getConditions()){
			$options['conditions'] = array_merge($options['conditions'], $this->Filter->getConditions());		
			$this->Filter->setPaginate('conditions', $options['conditions']);
		}

		$this->Logger->recursive = 0;
		$logs = $this->Paginator->paginate();

		$this->set('loggers', $logs);
	}
	
	public function view($id=null) {
		
		# Verifica se existe
		$this->Logger->id = $id;
		if (!$this->Logger->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		# Relacionamento
		$this->Logger->bindModel(
			array(
				'belongsTo' => array(
					'User' => array(
						'className' => 'User',
						'foreignKey' => 'responsible_id',
						'conditions' => array(),
						'fields' => array('User.id', 'User.nome', 'User.sbnome'),
					),
				)
			),
			false
		);

    	# parâmetros de consulta
		$options = array(
			'conditions'=>array(
				'Logger.' . $this->Logger->primaryKey => $id,
			)
		);
		$this->Logger->recursive = 0;
		$log = $this->Logger->find('first', $options);
		
		$this->set('log', $log);
	}

}

?>