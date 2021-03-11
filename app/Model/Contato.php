<?php
App::uses('AppModel', 'Model');
App::uses('BrValidation', 'Localized.Validation');

class Contato extends AppModel {

	public $displayField = 'nome';

	public $hasOne = array(
		'BannerA'=>array(
			'className' => 'BannerA',
			'dependent' => false,
		),
		'BannerB'=>array(
			'className' => 'BannerB',
			'dependent' => false,
			'order'=>array('BannerB.modified DESC'),
		),
		'BannerC'=>array(
			'className' => 'BannerC',
			'dependent' => false,
		),
		'Etiqueta'=>array(
			'className' => 'Etiqueta',
			'dependent' => false,
		),
	);

	public $belongsTo = array(
		'Logradouro' => array(
			'className' => 'Logradouro',
			'foreignKey' => 'logradouro_id',
			'conditions' => array('Logradouro.status'=>true),
			//'fields' => array('Logradouro.id', 'Logradouro.end_tipo', 'Logradouro.descricao', 'Logradouro.status', 'Logradouro.views', 'Logradouro.average_order'),
			'order' => ''
		),
		'Bairro' => array(
			'className' => 'Bairro',
			'foreignKey' => 'bairro_id',
			'conditions' => array('Bairro.status'=>true),
			//'fields' => array('Bairro.id', 'Bairro.nome', 'Bairro.status', 'Bairro.views', 'Bairro.average_order'),
			'order' => ''
		),
		'Cidade' => array(
			'className' => 'Cidade',
			'foreignKey' => 'cidade_id',
			'conditions' => array('Cidade.status'=>true),
			//'fields' => array('Cidade.id', 'Cidade.nome', 'Cidade.status', 'Cidade.views', 'Cidade.average_order'),
			'order' => ''
		),
	);

	public $validate = array(
		'nome' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 2, 50),
				'message' => 'O nome deve conter entre 2 e 150 caracteres.',
			)
		),
		'slug' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 10, 150),
				'message' => 'O slug deve conter entre 10 e 150 caracteres.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Este nome de identificação já está sendo usado.'
			),
		),
		'descricao' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => true,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 0, 500),
				'message' => 'Informe no máximo 500 caracteres.',
				'allowEmpty' => true,
				'required' => false,
			)
		),
		'fone1' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Campo obrigatório',
				'allowEmpty' => true,
				'required' => false
			),
			'Numeric' => array(
				'rule' => array('Numeric'),
				'message' => 'Digite apenas números ex: 36120123'
			),
            'between' => array(
                'rule' => array('lengthBetween', 8, 9),
                'message' => 'O Telefone deve conter entre 8 e 9 digitos'
            ),
            /*
		    'isUnique' => array(
		        'rule' => 'isUnique',
		        'message' => 'Este telefone já existe no sistema'
		    )
		    */
		),
		'fone2' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo',
				'allowEmpty' => true,
				'required' => false
			),
			'Numeric' => array(
				'rule' => array('Numeric'),
				'message' => 'Digite apenas números ex: 36120123',
			),
            'between' => array(
                'rule' => array('lengthBetween', 8, 9),
                'message' => 'O Telefone deve conter entre 8 e 9 digitos'
            ),
		),
		'fone3' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo',
				'allowEmpty' => true,
				'required' => false
			),
			'Numeric' => array(
				'rule' => array('Numeric'),
				'message' => 'Digite apenas números ex: 36120123',
			),
            'between' => array(
                'rule' => array('lengthBetween', 8, 9),
                'message' => 'O Telefone deve conter entre 8 e 9 digitos'
            ),
		),
		'fone4' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo',
				'allowEmpty' => true,
				'required' => false
			),
			'Numeric' => array(
				'rule' => array('Numeric'),
				'message' => 'Digite apenas números ex: 36120123',
			),
            'between' => array(
                'rule' => array('lengthBetween', 8, 9),
                'message' => 'O Telefone deve conter entre 8 e 9 digitos'
            ),
		),
		'logradouro_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Selecione o Logradouro (Rua)',
				'allowEmpty' => false,
				'required' => false,
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe um logradouro válido.',
				'allowEmpty' => false,
				'required' => false
			),
		),
		'end_num' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => true,
				'required' => false
			)
		),
		'end_comp' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => true,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 2, 150),
				'message' => 'O nome deve conter entre 2 e 150 caracteres.',
				'allowEmpty' => true,
				'required' => false
			)
		),
		'end_ref' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => true,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 2, 150),
				'message' => 'O nome deve conter entre 2 e 150 caracteres.',
			)
		),
		'end_tpest' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => true,
				'required' => false,
			)
		),
		'bairro_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Selecione o Bairro',
				'allowEmpty' => false,
				'required' => false,
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false
			),
		),
		'cidade_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Informe um e-mail válido',
				'allowEmpty' => true,
				'required' => false
			),
		),
		'url_website' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => true,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 10, 250),
				'message' => 'Este campo deve conter entre 10 e 250 caracteres.',
			)
		),
		'url_facebook' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => true,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 2, 250),
				'message' => 'Este campo deve conter entre 2 e 250 caracteres.',
			)
		),
		'url_twitter' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => true,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 2, 250),
				'message' => 'Este campo deve conter entre 2 e 250 caracteres.',
			)
		),
		'url_google' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => true,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 2, 250),
				'message' => 'Este campo deve conter entre 2 e 250 caracteres.',
			)
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => true,
				'required' => false
			)
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'cargo_responsavel' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 3, 150),
				'message' => 'Este campo deve conter entre 3 e 150 caracteres.',
			)
		),
		'razao_social' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 3, 500),
				'message' => 'Este campo deve conter entre 3 e 500 caracteres.',
			)
		),
		'cpf_cnpj' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => false,
				'required' => false
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 11, 14),
				'message' => 'O CPF deve conter 11 números e o CNPJ 14.',
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'CPF ou CNPJ já cadastrado no sistema!'
			),
			'valid' => array(
				'rule' => array('ssn', null, 'br'),
				'message' => 'Insira um CPF/CNPJ válido!',
				'allowEmpty' => false,
				'required' => false
			),
		),
	);

	public $actsAs = array('Auditable.Auditable');

	public function beforeSave($options = array()) {

		# Fone1 (somente os números)
		if (!empty($this->data['Contato']['fone1'])) {
			
			$this->data['Contato']['fone1'] = $this->foneFormatBeforeSave($this->data['Contato']['fone1']);
		}
		# Fone2 (somente os números)
		if (!empty($this->data['Contato']['fone2'])) {
			
			$this->data['Contato']['fone2'] = $this->foneFormatBeforeSave($this->data['Contato']['fone2']);
		}
		# Fone3 (somente os números)
		if (!empty($this->data['Contato']['fone3'])) {
			
			$this->data['Contato']['fone3'] = $this->foneFormatBeforeSave($this->data['Contato']['fone3']);
		}
		# Fone4 (somente os números)
		if (!empty($this->data['Contato']['fone4'])) {
			
			$this->data['Contato']['fone4'] = $this->foneFormatBeforeSave($this->data['Contato']['fone4']);
		}

		# CPF/CNPJ (Apenas números para a validação)
		if(isset($this->data['Contato']['cpf_cnpj'])){

			$cpf_cnpj = preg_replace("/[^0-9]/", "", $this->data['Contato']['cpf_cnpj']);
			$this->data['Cadastro']['cpf_cnpj'] = $cpf_cnpj;
		}

		# slug name
		if(isset($this->data['Contato']['nome'])){

			$this->data['Contato']['slug'] = mb_strtolower(Inflector::slug($this->data['Contato']['nome'], '-'));
		}
	}

	public function beforeValidate($options = array()){

		# Fone1 (somente os números)
		if(isset($this->data['Contato']['fone1'])){

			$telefone = preg_replace("/[^0-9]/", "", $this->data['Contato']['fone1']);
			$this->data['Contato']['fone1'] = $telefone;
		}
		# Fone2 (somente os números)
		if(isset($this->data['Contato']['fone2'])){

			$telefone = preg_replace("/[^0-9]/", "", $this->data['Contato']['fone2']);
			$this->data['Contato']['fone2'] = $telefone;
		}
		# Fone3 (somente os números)
		if(isset($this->data['Contato']['fone3'])){

			$telefone = preg_replace("/[^0-9]/", "", $this->data['Contato']['fone3']);
			$this->data['Contato']['fone3'] = $telefone;
		}
		# Fone4 (somente os números)
		if(isset($this->data['Contato']['fone4'])){

			$telefone = preg_replace("/[^0-9]/", "", $this->data['Contato']['fone4']);
			$this->data['Contato']['fone4'] = $telefone;
		}
		
		# CPF/CNPJ (Apenas números para a validação)
		if(isset($this->data['Contato']['cpf_cnpj'])){

			$cpf_cnpj = preg_replace("/[^0-9]/", "", $this->data['Contato']['cpf_cnpj']);
			$this->data['Contato']['cpf_cnpj'] = $cpf_cnpj;
		}

		return true;
	}

	public function afterFind($results, $primary = true) {

	    foreach ($results as $key => $val) {

			# ENDEREÇO
			if ( is_array($val) && isset($val['Contato']) && isset($val['Logradouro']) && isset($val['Bairro']) ) {
			        
				$end_vars['logradouro_id'] = trim($val['Logradouro']['end_tipo']).' '.trim($val['Logradouro']['descricao']);
				$end_vars['end_num'] = trim($val['Contato']['end_num']);
				$end_vars['end_comp'] = trim($val['Contato']['end_comp']);
				$end_vars['end_ref'] = trim($val['Contato']['end_ref']);
				$end_vars['end_tpest'] = trim($val['Contato']['end_tpest']);
				$end_vars['bairro_id'] = trim($val['Bairro']['nome']);

				$end_completo = $this->enderecoFormatAfterFind($end_vars);
				$end_vars['end_ref'] = '';
				$endereco = $this->enderecoFormatAfterFind($end_vars);

				if(!empty($end_completo) and !is_null($end_completo) and strlen($end_completo)>2) {
					
					$results[$key]['Contato']['end_completo'] = $end_completo;
					$results[$key]['Contato']['endereco'] = $endereco;
				}
				else{
					$results[$key]['Contato']['end_completo'] = '';
					$results[$key]['Contato']['endereco'] = '';
				}

			}
	    }

	    return $results;
	}

	public function enderecoFormatAfterFind($e){

		$end_format = '';

		// Endereço_id
		($this->validaEndereco($e['logradouro_id'])) ? $end_format.=$e['logradouro_id'] : '';

		// Número
		($this->validaEndereco($e['logradouro_id']) and $this->validaEndereco($e['end_num'])) ? $end_format.=', nº '.$e['end_num'] : '';

		// Complemento
		($this->validaEndereco($e['logradouro_id']) and $this->validaEndereco($e['end_comp'])) ? $end_format.=', '.$e['end_comp'] : '';
		
		// Bairro
		($this->validaEndereco($e['logradouro_id']) and $this->validaEndereco($e['bairro_id'])) ? $end_format.=' - '.$e['bairro_id'] : '';
		
		// Referência
		($this->validaEndereco($e['end_ref'])) ? $end_format.='<small><em> ('.$e['end_ref'].')</em></small>' : '';

		return $end_format;
	}

	public function foneFormatBeforeSave($e){

		return preg_replace("/[^0-9]/", "", $e);
	}

	protected function validaEndereco($val){

		if(is_null($val)) return false;	// Se diferente de null
		if(empty($val)) return false;	// Se não estiver vazio
		if(is_numeric($val) and ($val==0)) return false;

		return true;
	}

	/**
	 * Quantidade de contatos do usuário
	 *
	 * @param int $id
	 *
	 * @return int 
	 * @access public
	 */
	public function count_contatos($id=null){
		
		# Paginate Options
		$options = array(
			'conditions'=>array(
				'user_id'=>$id
			),
		);
		$count = $this->find('count', $options);

		return $count;
	}

	/**
	 *	Revoga a gestão de uma empresa do usuário
	 *
	 *	@param int $contato_id, int $user_id;
	 *	@return boolean true or false
	 **/
	public function revogar_empresa_usuario($contato_id=null, $user_id=null) {

		if(!empty($contato_id) and !empty($user_id)){

			$contato_userid = $this->_responsavel_id($contato_id);

			if($contato_userid === $user_id){

				$dataSave['Contato']['id'] = $contato_id;
				$dataSave['Contato']['user_id'] = null;
				$dataSave['Contato']['cargo_responsavel'] = null;
				
				if($this->save($dataSave, array('validate'=>false))){

					return true;
				}
			}
		}

		return false;
	}

	/**
	 *	Verifica a permissão do usuário na Empresa
	 *
	 *	@param int $contato_id, int $user_id;
	 *	@return boolean true or false
	 **/
	public function permissao_usuario($contato_id=null, $user_id=null) {

		if(is_null($user_id)) $user_id = $this->user_id;

		if(!is_null($contato_id)){

			$this->id = $contato_id;
			$contato_userid = $this->field('user_id');

			if($contato_userid == $user_id) return true;
		}

		return false;
	}

	/**
	 *	Retorn o id do usuário responsável pelo contato
	 *
	 *	@param int $contato_id
	 *	@return int $user_id
	 **/
	public function _responsavel_id($contato_id=null){

		$this->id = $contato_id;
		return $this->field('user_id'); 
	}

	/**
	 *	Retorna o campo nome do Contato 
	 *
	 *	@param int $contato_id
	 *	@return string $nome
	 **/
	public function get_nome($contato_id=null){

		if(is_null($contato_id)) return null;

		$this->id = $contato_id;
		return $this->field('nome');
	}

/**
 * Função auxiliar para retornar uma lista com as empresas
 *
 * @return array $lista
 */
	public function listaEmpresas(){

		$options = array(
			'conditions' => array('Contato.status' => 1),
			'recursive' => -1,
			'fields' => array('id', 'nome'),
			'order' => array('nome ASC'),
			'limit' => false,
			'callbacks' => true
		);

		return $this->find('list', $options);
	}

	/**
	 *	lista empresas do usuário
	 *
	 *	@param int $user_id
	 *	@return array $lista
	 **/
	public function lista_empresas_user($user_id=null){

		if(!is_null($user_id) AND !empty($user_id)){

			# Consulta empresas
			$options = array(
				'conditions' => array('Contato.user_id'=>$user_id, 'Contato.status'=>1),
				'order'=>array('Contato.nome'=>'DESC'),
				'group'=>array('Contato.id'),
				'fields'=>array('id', 'nome')
			);
			$this->recursive = -1;

			return $this->find('list', $options);
		}

		return array();
	}

	/**
	 *	Consulta empresas do usuário
	 *
	 *	@param int $user_id
	 *	@return array $lista
	 **/
	public function find_empresas_user($user_id=null){

		if(!is_null($user_id) AND !empty($user_id)){

			# Consulta empresas
			$options = array(
				'conditions' => array('Contato.user_id'=>$user_id, 'Contato.status'=>1),
				'order'=>array('Contato.nome'=>'DESC'),
				'group'=>array('Contato.id')
			);
			$this->recursive = -1;

			return $this->find('all', $options);
		}

		return array();
	}

	/**
	 *	Retorna o campo relevancia de uma empresa, baseado nos planos ativos
	 *
	 *	@param int $id (Empresa ID)
	 *	@return int $relevancia
	 **/
	public function relevancia($id=null){

		# RELEVÂNCIA - Campo Virtual 
		$this->virtualFields['relevancia'] = 'IF(Etiqueta.status LIKE true, 1, 0) + IF(BannerA.status LIKE true, 1, 0) + IF(BannerC.status LIKE true, 1, 0)';

		$options = array(
			'conditions'=>array(
				'Contato.'.$this->primaryKey=>$id,
				'Contato.status'=>true
			)
		);
		$this->recursive = 0;
		$data = $this->find('first', $options);

		if(isset($data['Contato']['relevancia'])){

			return $data['Contato']['relevancia'];
		}

		return false;
	}
}
