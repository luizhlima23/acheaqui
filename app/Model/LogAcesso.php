<?php
App::uses('AppModel', 'Model');

class LogAcesso extends AppModel {

	public $primaryKey = 'id';

	public $useTable = 'log_acessos';

	public $displayField = 'id';

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
	);

	public function saveLog($user_id=null, $ip=null, $is_mobile=null){

		if(!empty($user_id)){

			$data['LogAcesso'] = array(
				'user_id' =>  $user_id,
				'ip' => $ip,
				'is_mobile'=> $is_mobile
			);

			$this->create();
			if($this->save($data)){

				return true;
			}
		}

		return false;
	}
}
