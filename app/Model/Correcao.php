<?php
App::uses('AppModel', 'Model');

class Correcao extends AppModel {

	public $displayField = 'nome';

	public $useTable = 'correcoes_contato';

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'fields' => array('User.id', 'User.nome', 'User.sbnome'),
			'order' => ''
		),
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
			'fields' => array('Contato.id', 'Contato.nome'),
			'order' => ''
		),
	);

	public $validate = array(
		'resultado' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Selecione uma das opções.',
				'allowEmpty' => false,
				'required' => false,
			),
		),
		'motivo' => array(
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 25, 500),
				'message' => 'A descrição deve conter entre 25 e 500 caracteres.',
				'allowEmpty' => true,
				'required' => false,
			)
		),
		'data' => array(
			'notEmptyArray' => array(
				'rule' => array('notEmptyArray'),
				'message' => 'Campo data não pode ser vazio.',
				'allowEmpty' => false,
				'required' => false,
			),
		),
		'data_after' => array(
			'notEmptyArray' => array(
				'rule' => array('notEmptyArray'),
				'message' => 'Campo data_after não pode ser vazio.',
				'allowEmpty' => false,
				'required' => false,
			),
		),
	);

	public $actsAs = array('Auditable.Auditable');

	public function beforeSave($options = array()) {

		# Serialize - data
		if (!empty($this->data['Correcao']['data'])) {
			
			$this->data['Correcao']['data'] = serialize($this->data['Correcao']['data']);
		}

		# Serialize - data_before
		if (!empty($this->data['Correcao']['data_before'])) {
			
			$this->data['Correcao']['data_before'] = serialize($this->data['Correcao']['data_before']);
		}

		# Serialize - data_after
		if (!empty($this->data['Correcao']['data_after'])) {
			
			$this->data['Correcao']['data_after'] = serialize($this->data['Correcao']['data_after']);
		}

		# Serialize - data_after_final
		if (!empty($this->data['Correcao']['data_after_final'])) {
			
			$this->data['Correcao']['data_after_final'] = serialize($this->data['Correcao']['data_after_final']);
		}
	}

	public function afterFind($results, $primary = true) {

		foreach ($results as $key => $val) {

			if ( is_array($val) && isset($val['Correcao']) ) {

				# Unserialize - data
				if (isset($val['Correcao']['data'])) {
					
					$results[$key]['Correcao']['data'] = unserialize($val['Correcao']['data']);
				}
				# Unserialize - data_before
				if (isset($val['Correcao']['data_before'])) {
					
					$results[$key]['Correcao']['data_before'] = unserialize($val['Correcao']['data_before']);
				}
				# Unserialize - data_after
				if (isset($val['Correcao']['data_after'])) {
					
					$results[$key]['Correcao']['data_after'] = unserialize($val['Correcao']['data_after']);
				}
				# Unserialize - data_after_final
				if (isset($val['Correcao']['data_after_final'])) {
					
					$results[$key]['Correcao']['data_after_final'] = unserialize($val['Correcao']['data_after_final']);
				}

				# DATA
				if(isset($val['Correcao']['data'])){

					$results[$key]['Data'] = unserialize($val['Correcao']['data']);
				}
				else{
					$results[$key]['Data'] = null;
				}
			}
		}

		return $results;
	}

	public function salvaCorrecao($user_id=null, $contato_id=null, $data=null, $dataBefore=null, $dataAfter=null, $acao=null){

		if(empty($user_id) or !is_numeric($user_id)) return false; # valida - user_id

		# Monta array
		$this->create();
		$Correcao['Correcao']['user_id'] = $user_id;
		$Correcao['Correcao']['contato_id'] = $contato_id;
		$Correcao['Correcao']['acao'] = $acao;
		$Correcao['Correcao']['data'] = $data;
		$Correcao['Correcao']['data_before'] = $dataBefore;
		$Correcao['Correcao']['data_after'] = $dataAfter;
		$Correcao['Correcao']['status'] = 1;

		# Salva os dados
		if($this->save($Correcao)){

			return true;
		}

		return false;
	}

	public function verifica_correcao($contato_id=null){

		$options = array(
			'conditions'=>array(
				'AND'=>array(
					'Correcao.contato_id'=>$contato_id,
					'Correcao.resultado'=>null,
					'Correcao.status'=>1,
				)
			),
		);
		$correcao = $this->find('first', $options);

		if(!empty($correcao)) return true;

		return false;
	}

/**
 * Função auxiliar para retornar uma lista com os tipos de ações cadastrados
 *
 * @return array $lista
 */
	public function listaAcoes(){

		$options = array(
			'conditions' => array('Correcao.status' => 1),
			'recursive' => -1,
			'fields' => array('acao', 'acao'),
			'order' => array('acao ASC'),
			'group' => array('acao'),
			'limit' => false,
			'callbacks' => true
		);

		return $this->find('list', $options);
	}
}
