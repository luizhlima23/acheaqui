<?php
App::uses('AppController', 'Controller');

class CorrecoesController extends AppController{

	public $uses = array('Correcao');

	public $components = array(
		'RequestHandler',
		'Paginator',
		'FilterResults.Filter' => array(
			'auto' => array(
				'paginate' => false,
				'explode'  => true
			),
			'explode' => array(
				'character'   => ' ',
				'concatenate' => 'AND'
			)
		),
		'Tool'
	);

	public $helpers = array('Empresa', 'Formata', 'FilterResults.Search', 'CakePtbr.Formatacao');
	
	public function beforeFilter() {
		parent::beforeFilter();

		// $this->Auth->allow();
	}




/*	
====================================
CRUD
====================================
*/

	public function index(){

		# Paginate Options
		$options = array(
			'conditions'=>array(),
			'order'=>array('created'=>'DESC')
		);
		$this->paginate = $options;

		# Variáveis
		$all_actions = $this->Correcao->listaAcoes();
		$opt_results = array('A'=>'Aprovado', 'R'=>'Reprovado', 'AC'=>'Aprovado com alterações');

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('Correcao')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_acao' => array(
					'Correcao.acao' => array(
						'select' => $all_actions
					)
				),
				'f_resultado' => array(
					'Correcao.resultado' => array(
						'select' => $opt_results
					)
				),
				'f_status' => array(
					'Correcao.status' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status'))
					)
				)
			)
		);

		# Mescla Conditions
		if($this->Filter->getConditions()){
			$options['conditions'] = array_merge($options['conditions'], $this->Filter->getConditions());		
			$this->Filter->setPaginate('conditions', $options['conditions']);
		}

		$this->Correcao->recursive = 0;
		$correcoes = $this->Paginator->paginate();

		$this->set('correcoes', $correcoes);
	}

	public function user_index(){

		# Paginate Options
		$options = array(
			'conditions'=>array(
				'Correcao.user_id' => $this->user_id,
			),
			'order'=>array('created'=>'DESC')
		);
		$this->paginate = $options;

		# Variáveis
		$all_actions = $this->Correcao->listaAcoes();
		$opt_results = array('A'=>'Aprovado', 'R'=>'Reprovado', 'AC'=>'Aprovado com alterações');

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('Correcao')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_acao' => array(
					'Correcao.acao' => array(
						'select' => $all_actions
					)
				),
				'f_resultado' => array(
					'Correcao.resultado' => array(
						'select' => $opt_results
					)
				),
				'f_status' => array(
					'Correcao.status' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status'))
					)
				)
			)
		);

		# Mescla Conditions
		if($this->Filter->getConditions()){
			$options['conditions'] = array_merge($options['conditions'], $this->Filter->getConditions());		
			$this->Filter->setPaginate('conditions', $options['conditions']);
		}

		$this->Correcao->recursive = 0;
		$correcoes = $this->Paginator->paginate();

		$this->set('correcoes', $correcoes);
	}

	public function view($id=null){
		
		# Verifica se existe
		$this->Correcao->id = $id;
		if (!$this->Correcao->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		# parâmetros de consulta
		$options = array(
			'conditions'=>array(
				'Correcao.'.$this->Correcao->primaryKey => $id,
			)
		);
		$this->Correcao->recursive = 0;

		$correcao = $this->Correcao->find('first', $options);
		$this->set('data', $correcao);
		
		# Caso não encontre nenhum registro
		if(empty($correcao)){

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('action' => 'index'));
		}

		# Logradouros
		$this->loadModel('Logradouro');
		$logradouros = $this->Logradouro->listaLogradouros();

		# Bairros
		$this->loadModel('Bairro');
		$bairros = $this->Bairro->listaBairros();

		$this->set(compact('logradouros', 'bairros'));
	}

	public function user_view($id=null){

		# Verifica se existe
		$this->Correcao->id = $id;
		if (!$this->Correcao->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'user_index'));
		}

		# parâmetros de consulta
		$options = array(
			'conditions'=>array(
				'Correcao.'.$this->Correcao->primaryKey => $id,
				'Correcao.user_id' => $this->user_id,
			)
		);
		$this->Correcao->recursive = 0;

		$correcao = $this->Correcao->find('first', $options);
		$this->set('data', $correcao);
		
		# Caso não encontre nenhum registro
		if(empty($correcao)){

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('action' => 'user_index'));
		}

		# Logradouros
		$this->loadModel('Logradouro');
		$logradouros = $this->Logradouro->listaLogradouros();

		# Bairros
		$this->loadModel('Bairro');
		$bairros = $this->Bairro->listaBairros();

		$this->set(compact('logradouros', 'bairros'));
	}

	public function delete($id = null) {

		$this->request->onlyAllow('post', 'delete');

		$this->Correcao->id = $id;
		if (!$this->Correcao->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		if ($this->Correcao->delete()) {

			$this->Session->setFlash($this->mmCrud['deleted'], 'layout/flash/flash_success');
		}
		else {

			$this->Session->setFlash($this->mmCrud['not_deleted'], 'layout/flash/flash_warning');
		}

		return $this->redirect(array('action' => 'index'));
	}

	public function analisar_correcao($id=null){

		# VERIFICA SE EXISTE
		$this->Correcao->id = $id;
		if (!$this->Correcao->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		# CONSULTA CORREÇÃO
		$options = array(
			'conditions'=>array(
				'Correcao.'.$this->Correcao->primaryKey => $id,
				'Correcao.status' => 1
			)
		);
		$this->Correcao->recursive = 0;
		$correcao = $this->Correcao->find('first', $options);
		$this->set('data', $correcao);

		# VERIFICA CONSULTA

			// se está vazio
			if(empty($correcao)){

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('action' => 'index'));
			}

			// se já foi análisado
			if($correcao['Correcao']['resultado']!=null OR $correcao['Correcao']['motivo']!=null){

				$this->Session->setFlash('Esse registro já foi analisado', 'layout/flash/flash_info');
				$this->redirect(array('action' => 'view', $correcao['Correcao']['id']));
			}


		# EXECUTA FUNÇÃO DE ACORDO COM A AÇÃO DO PEDIDO

			$pedido_acao = $correcao['Correcao']['acao'];
			$this->set('pedido_acao', $pedido_acao);

			if ($this->request->is(array('post', 'put'))) {

				// model Contato
				if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');

				// resultado da análise (A, AC, R)
				$resultado = $this->data['Correcao']['resultado'];
				$correcao['Correcao']['resultado'] = $resultado;

				switch ($resultado) {

					case 'A':
						
						$this->__aprovar($pedido_acao, $correcao);
						break;
										
					case 'AC':
						
						$correcao['Correcao']['data_after']['Contato'] = array_merge($correcao['Correcao']['data_after']['Contato'], $this->data['Contato']);
						$this->__aprovar_alteracao($pedido_acao, $correcao);
						break;
										
					case 'R':
						
						$this->__reprovar($pedido_acao, $correcao);
						break;
										
					default:

						$this->Session->setFlash('Falha ao analisar pedido, informe ao suporte.', 'layout/flash/flash_danger');
						$this->redirect(array('action' => 'index'));
						break;
				}
			}


		# VARIÁVEIS PARA FUNÇÃO / VIEW
			
			// logradouros
			$this->loadModel('Logradouro');
			$logradouros = $this->Logradouro->listaLogradouros();

			// bairro
			$this->loadModel('Bairro');
			$bairros = $this->Bairro->listaBairros();

			$this->set(compact('logradouros', 'bairros'));


		# EMPRESAS RELACIONADAS

			// variáveis para consulta
			$string = (isset($correcao['Correcao']['data']['Contato']['nome']))? $correcao['Correcao']['data']['Contato']['nome'] : null;
			$fone = (isset($correcao['Correcao']['data']['Contato']['fone1']))? $correcao['Correcao']['data']['Contato']['fone1'] : null;

			// consulta e seta para View
			$empresas_relacionadas = $this->_findEmpresasRelacionadas($string, $fone, $correcao['Correcao']['contato_id']);
			$this->set('empresas_relacionadas', $empresas_relacionadas);
	}

	protected function __aprovar(string $acao=null, array $data=null){

		// denunciou
		$data_after = $data['Correcao']['data_after'];
		$contato_id = (isset($data['Correcao']['contato_id']))? $data['Correcao']['contato_id'] : null;
		$Correcao['Correcao'] = $data['Correcao'];

		if($acao=='cadastrou'){

			if(isset($data_after['Contato']['user_id'])){

				# CADASTRO COM RESPONSÁVEL
					
					if( $id = $this->__atualizaCorrecao($Correcao) ){

						$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
						$this->redirect(array('controller'=>'correcoes', 'action'=>'view', $id, 'plugin'=>false));
					}
					else{

						$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
						$this->redirect(array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false));
					}
			}
			else{

				# CADASTRO NORMAL

					if( $this->__criaContato($data_after) ){


						if( $id = $this->__atualizaCorrecao($Correcao) ){

							$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
							$this->redirect(array('controller'=>'correcoes', 'action'=>'view', $id, 'plugin'=>false));
						}
						else{

							$this->Session->setFlash('Houve uma falha, por favor entre em contato.', 'layout/flash/flash_danger');
							$this->redirect(array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false));
						}
					}
					else{

						$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
					}
			}
		}

		if($acao=='corrigiu' or $acao=='sugeriu_telefone' or $acao=='reivindicou' or $acao=='informou_inexistencia' or $acao=='denunciou'){
			
			# ATUALIZA O REGISTRO DE EMPRESA COM A SUGESTÃO

				if( $this->__atualizaContato($contato_id, $data_after) ){

					if( $id = $this->__atualizaCorrecao($data) ){

						$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
						$this->redirect(array('controller'=>'correcoes', 'action'=>'view', $id, 'plugin'=>false));
					}
					else{

						$this->Session->setFlash('Houve uma falha, por favor entre em contato.', 'layout/flash/flash_danger');
						$this->redirect(array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false));
					}
				}
				else{

					$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
				}
		}
	}

	protected function __aprovar_alteracao(string $acao=null, array $data=null){

		return $this->__aprovar($acao, $data);
	}

	protected function __reprovar(string $acao=null, array $data=null){

		// informou_inexistencia, denunciou
		$data_after = $data['Correcao']['data_after'];
		$data_before = $data['Correcao']['data_before'];
		$contato_id = (isset($data['Correcao']['contato_id']))? $data['Correcao']['contato_id'] : null;
		$Correcao['Correcao'] = $data['Correcao'];

		if($acao=='cadastrou'){

			if(isset($data_after['Contato']['user_id'])){

				# CADASTRO COM RESPONSÁVEL

					$data_before['Contato']['user_id'] = null;
					$data_before['Contato']['cargo_responsavel'] = null;
					$data_before['Contato']['status'] = 0;
					
					if( $this->__atualizaContato($contato_id, $data_before) ){


						if( $id = $this->__atualizaCorrecao($Correcao) ){

							$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
							$this->redirect(array('controller'=>'correcoes', 'action'=>'view', $id, 'plugin'=>false));
						}
						else{

							$this->Session->setFlash('Houve uma falha, por favor entre em contato.', 'layout/flash/flash_danger');
							$this->redirect(array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false));
						}
					}
					else{

						$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
					}
			}
			else{

				# CADASTRO NORMAL

					if( $id = $this->__atualizaCorrecao($Correcao) ){

						$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
						$this->redirect(array('controller'=>'correcoes', 'action'=>'view', $id, 'plugin'=>false));
					}
					else{

						$this->Session->setFlash('Houve uma falha, por favor entre em contato.', 'layout/flash/flash_danger');
						$this->redirect(array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false));
					}
			}
		}

		if($acao=='corrigiu' or $acao=='sugeriu_telefone' or $acao=='informou_inexistencia' or $acao=='denunciou'){
			
			# ATUALIZA O REGISTRO DE EMPRESA COM A SUGESTÃO

				if( $id = $this->__atualizaCorrecao($data) ){

					$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
					$this->redirect(array('controller'=>'correcoes', 'action'=>'view', $id, 'plugin'=>false));
				}
				else{

					$this->Session->setFlash('Houve uma falha, por favor entre em contato.', 'layout/flash/flash_danger');
					$this->redirect(array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false));
				}
		}

		if($acao=='reivindicou'){
			
			# ATUALIZA O REGISTRO DE EMPRESA PARA DATA_BEFORE

				if( $this->__atualizaContato($contato_id, $data_before) ){

					if( $id = $this->__atualizaCorrecao($data)){

						$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
						$this->redirect(array('controller'=>'correcoes', 'action'=>'view', $id, 'plugin'=>false));
					}
					else{

						$this->Session->setFlash('Houve uma falha, por favor entre em contato.', 'layout/flash/flash_danger');
						$this->redirect(array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false));
					}
				}
				else{

					$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
					$this->redirect(array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false));
				}
		}
	}

	protected function __atualizaCorrecao(array $data=null){

		if(is_null($data) or !is_array($data)) return false;

		if($this->Correcao->save($data, array('validate'=>true))){

			return $this->Correcao->id;
		}

		return false;
	}

	protected function __atualizaContato(int $contato_id=null, array $data=null){

		# LoadModel
		if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');

		if(is_null($data) or !is_array($data)) return false;

		if(!is_null($contato_id)){

			$data['Contato']['id'] = $contato_id;

			// Fix de remediação para cpf_cnpj com máscara.
			if(isset($data['Contato']['cpf_cnpj'])){

				$data['Contato']['cpf_cnpj'] = preg_replace("/[^0-9]/", "", $data['Contato']['cpf_cnpj']);
			}

			if($this->Contato->save($data, array('validate'=>false))){

				return $this->Contato->id;
			}
		}

		return false;
	}

	protected function __criaContato(array $data=null){

		# LoadModel
		if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');
		
		if(is_null($data) or !is_array($data)) return false;

		$this->Contato->create();
		if($this->Contato->save($data, array('validate'=>true))){

			return $this->Contato->id;
		}

		return false;
	}

	protected function __desativaContato(int $contato_id=null){

		# LoadModel
		if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');
		
		if(is_null($contato_id) or !is_int($contato_id)) return false;

		$this->Contato->id = $contato_id;
		if($this->Contato->saveField('status', 0)){

			return $contato_id;
		}

		return false;
	}




/*	
====================================
CORREÇÕES / COLABORAÇÕES / DENÚNCIAS 
====================================
*/
	
	public function sugerir_correcao($contato_id=null){
		
		# Load Model
		if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');

		# Verifica se existe
		if (!$this->Contato->exists($contato_id)) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}
		else{

			$this->set('contato_id', $contato_id);
		}

		if($this->Correcao->verifica_correcao($contato_id)){

			$this->Session->setFlash('Já existe uma correção desta empresa aguardando análise.', 'layout/flash/flash_info');
			$this->redirect($this->referer());
		}

		# Parâmetros de consulta
		$options = array(
			'conditions' => array('Contato.' . $this->Contato->primaryKey => $contato_id),
			'fields' => array(
				'id', 'nome', 'fone1', 'logradouro_id', 'end_num', 'end_comp', 'end_ref', 'bairro_id'
			)
		);
		$this->Contato->recursive = -1;
		$empresa = $this->Contato->find('first', $options);

		# Validação diferente do Model
		$this->Contato->validator()->getField('fone1') // Fone 1
			->getRule('notBlank')->allowEmpty = true;
		$this->Contato->validator()->getField('end_ref') // Referência
			->getRule('notBlank')->allowEmpty = true;
		$this->Contato->validator()->getField('logradouro_id') // Logradouro 
			->getRule('notBlank')->allowEmpty = true;
		$this->Contato->validator()->getField('bairro_id') // Bairro
			->getRule('notBlank')->allowEmpty = true;

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			# Válida correção
			$this->Contato->set($this->data);
			if($this->Contato->validates()){

				# Corrige dados
				if(isset($this->data['Contato']['fone1'])){

					$this->request->data['Contato']['fone1'] = $this->Contato->foneFormatBeforeSave($this->data['Contato']['fone1']);
				}

				if($this->Correcao->salvaCorrecao($this->user_id, $contato_id, $empresa, $empresa, $this->data, 'corrigiu')){

					$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
					$this->redirect(array('controller'=>'contatos', 'action'=>'cadastro_concluido'));
				}
				else{

					$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
				}
			}
			else{

				$errors = $this->Contato->invalidFields();
			}
		}
		else{
			
			$this->request->data = $empresa;
		}

		# Logradouros
		$this->loadModel('Logradouro');
		$logradouros = $this->Logradouro->listaLogradouros();

		# Bairros
		$this->loadModel('Bairro');
		$bairros = $this->Bairro->listaBairros();

		$this->set(compact('logradouros', 'bairros'));
	}

	public function sugerir_telefone($contato_id=null){
		
		# Load Model
		if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');

		# Verifica se existe
		if (!$this->Contato->exists($contato_id)) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}
		else{

			$this->set('contato_id', $contato_id);
		}

		if($this->Correcao->verifica_correcao($contato_id)){

			$this->Session->setFlash('Já existe uma sugestão em análise.', 'layout/flash/flash_info');
			$this->redirect($this->referer());
		}

		# Parâmetros de consulta
		$options = array(
			'conditions' => array('Contato.' . $this->Contato->primaryKey => $contato_id),
			'fields' => array(
				'id', 'nome', 'fone1'
			)
		);
		$this->Contato->recursive = -1;
		$empresa = $this->Contato->find('first', $options);

		# Validação diferente do Model
		$this->Contato->validator()->getField('fone1') // Fone 1
			->getRule('notBlank')->allowEmpty = false;

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			# Válida correção
			$this->Contato->set($this->data);
			if($this->Contato->validates()){

				# Corrige dados
				if(isset($this->data['Contato']['fone1'])){

					$this->request->data['Contato']['fone1'] = $this->Contato->foneFormatBeforeSave($this->data['Contato']['fone1']);
				}

				if($this->Correcao->salvaCorrecao($this->user_id, $contato_id, $empresa, $empresa, $this->data, 'sugeriu_telefone')){

					$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
					$this->redirect(array('controller'=>'contatos', 'action'=>'cadastro_concluido'));
				}
				else{

					$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
				}
			}
		}
		else{
			
			$this->request->data = $empresa;
		}
	}

	public function sugerir_endereco($contato_id=null){}

	public function denunciar($contato_id=null){

		# VERIFICA SE A EMPRESA EXISTE
			
			if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');
			if (!$this->Contato->exists($contato_id)) {

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect($this->referer());
			}

		# VERIFICA SE JÁ EXISTE UMA CORREÇÃO EM ABERTO DESTA EMPRESA
			
			if($this->Correcao->verifica_correcao($contato_id)){

				$this->Session->setFlash('Já existe uma sugestão em análise.', 'layout/flash/flash_info');
				$this->redirect($this->referer());
			}

		# CONSULTA EMPRESA PELO ID
			
			$options = array(
				'conditions' => array('Contato.' . $this->Contato->primaryKey => $contato_id),
				'fields' => array(
					'id', 'nome', 'observacao'
				)
			);
			$this->Contato->recursive = -1;
			$empresa = $this->Contato->find('first', $options);

			// seta variavel e evita que vá para o form
			$observacao = $empresa['Contato']['observacao'];
			unset($empresa['Contato']['observacao']);

		# SE O FORM FOI SUBMETIDO, TENTA SALVAR O REGISTRO PARA ANÁLISE
			
			if ($this->request->is(array('post', 'put'))) {

				// configura array data
				$data['Contato'] = array_merge($empresa['Contato'], $this->data['Contato']);

				// configura array data_after
				$data_after = $this->data;
				$data_after['Contato']['status'] = 0;

				// consulta o campo observação e verifica
				if(!empty($observacao)){

					$data_after['Contato']['observacao'] = $observacao.'<br> '.$this->data['Contato']['observacao']; 
				}

				// tenta salvar a correção
				if( $this->Correcao->salvaCorrecao($this->user_id, $contato_id, $data, $empresa, $data_after, 'denunciou')){

					$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
					$this->redirect(array('controller'=>'contatos', 'action'=>'cadastro_concluido'));
				}
				else{

					$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
				}
			}
			else{
				
				$this->request->data = $empresa;
			}
	}

	public function informar_inexistencia($contato_id=null){

		# VERIFICA SE A EMPRESA EXISTE
			
			if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');
			if (!$this->Contato->exists($contato_id)) {

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect($this->referer());
			}

		# VERIFICA SE JÁ EXISTE UMA CORREÇÃO EM ABERTO DESTA EMPRESA
			
			if($this->Correcao->verifica_correcao($contato_id)){

				$this->Session->setFlash('Já existe uma sugestão em análise.', 'layout/flash/flash_info');
				$this->redirect($this->referer());
			}

		# CONSULTA EMPRESA PELO ID
			
			$options = array(
				'conditions' => array('Contato.' . $this->Contato->primaryKey => $contato_id),
				'fields' => array(
					'id', 'nome', 'observacao'
				)
			);
			$this->Contato->recursive = -1;
			$empresa = $this->Contato->find('first', $options);

			// seta variavel e evita que vá para o form
			$observacao = $empresa['Contato']['observacao'];
			unset($empresa['Contato']['observacao']);

		# SE O FORM FOI SUBMETIDO, TENTA SALVAR O REGISTRO PARA ANÁLISE
			
			if ($this->request->is(array('post', 'put'))) {

				// configura array data
				$data['Contato'] = array_merge($empresa['Contato'], $this->data['Contato']);

				// configura array data_after
				$data_after = $this->data;
				$data_after['Contato']['status'] = 0;

				// consulta o campo observação e verifica
				if(!empty($observacao)){

					$data_after['Contato']['observacao'] = $observacao.'<br> '.$this->data['Contato']['observacao']; 
				}

				// tenta salvar a correção
				if( $this->Correcao->salvaCorrecao($this->user_id, $contato_id, $data, $empresa, $data_after, 'informou_inexistencia')){

					$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
					$this->redirect(array('controller'=>'contatos', 'action'=>'cadastro_concluido'));
				}
				else{

					$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
				}
			}
			else{
				
				$this->request->data = $empresa;
			}
	}





/*	
====================================
AUXILIARES
====================================
*/
	
	/**
	 * Auxiliar para retornar as empresas relacionadas a correção
	 *
	 * String para consultar 
	 * @param string $string
	 *
	 * Fone para consultar por telefone
	 * @param int $fone
	 *
	 * Int para excluir a mepresa da correção
	 * @param int $contato_id
	 *
	 * @return array $empresas_relacionadas
	 *
	 **/
	protected function _findEmpresasRelacionadas($string=null, $fone=null, $contato_id=null){

		$options = array(
			'limit'=>150,
			'order' => 'Contato.nome ASC',
		);

		$conditions = array(
			'conditions'=>array(
				'Contato.status'=>true,
				'OR'=>array(
					'Contato.nome LIKE'=>'%'.$string.'%',
				),
			)
		);

		if(!is_null($contato_id)){

			$conditions['conditions']['NOT'] = array('Contato.id LIKE'=>$contato_id);
		}

		$OR_nome['Contato.nome LIKE'] = (strlen($string) < 3) ?
			$string.'%'
			:	'%'.$string.'%';

		$OR_fone = (strlen($fone) <= 4) ?
			array('substring(Contato.fone1, -4) LIKE'=> '%'.$fone.'%')
			:	array('Contato.fone1 LIKE'=> '%'.$fone.'%');

		if(is_null($fone) or empty($fone)) $OR_fone = array();
		if(is_null($string) or empty($string)) $OR_nome = array();

		$result['conditions']['OR'] = array_merge($OR_nome, $OR_fone, $conditions['conditions']['OR']);
		$conditions['conditions'] = array_merge($conditions['conditions'], $result['conditions']);
		$options = array_merge($conditions, $options);

		if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');

		$this->Contato->recursive = 0;
		$empresas_relacionadas = $this->Contato->find('all', $options);

		# Organiza empresas relacionadas
		$new_relacionadas = array();
		if(!empty($empresas_relacionadas)){

			foreach ($empresas_relacionadas as $key => $Data) {

				$new_relacionadas[$key]['Contato'] = $Data['Contato'];

				$fields = array('id', 'nome', 'fone1', 'end_completo', 'razao_social', 'cpf_cnpj', 'status', 'modified', 'user_id');
				
				foreach ($Data['Contato'] as $field => $value) {
					
					if(!in_array($field, $fields)){

						unset($new_relacionadas[$key]['Contato'][$field]);
					}
				}
			}
		}

		return $new_relacionadas;
	}

}
?>