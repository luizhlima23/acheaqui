<?php
App::uses('AppModel', 'Model');

class Logradouro extends AppModel {

	public $displayField = 'Logradouro.descricao';

	public $actsAs = array('Auditable.Auditable');

	public $virtualFields = array(
		'logradouro' => 'CONCAT(Logradouro.end_tipo, " ", Logradouro.descricao)'
	);

	public $validate = array(
		'end_tipo' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => true,
			),
		),
		'descricao' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => true,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 1, 150),
				'message' => 'O nome deve conter no máximo 150 caracteres.',
				'allowEmpty' => false,
				'required' => true
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

/**
 * Função auxiliar para retornar uma lista com os logradouros
 *
 * @return array $lista
 */
	public function listaLogradouros(){

		$options = array(
			'conditions' => array('Logradouro.status' => 1),
			'recursive' => -1,
			'fields' => array('id', 'logradouro'),
			'order' => array('logradouro ASC'),
			'limit' => false,
			'callbacks' => true
		);

		return $this->find('list', $options);
	}

}