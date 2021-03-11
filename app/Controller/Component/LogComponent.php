<?php
App::import('RequestHandler');

class LogComponent extends Component{

	/**
	 * Guarda os informações para o Log
	 *
	 *	array(
	 *		'user_id'=>			'int',
	 *		'created'=>			'datetime',
	 *		'busca'=>			'string',
	 *		'num_results'=>		'int',
	 *		'referer'=>			'string',
	 *		'dispositivo'=>		'string',
	 *		'ip'=>				'string',
	 *		'browser'=>			'string',
	 *		'os'=>				'string'
	 *	)
	 *
	 * @var array
	 */
	protected $dados = array(
		'user_id'=>			null,
		'created'=>			null,
		'busca'=>			null,
		'num_results'=>		null,
		'referer'=>			null,
		'dispositivo'=>		null,
		'ip'=>				null,
		'browser'=>			null,
		'os'=>				null
	);

	public function busca($busca, $resultados, $ip, $dispositivo){

		$this->setUserID(); // Seta o responsável pela consulta
		$this->setCreated(date('Y-m-d H:m:s')); // Seta a data e a hora da consulta
		$this->setBusca($busca); // Seta a string da Busca
		$this->setCount($resultados); // Seta o número de resultados
		$this->setIP($ip); // Seta o número de resultados
		$this->setDispositivo($dispositivo); // Seta o número de resultados

		return $this->dados;
	}

	protected function setUserID($val=null){
		if(AuthComponent::user('id')) {
			$val = AuthComponent::user('id');
		}		
		return $this->dados['user_id'] = $val;
	}
	
	protected function setCreated($val){
		return $this->dados['created'] = $val;
	}
	
	protected function setBusca($val){
		return $this->dados['busca'] = $val;
	}

	protected function setCount($val){
		return $this->dados['num_results'] = count($val);
	}

	protected function setIP($ip){
		return $this->dados['ip'] = $ip;
	}

	protected function setDispositivo($dispositivo){
		return $this->dados['dispositivo'] = $dispositivo;
	}
}

?>