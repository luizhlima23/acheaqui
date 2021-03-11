<?php
App::uses('AppModel', 'Model');
App::uses('BrValidation', 'Localized.Validation');
App::uses('CakeTime', 'Utility');

class Cadastro extends AppModel {

	public $useTable = 'users_cadastro';
	
	public $displayField = 'cpf';
	
	public $actsAs = array(
		'Auditable.Auditable',
		'CakePtbr.AjusteData' => array('data_nascimento'),
	);

	public $validate = array(
		'cpf' => array(
			'valid' => array(
				'rule' => array('ssn', null, 'br'),
				'message' => 'Insira um CPF válido!',
				'allowEmpty' => false,
				'required' => false
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'CPF já cadastrado no sistema!'
			)
		),
		'telefone' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo',
				'allowEmpty' => true,
				'required' => false
			),
			'Numeric' => array(
				'rule' => array('Numeric'),
				'message' => 'Digite apenas números ex: 6136120123',
			),
			'between' => array(
                'rule' => array('lengthBetween', 8, 11),
                'message' => 'O Telefone deve conter entre 8 e 11 digitos'
			),
		),
		'data_nascimento' => array(
			// 'required' => array(
			// 	'on' => 'create',
			// 	'rule' => 'notBlank',
			// 	'message' => 'Informe sua data de nascimento',
			// 	'required' => true,
			// ),
			// 'date' => array(
			// 	'rule' => array('date'),
			// 	'message' => 'Data informada está incorreta!',
			// 	'allowEmpty' => false,
			// 	'required' => false
			// ),
			'maiorIdade' => array(
				'rule' => array('maiorIdade', 18),
				'message' => 'Você deve ter mais de 18 anos de idade.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'sexo' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Escolha uma das opções',
				'allowEmpty' => false,
				'required' => false
			),
		),
	);

	public function beforeSave($options = array()) {

		# Prepara campos com máscara antes de serem salvos

		if (!empty($this->data['Cadastro']['cpf'])) // CPF
			$this->data['Cadastro']['cpf'] = preg_replace("/[^0-9]/", "", $this->data['Cadastro']['cpf']);

		if (!empty($this->data['Cadastro']['telefone'])) // Telefone
			$this->data['Cadastro']['telefone'] = preg_replace("/[^0-9]/", "", $this->data['Cadastro']['telefone']);

		return true;
	}

	public function afterFind($results, $primary = true) {

		foreach ($results as $key => $val) {

			# Data para o formato brasileiro
			if (isset($val['Cadastro']['data_nascimento'])) {
				$results[$key]['Cadastro']['data_nascimento'] = $this->dateFormatAfterFind($val['Cadastro']['data_nascimento']);
			}
		}

		return $results;
	}

	public function beforeValidate($options = array()){

		# CPF (Apenas números para a validação)
		if(isset($this->data['Cadastro']['cpf'])){

			$cpf = preg_replace("/[^0-9]/", "", $this->data['Cadastro']['cpf']);
			$this->data['Cadastro']['cpf'] = $cpf;
		}

		# Fone1 (somente os números)
		if(isset($this->data['Cadastro']['telefone'])){

			$telefone = preg_replace("/[^0-9]/", "", $this->data['Cadastro']['telefone']);
			$this->data['Cadastro']['telefone'] = $telefone;
		}
		
		return true;
	}

	/** 
	 *	Valida a idade limite
	 *
	 * @param date $check, int $limit
	 * @return bool true or false
	 *
	 **/
	public function maiorIdade($check, $limit){

		$each = each($check);
		$date = $each['value'];

		# Se a idade for maior que 18, então valida
		if($this->idade($date) >= $limit){

			return true;
		}

		return false;
	}

}
