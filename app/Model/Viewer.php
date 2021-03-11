<?php
App::uses('AppModel', 'Model');

class Viewer extends AppModel {

	public $useTable = 'views';

	public $displayField = 'model_alias';

	public $validate = array(
		'model_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Valor inválido.',
				'allowEmpty' => false,
				'required' => true
			)
		),
		'model_alias' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Campo obrigatório.',
				'allowEmpty' => false,
				'required' => true,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 0, 50),
				'message' => 'Este campo deve conter entre 0 e 50 caracteres.',
			)
		),
	);
	
	// public $actsAs = array('Auditable.Auditable');




/**
 *	OTHER METHODS 
 *	==========================================
 */
	/**
	 * Salva log de views
	 *
	 * @param string $model_alias, int $model_id, int $user_id
	 * @return bool true or false
	 */
	public function saveViewLog($model_alias=null, $model_id=null, $user_id=null) {

		$toSave['Viewer'] = array(
			'model_alias'=>$model_alias,
			'model_id'=>$model_id,
			'user_id'=>$user_id
		);

		# Tenta Salvar
		$this->create();
		if($this->save($toSave)) return true;

		return false;
	}

	/**
	 * Conta nº de views
	 *
	 * @param string $model_alias, int $model_id, int $user_id
	 * @return int $count
	 */
	public function countViews($model_alias=null, $model_id=null, $user_id=null) {

		# Monta options
		$options = array('conditions'=>array());

		if(!is_null($model_alias)) array_merge($options['conditions'], array('model_alias'=>$model_alias));
		if(!is_null($model_id)) array_merge($options['conditions'], array('model_id'=>$model_id));
		if(!is_null($user_id)) array_merge($options['conditions'], array('user_id'=>$user_id));

		# Consulta
		return $this->find('count', $options);
	}

	/**
	 * Conta nº de views no mês atual
	 *
	 * @param string $model_alias, int $model_id, int $user_id
	 * @return int $count
	 */
	public function countViewsMes($model_alias=null, $model_id=null, $user_id=null, int $mes=null) {

		# Monta options
		$mes_atual = (is_null($mes))? date('m') : $mes;
		$ano_atual = date('Y');
		$options = array(
			'conditions'=>array(
				'MONTH(created)'=>$mes_atual,
				'YEAR(created)'=>$ano_atual,
			)
		);

		if(!is_null($model_alias)) 
			$options['conditions'] = array_merge($options['conditions'], array('model_alias'=>$model_alias));

		if(!is_null($model_id)) 
			$options['conditions'] = array_merge($options['conditions'], array('model_id'=>$model_id));

		if(!is_null($user_id)) 
			$options['conditions'] = array_merge($options['conditions'], array('user_id'=>$user_id));
		
		# Consulta
		return $this->find('count', $options);
	}
}
