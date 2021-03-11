<?php
App::uses('AppController', 'Controller');

class IncorporationsController extends AppController {

	public $uses = array('Incorporation');

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
		'Tool',
		'Banner',
		'Seo'
	);

	public $helpers = array('Formata', 'FilterResults.Search', 'CakePtbr.Formatacao');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('public_view');
	}




/**
==========================
INCORPORAÇÕES
==========================
*/
	public function index(){

		# Paginate Options
		$options = array(
			'conditions'=>array(),
			'order'=>'modified ASC'
		);
		$this->paginate = $options;

		# Filtro
		Configure::load('filters');
		// $this->Filter->addFilters(Configure::read('Role')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_status' => array(
					'Incorporation.status' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status'))
					)
				)
			)
		);

		# Define conditions
		$this->Filter->setPaginate('conditions', $this->Filter->getConditions()); 

		$this->set('data', $this->Paginator->paginate());
	}

	public function add() {
		return $this->edit();        
	}

	public function edit($id = null) {

		# Verifica se a Função existe
		if (!$this->Incorporation->exists($id) AND $this->request->action!='add') {
			
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if ($this->Incorporation->save($this->request->data)) {

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect($this->referer());
			}
			else {

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_warning');
			}
		}

		$options = array('conditions' => array('Incorporation.' . $this->Incorporation->primaryKey => $id));
		$this->request->data = $this->Incorporation->find('first', $options);
	}

	public function view($id = null) {

		# Verifica se a função existe
		if (!$this->Incorporation->exists($id)) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		$options = array(
			'conditions' => array(
				'Incorporation.' . $this->Incorporation->primaryKey => $id,
				'Incorporation.status' => true,
			)
		);
		$data = $this->Incorporation->find('first', $options);

		$this->set('data', $data);

		if(empty($data)){

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}
	}

	public function delete($id = null) {

		$this->request->onlyAllow('post', 'delete');

		$this->Incorporation->id = $id;
		if (!$this->Incorporation->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}


		if ($this->Incorporation->delete()) {

			$this->Session->setFlash($this->mmCrud['deleted'], 'layout/flash/flash_success');
		}
		else {

			$this->Session->setFlash($this->mmCrud['not_deleted'], 'layout/flash/flash_warning');
		}

		return $this->redirect(array('action' => 'index'));
	}

	public function public_view(){

		$options = array(
			'conditions' => array(
				'Incorporation.status' => true,
			),
			'order'=> array('modified'=>'DESC')
		);
		$data = $this->Incorporation->find('first', $options);

		$this->set('data', $data);

		// Banner Premium
		$banner_premium = $this->getBannerPremium();
		$this->set('banner_premium', $banner_premium);

		// Meta Tags do Facebook
		$FB_tags['title'] = strtoupper($data['Incorporation']['description']).' / www.aonde.info';
		$FB_tags['description'] = strtoupper($data['Incorporation']['description']).' / www.aonde.info'; 
		$FB_tags['img_width'] = 180; 
		$FB_tags['img_height'] = 180; 
		$FB_tags['img_type'] = 'image/png'; 
		$FB_tags['url'] = $data['Incorporation']['url']; 
		$this->Seo->setFacebookMetaTags($FB_tags);

		$this->render('view');

		if(empty($data)){

			throw new Exception("Página não encontrada", 1);		
		}
	}

}