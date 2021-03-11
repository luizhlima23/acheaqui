<?php
App::uses('AppModel', 'Model');

class LogPesquisa extends AppModel {

	public $primaryKey = 'id';

	public $useTable = 'log_pesquisas';

	public $displayField = 'id';
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
	);

	public function saveLog($user_id=null, $search_string=null, $ip=null, $is_mobile=null){

		if(!empty($search_string)){

			$data['LogPesquisa'] = array(
				'user_id' =>  $user_id,
				'search_string' => $search_string,
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
