<?php
App::uses('AppModel', 'Model');

class Role extends AppModel {

	public $displayField = 'name';

	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'role_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 2, 100),
				'message' => 'O nome deve conter entre 2 e 100 caracteres.',
			)
		),
		'description' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 10, 250),
				'message' => 'A descrição deve conter entre 10 e 250 caracteres.',
			)
		),
		'ordem' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => true,
				'required' => false
			)
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => true,
				'required' => false
			)
		),
	);

	public $actsAs = array('Acl' => array('type' => 'requester'), 'Auditable.Auditable');

	public function parentNode() {
		return null;
	}

	public function afterFind($results, $primary = true) {

	    foreach ($results as $key => $val) {
			if ( is_array($val) && isset($val['Role']) ){

				# Slug
				// $results[$key]['Role']['slug_name'] = mb_strtolower(inflector::slug($val['Role']['name']));

			}
		}

	    return $results;
	}

/**
 * Função auxiliar para retornar uma lista das funções
 *
 * @return array $lista
 */
	public function listaRoles(){

		# Parâmentros
		$options = array(
			'conditions' => array('Role.status' => 1),
			'recursive' => -1,
			'fields' => array('id', 'name'),
			'order' => array('name ASC'),
			'limit' => false,
			'callbacks' => true
		);

		return $this->find('list', $options);
	}

}
