<?php
App::uses('AppModel', 'Model');

class Lib extends AppModel {

	public $displayField = 'var';

	public $useTable = 'lib_variaveis';

	public $actsAs = array('Auditable.Auditable');


/**
 * Função auxiliar para retornar uma lista com as variáveis
 *
 * Opções:
 * 	- $grupo (grupo de variáveis)
 *
 * @param string $grupo
 * @return array $lista
 */
	public function listaVariaveis($grupo=null, $fields=null){

		$options = array(
			'conditions' => array('Lib.status' => 1),
			'recursive' => -1,
			'fields' => $fields,
			'order' => array('var ASC'),
			'limit' => false,
			'callbacks' => true
		);
		
		# Parametros
		if(!is_null($grupo)) $options['conditions']['Lib.categoria LIKE'] = $grupo;
		if(!is_null($fields) AND is_array($fields)) $options['fields'] = $fields;

		return $this->find('list', $options);
	}

}
