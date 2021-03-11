<?php

class ToolComponent extends Component{

	public $components = array('Session');

	/**
	 * Sugestões de palavra correta de acordo com lista de palavras. Famoso "você quis dizer do google"
	 *
	 * @param string $str, array $lista, int $acerto, $limite
	 *
	 *    Opções de configuração:
	 *		- $str = String de pesquisa
	 *		- $lista = Lista de Sugestões.
	 *		- $acerto = porcentagem de acerto para a exibição da sugestão (Padrão é 10)
	 *		- $limite = limite de sugestões
	 *
	 * @return string $sugestao
	 */
	public function didyoumean($str=null, $lista=null, $acerto=null, $limite=3) {
		
		if(is_null($str) OR is_null($lista)) return false;
		if(is_null($acerto)) $acerto = 10; // % acerto para a sugestão
		
		$sugestao = '';
		$sugestoes = array();
		foreach ($lista as $k => $v) {

			# Trata as strings e retira acentos.
			$v_ok = mb_strtolower($this->retira_acentos($v));
			$str_ok = mb_strtolower($this->retira_acentos($str));

			# Evita sugestões igual a palavra buscada
			if($v_ok != $str_ok){

				$media = round(($acerto / 100)*(strlen($v_ok)+strlen($str_ok))); // (int) Distancia aceita nesta palavra da lista
				$distancia = levenshtein($str_ok, $v_ok); //  (int) Nº de chars que precisam ser alterados para que a palavra procurada seja igual a da Lista

				# Se a distancia for igual ou menor que a média e Distancia != 0, então inseri a sugestão! E diferente da palavra buscada
				if($distancia <= $media && $distancia != 0){
	
					$sugestoes[$distancia][] = mb_strtolower(trim($v));
				}
			}
		}

		# Ordena array por distancia ASC
		ksort($sugestoes);

		# Gera novo array com lista de sugestoes em ordem de distancia
		$new = array();
		foreach ($sugestoes as $distancia => $data) {
			
			foreach ($data as $palavra) {

				array_push($new, $palavra);
			}
		}

		# Limite de sugestões
		$new = array_slice($new, 0, $limite);

		# Se houver sugestões, define apenas uma sugestão por ordem de semelhança.
		// if(!empty($sugestoes)){

		// 	$sugestao = array_shift($sugestoes);
		// 	$sugestao = $sugestao[0];
		// }

		return $new;
	}


/**
 * Retira acentos de uma string
 *
 * @return string
 *
 **/
	public function retira_acentos($string=''){
		return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
	}

/**
 * Verifica cadastro do usuário logado
 *
 * @return boolean true or false
 *
 **/
	public function verifica_cadastro_usuario(){
		$us_logado = $this->Session->read('Auth.User');
		if(!is_null($us_logado['Cadastro']['id'])){
			return true;
		}
		return false;
	}

/**
 * Embaralha os elementos de um array mantendo a associação entre keys e seus valores.
 * Função nativa Shuffle + assoc;
 *
 * @param array $array
 * @return array $new
 */ 
	public function shuffle_assoc(&$array) {
		
		$keys = array_keys($array);
		shuffle($keys);
		foreach($keys as $key) {
			$new[$key] = $array[$key];
		}

		return $new;
	}

/**
 * Retorna a diferença em DIAS entre duas Datas
 *
 * @param date $date1
 * @return date $date2
 */ 
	public function diferenca_datas($date1=null, $date2=nukk) {

		if(is_null($date1) OR is_null($date2)){
			return false;
		}

		$date1_str = strtotime($date1);
		$date2_str = strtotime($date2);

		if($date1_str <= $date2_str){

			# Calcula a diferença em segundos entre as datas
			$diferenca = strtotime($date2) - strtotime($date1);

			# Calcula a diferença em dias
			$dias = floor($diferenca / (60 * 60 * 24));
		}
		else{

			$dias = 0;
		}

		return $dias;
	}

/**
 * Retorna a diferença entre dois Arrays (not is array_diff)
 *
 * @param array $arr1, array $arr2
 * @return array array_diff
 */ 
	public function diff_array($arr1=null, $arr2=null) {
		
		if(!is_array($arr1) or !is_array($arr2)) return false;

		if (count($arr1) == count($arr1, COUNT_RECURSIVE) or count($arr2) == count($arr2, COUNT_RECURSIVE)) {

			$result1 = array_diff($arr1, $arr2);
			$result2 = array_diff($arr2, $arr1);

			return array_merge($result1, $result2);		
		}

		return false;
	}

/**
 * Substitui ocorrencias(variáveis) em um determinado texto
 *
 * @param array $var=>value, string $texto
 * @return string $texto
 */ 
	public function str_replaceAll(array $vars=null, string $texto=null) {
		
		# percorre variaveis
		foreach ($vars as $k => $v) {

			$texto = str_replace('$'.$k, $v, $texto);
		}

		return $texto;
	}

	/**
	 * Função para formatar Telefone, CEP, CPF, CNPJ e RG
	 *
	 * Escolher tipo de formatação ( fone, cep, cpf, cnpj ou rg) 
	 * Lembrar de colocar em lowercase
	 * @param $tipo  string
	 *   
	 * Enviar string que para ser formata ex: 13974208014;
	 * @param $string  string   
	 *
	 * Quantidade de caracteres a serem formatados, 
	 * só serve para o telefone 10 para o padrão antigo e 11 para novo padrão com 9
	 * @param $size  integer  
	 *
	 *
	 * Valor formatado do padrão escolhido
	 * @return $string  string   
	 */
	public function formatar($tipo = '', $string, $size = 10) {
		
		$string = preg_replace('[^0-9]', '', $string);

		switch ($tipo) {

			// FONE
			case 'fone':
				break;

			// CEP
			case 'cep':
				$string = substr($string, 0, 5).'-'.substr($string, 5, 3);
				break;

			// CPF
			case 'cpf':
				$string = substr($string, 0, 3).'.'.substr($string, 3, 3).'.'.substr($string, 6, 3).'-'.substr($string, 9, 2);
				break;

			case 'cnpj':
				$string = substr($string, 0, 2).'.'.substr($string, 2, 3).'.'.substr($string, 5, 3).'/'.substr($string, 8, 4).'-'.substr($string, 12, 2);
				break;

			case 'rg':
				$string = substr($string, 0, 2).'.'.substr($string, 2, 3).'.'.substr($string, 5, 3);
				break;

			default:
				// não formata
				break;
		}

		return $string;
	}

}

?>