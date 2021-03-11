<?php
App::uses('AppModel', 'Model');

class Cidade extends AppModel {

	public $displayField = 'nome';

	public $belongsTo = array(
		'Estado' => array(
			'className' => 'Estado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Bairro' => array(
			'className' => 'Bairro',
			'foreignKey' => 'cidade_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'cidade_id',
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
	
	public $actsAs = array('Auditable.Auditable');


/**
 * Função auxiliar para retornar uma lista das cidades
 *
 * Opções:
 * 	- $uf (cód. estado)
 *
 * @param int $uf
 * @return array $lista
 */
	public function listaCidades($opt=null, $uf=null){

		$options = array(
			'conditions' => array('Cidade.status' => 1),
			'recursive' => -1,
			'fields' => array('id', 'nome'),
			'order' => array('nome ASC'),
			'limit' => false,
			'callbacks' => true
		);
		
		if(!is_null($uf)){
			$conditions = array_merge($options['conditions'], array('Cidade.estado_id' => $uf));
			$options['conditions'] = $conditions;
		}

		# Mescla Options
		if(is_array($opt)){
			$options = array_merge($options, $opt);
		}

		return $this->find('list', $options);
	}

}
