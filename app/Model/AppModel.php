<?php

App::uses('Model', 'Model');

class AppModel extends Model {

	public $useDbConfig = 'default';
	public $recursive = -1;

	public function __construct($id = false, $table = null, $ds = null) {
		
		if(get_class($this) !== 'Logger' && empty(AuditableConfig::$Logger)) {
			
			# Guardar logs de alterações
			AuditableConfig::$Logger = ClassRegistry::init('Auditable.Logger', true);
		}

		parent::__construct($id, $table, $ds);
	}

	public function afterFind($results, $primary = true) {

		foreach ($results as $key => $val) {
			# Se o usuário logado não for o "Super Admin", então elimina o registro.
			if(AuthComponent::user('id')){
				if(AuthComponent::user('id') != 1){
					
					if (isset($val['User']['id']) AND isset($results[$key]['User']['id'])) {
						
						# Se USER->ID = 1, então elimina do resultado. É o superadmin
						if($results[$key]['User']['id'] == 1){
							unset($results[$key]);
						}
					}
					
					if (isset($val['Role']['id']) AND isset($results[$key]['Role']['id'])) {
						
						# Se ROLE->ID = 1, então elimina do resultado. É a função de superadmin
						if($results[$key]['Role']['id'] == 1){
							unset($results[$key]);              
						}
					}
					
				}
			}
		}

		return $results;
	}

/**
 * Função auxiliar para transformar a string de data no formato brasileiro
 *
 * @param string $date
 */
	public function dateFormatAfterFind($dateString) {
		return date('d-m-Y', strtotime($dateString));
	}

/**
 * checkFutureDate
 * Custom Validation Rule: Ensures a selected date is either the
 * present day or in the future.
 *
 * @param array $check Contains the value passed from the view to be validated
 * @return bool False if in the past, True otherwise
 */
	public function checkFutureDate($check) {
		$value = array_values($check);
		return CakeTime::fromString($value['0']) >= CakeTime::fromString(date('Y-m-d'));
	}

	/**
	 * Verifica se URL tem http
	 *
	 * @param string $url
	 * @return string http://+$url
	 */
	public function urlFormatBeforeSave($url){

		$http = substr($url, 0, 4);

		if(empty($url)) return null;

		if($http != 'http') $url = 'http://'.$url;

		return $url;
	}

	/**
	 * Retorna string sem acentos, caracteres especiais e etc.
	 *
	 * @param string $string
	 * @return string $string
	 */
	public function stringFilter($string=null){
		
		# Caracteres proibidos
		$LetraProibi = Array(
			",",".","'","\"","&","|","!","#","$","¨","*","(",")","`","´","<",">",";","=","+","§","{","}","[","]","^","~","?","%"
		);

		$special = Array(
			'Á','È','ô','Ç','á','è','Ò','ç','Â','Ë','ò','â','ë','Ø','Ñ','À','Ð','ø','ñ','à','ð','Õ','Å','õ','Ý','å','Í',
			'Ö','ý','Ã','í','ö','ã','Î','Ä','î','Ú','ä','Ì','ú','Æ','ì','Û','æ','Ï','û','ï','Ù','®','É','ù','©','é','Ó',
			'Ü','Þ','Ê','ó','ü','þ','ê','Ô','ß','‘','’','‚','“','”','„'
		);
		$clearspc = Array(
			'a','e','o','c','a','e','o','c','a','e','o','a','e','o','n','a','d','o','n','a','o','o','a','o','y','a','i',
			'o','y','a','i','o','a','i','a','i','u','a','i','u','a','i','u','a','i','u','i','u','','e','u','c','e','o','u',
			'p','e','o','u','b','e','o','b','','','','','',''
		);

		$newString = str_replace($special, $clearspc, $string);
		$newString = str_replace($LetraProibi, "", trim($newString));

		return strtolower($newString);
	}

	/** 
	 *	Retorna um número inteiro com a idade atual de acordo com uma data de nascimento
	 *
	 * @param date $data_nascimento
	 * @return int $idade
	 *
	 **/
	public function idade($data_nascimento=null){

		$data = $data_nascimento;

		if(is_null($data)) return false;

		# Separa em dia, mês e ano
		list($ano, $mes, $dia) = explode('-', $data);

		# Descobre que dia é hoje e retorna a unix timestamp
		$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

		# Descobre a unix timestamp da data de nascimento
		$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

		# Calcula a idade
		$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);	

		return $idade;
	}

	/**
	 * Função auxiliar para validar campos com valor array
	 *
	 * @return bool TRUE or FALSE
	 */
	public function notEmptyArray(array $arr=null){

		if(!is_null($arr) and !empty($arr) and is_array($arr)){

			return true;
		}

		return false;
	}

	/**
	 * Função auxiliar para validar campos com do tipo checkbox
	 *
	 * @return bool TRUE or FALSE
	 */
	public function checked($value=null){

		if(!is_null($value)){
			
			$each = each($value);
			return ($each['value'] == true)? true : false;
		}

		return false;
	}
}