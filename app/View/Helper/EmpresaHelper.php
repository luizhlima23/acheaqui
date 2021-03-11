<?php
/**
 * Helper para formatação de dados de empresas no padrão do aonde
 *
 * @author        Anderson Corso <andersoncorso89@gmail.com>
 */

	# PHP Fine Fiff
	// require_once APP.'Vendor'.DS.'FineDiff'.DS.'finediff.php';

/**
 * Empresa Helper
 *
 * @link wiki
 */
class EmpresaHelper extends AppHelper {

	/**
	 * Helpers auxiliares
	 *
	 * @var array
	 * @access public
	 */
	// public $helpers = array('Time', 'Number');

	/**
	 * NOME
	 *
	 * @param string $nome
	 * @return string $nome formatada
	 * @access public
	 */
	public function nome($a){
		return mb_strtoupper($a);	
	}

	/**
	 * TELEFONE
	 *
	 * @param numeric $a Fone
	 * @return string $fone Fone no formato '(00) 9 0000-0000'
	 * @access public
	 */
	public function fone($a){
		$fone = '';
		$a = preg_replace('/[^0-9]/', '', $a);

		if(strlen($a) >= 10){

			$ddd = substr($a, 0, 2);
			$a = substr($a, 2, strlen($a));
		}

		if($this->__validaFone($a)){

			$nono = '';
			if(strlen($a) == 9){
				$nono = substr($a, 0, 1).' ';
				$a = substr($a, 1, 8);
			}
			$fone = $nono.substr($a, 0, 4).'-'.substr($a, 4, 4);
		}

		if(!empty($ddd)){

			$fone = "($ddd) ".$fone;
		}

		return $fone;	
	}

	/**
	 * ENDEREÇO COMPLETO
	 *
	 * @param array $empresa['Array']
	 * @return string $endereco_completo
	 * @access public
	 */
	public function endereco_completo($a, $logradouros=array(), $bairros=array()){
		
		# Extrai as variáveis
		if(isset($a['Contato'])){

			extract($a['Contato']);
		}
		else{

			extract($a);
		}

		$e = '';

		# logradouro

		if(!isset($logradouro) and isset($logradouro_id) and isset($logradouros)){

			if($this->__validaString($logradouro_id) and is_array($logradouros)){

				$logradouro = (isset($logradouros[$logradouro_id]))? $logradouros[$logradouro_id] : '';
			}
		}
		if(!isset($logradouro)) $logradouro = '';
		$e.= $logradouro;
		
		# número
		if(isset($end_num)){

			if($this->__validaIntNumber($end_num)){

				$e.= (!empty($logradouro))? ', nº '.$end_num : 'nº '.$end_num;
			}
		}
		
		# complemento
		if(isset($end_comp)){

			if($this->__validaString($end_comp)){

				$e.= (!empty($e))? ', '.$end_comp : $end_comp;
			}
		}

		# bairro
		if(!isset($bairro) and isset($bairro_id) and isset($bairros)){

			if($this->__validaString($bairro_id) and is_array($bairros)){

				$bairro = (isset($bairros[$bairro_id]))? $bairros[$bairro_id] : '';
			}
		}
		if(!isset($bairro)) $bairro = '';
		$e.= (!empty($e) and !empty($bairro))? ' - '.$bairro : $bairro;

		# referência
		if(isset($end_ref)){

			if($this->__validaString($end_ref)){

				$e.= '<small><em> ('.$end_ref.')</em></small>';
			}
		}
		
		return $e;	
	}

	/**
	 * RETORNA A DIFRENÇA ENTRE DOIS TEXTOS (fine diff)
	 *
	 * @param string $str1, string $str2, string $mark
	 * @return string $string
	 * @access public
	 */
	public function get_fine_diff($from_text, $to_text, $gran){

		$opcodes = FineDiff::getDiffOpcodes($from_text, $to_text);
		$html_diff = FineDiff::renderDiffToHTMLFromOpcodes($from_text, $opcodes);
		$text_diff = FineDiff::renderToTextFromOpcodes($from_text, $opcodes);

		return $html_diff;
	}



##################
##	AUXILIÁRES	##
##################

	/**
	 * Valida uma string
	 *
	 * @param string $val
	 * @return boolean true ou false
	 */
	protected function __validaString($val){

		if(is_null($val)) return false;		// Se diferente de null
		if(empty($val)) return false;		// Se não estiver vazio
		if(!is_string($val)) return false;	// 

		return true;
	}

	/**
	 * Valida um numero
	 *
	 * @param int $val
	 * @return boolean true ou false
	 */
	protected function __validaIntNumber($val){

		if(is_null($val)) return false;		// Se diferente de null
		if(empty($val)) return false;		// Se não estiver vazio
		if(!is_int($val)) return false;		// Se é um número inteiro

		return true;
	}

	/**
	 * Valida a variável de telefone
	 *
	 * @param integer $val
	 * @return boolean true ou false
	 */
	protected function __validaFone($val){

		if(is_null($val)) return false;		// Se diferente de null
		if(empty($val)) return false;		// Se não estiver vazio
		if(strlen($val) < 8 or strlen($val) > 9) return false;	// se diferente de 8 chars

		return true;
	}

/**
 * Retorna String de um int status
 *
 * @param int status, 
 * @return string
 */
	public function status_string($status=null, $strings=null ,$default='Não informado'){
		
		# Quando não informado o status
		if($status==null ) return $default;

		# Se não houver strings para verificar, então retorna a mensagem padrão
		if($strings==null or !is_array($strings)) return __('Desconhecido');

		return $strings[$status];
	}

/**
 * Transforma true or false em string
 *
 * @param boolean $val
 * @return string "Ativado/Sim/Verdadeiro" ou "Desativado/Não/Falso"
 */
	public function status($val, $tipo = 1, $default='Não informado'){
		
		$tipos = array(1, 2, 3, 4); // Confirmação
		if(!in_array($tipo, $tipos)){
			$tipo = 1;
		}

		$true = array(
			1 => 'Ativado',
			2 => 'Sim',
			3 => 'Verdadeiro',
			4 => 'Aprovado',
		);
		$false = array(
			1 => 'Desativado',
			2 => 'Não',
			3 => 'Falso',
			4 => 'Reprovado',
		);

		switch ($val) {
			case '1':
				return $true[$tipo];
				break;

			case '0':
				return $false[$tipo];
				break;
			
			default:
				return $default;
				break;
		}
	}

/**
 * Limita o número de caracteres de um texto, sem cortar palavras.
 *
 * @param string $txt, integer $limite
 * @return string $txt
 */
	public function cut($txt, $limite){
		$count = strlen($txt);
		if ( $count >= $limite ) {
			$txt = substr($txt, 0, strrpos(substr($txt, 0, $limite), ' ')) . '...';
			return $txt;
		}
		else{
			return $txt;
		}
	}

/**
 * Valida Arquivo
 *
 * @param string $arq, string $dir
 * @return boolean true ou false
 */
	public function validaArquivo($arq=null, $dir=null){
		
		if(is_null($arq)) return false;
		if(is_null($dir)) $dir = WWW_ROOT;

		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		
		$file = new File($dir.$arq, false);

		return $file->exists();
	}

/**
 * URL Exists
 *
 * Verifica se o caminho URL existe.
 * Isso é útil para verificar se um arquivo de imagem num 
 * servidor remoto antes de definir um link para o mesmo.
 *
 * @param string $url           O URL a verificar.
 *
 * @return boolean
 */
	public function url_exists($url) {

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    curl_exec($ch);
	    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    curl_close($ch);

	    return ($code == 200); // verifica se recebe "status OK"
	}

/**
 * Retorna um cumprimento de acordo com a hora
 *
 * @return string $cumprimento
 *
 **/
	public function cumprimento_hora(){
		$hora_do_dia=date('H');

		if (($hora_do_dia >=6) && ($hora_do_dia <=12)) return 'Bom dia';
		if (($hora_do_dia >12) && ($hora_do_dia <=18)) return 'Boa tarde';
		if (($hora_do_dia >18) && ($hora_do_dia <=24)) return 'Boa noite';
		if (($hora_do_dia >=0) && ($hora_do_dia <6)) return 'Boa madrugada';

		return 'Olá';
	}

/**
 * Retorna os tipos de logradouro
 *
 * @return array "string"=>"string"
 */
	public function tiposLogradouro(){
		$options = array(
			'Rua'=>'Rua',
			'Avenida'=>'Avenida',
			'Travessa'=>'Travessa',
			'Praça'=>'Praça',
			'Quadra'=>'Quadra',
			'Alameda'=>'Alameda',
			'Beco'=>'Beco',
			'Vila'=>'Vila',
			'Estrada'=>'Estrada',
			'Passagem'=>'Passagem',
			'Viela'=>'Viela',
			'Servidão'=>'Servidão',
			'BR'=>'BR',
			'GO'=>'GO'
		);
		return $options;
	}

/**
 * Retorna os tipos de estabelecimento
 *
 * @return array "string"=>"string"
 */
	public function tiposEstabelecimento(){
		$options = array(
			'Comercial'=>'Comercial',
			'Residencial'=>'Residencial'
		);
		return $options;
	}

	/**
	 * String Meses do plano
	 *
	 * @param string $plano
	 * @return string $meses
	 */
	public function stringMeses_plano($plano=null){

		$planos = array(
			'mensal'=>'1 mês',
			'trimestral'=>'3 meses',
			'semestral'=>'6 meses',
			'anual'=>'12 meses',
		);

		foreach ($planos as $p=>$v) {
			
			if(strpos($plano, $p)) $plano=$p;
		}

		if(array_key_exists($plano, $planos)){
			return $planos[$plano];
		}

		return null;
	}

/**
 * Formata a data personalizada
 *
 */
	public function dataFormato($data = null, $formato = null) {
		
		if(is_null($formato)) $formato = 'Y/m/d';

		return $this->Time->format($formato, $data);
	}

/**
 * Verifica se uma data Between periodo de duas datas
 *
 * @param string $data, string $dataInicio, $dataFim
 * @return bool true or false
 */
	public function dataBetween($data=null, $dataInicio=null, $dataFim=null){

		# Verifica entrada de dados
		if(is_null($data) or empty($data)) return false;
		if(is_null($dataFim) or empty($dataFim)) return false;
		if(is_null($dataInicio) or empty($dataInicio)) $dataInicio = date('Y-m-d');

		$data = strtotime($data);
		$dataInicio = strtotime($dataInicio);
		$dataFim = strtotime($dataFim);

		if($data >= $dataInicio AND $data <= $dataFim){
			return true;
		}
		return false;
	}

}