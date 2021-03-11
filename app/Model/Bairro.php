<?php
App::uses('AppModel', 'Model');

class Bairro extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'bairros';

	public $belongsTo = array(
		'Cidade' => array(
			'className' => 'Cidade',
			'foreignKey' => 'cidade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $validate = array(
		'nome' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => true,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 3, 150),
				'message' => 'O nome deve conter entre 3 e 150 caracteres.',
			)
		),
		'cidade_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Selecione a Cidade',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => false,
				'required' => true
			)
		),
	);

	public $actsAs = array('Auditable.Auditable');


/**
 * Função auxiliar para retornar uma lista com os bairros
 *
 * Opções:
 * 	- $cidade_id (cód. cidade)
 *
 * @param int $cidade_id
 * @return array $lista
 */
	public function listaBairros($cidade_id=null){

		$options = array(
			'conditions' => array('Bairro.status' => 1),
			'recursive' => -1,
			'fields' => array('id', 'nome'),
			'order' => array('nome ASC'),
			'limit' => false,
			'callbacks' => true
		);
		
		if(!is_null($cidade_id)){
			$conditions = array_merge($options['conditions'], array('Bairro.cidade_id' => $cidade_id));
			$options['conditions'] = $conditions;
		}

		return $this->find('list', $options);
	}

}
