<?php
App::uses('AppController', 'Controller');

class TagsController extends AppController {

	public $uses = array('Tag', 'Etiqueta');

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

		$this->Auth->allow();
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
			'order'=>'tag ASC',
			'limit'=>25
		);
		$this->paginate = $options;

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('Tag')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_status' => array(
					'Tag.status' => array(
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

		$this->Tag->recursive = -1;
		$this->set('tags', $this->Paginator->paginate());
	}

	public function update() {

		# Se diferente de Post
		if (!$this->request->is(array('post', 'put'))) {
			throw new MethodNotAllowedException();
		}

		# Consulta Etiquetas
		$options = array(
			'conditions' => array(
				'Etiqueta.id !=' => null,
				'Etiqueta.tags !=' => null,
				'Etiqueta.status' => true,
				'Etiqueta.inicio <= CURDATE()',
				'Etiqueta.fim >= CURDATE()',
			),
			'fields'=>array('id', 'tags'),
			'order'=>array('Etiqueta.modified ASC'),
		);
		$etiquetas = $this->Etiqueta->find('list', $options);

		# Separa e trata as tags
		$Tags = array();
		foreach ($etiquetas as $k=>$tags) {
			
			$tags = explode('|', $tags);		// Separa tags
			$tags = array_filter($tags);		// Elimina empty values
			$tags = array_unique($tags);		// Remove o valores duplicados de um array

			foreach ($tags as $t) {
				
				$Tags[] = array(
					'etiqueta_id'=>$k,
					'tag'=>$t,
					'status'=>1
				);
			}
		}

		# TRUNCATE TABLE tags
		$this->Tag->query('TRUNCATE TABLE tags;');

		# Gera array para BD
		foreach ($Tags as $data) {
			
			$data['Tag'] = $data;

			if( $this->Tag->saveAll($data, array('validates'=>false)) ){

				$this->Session->setFlash('Tags atualizadas com sucesso!', 'layout/flash/flash_success');
			}
			else{
				
				$this->Session->setFlash('Falha ao atualizar as Tags!', 'layout/flash/flash_danger');
			}
		}

		$this->redirect(array('controller'=>'tags', 'action'=>'index', 'plugin'=>false, 'admin'=>false));
		$this->render(false);
	}

}