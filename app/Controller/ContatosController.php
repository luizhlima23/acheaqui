<?php
App::uses('AppController', 'Controller');

class ContatosController extends AppController{

	public $uses = array('Contato');

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
        'Tool',
        'Banner',
        'Session'
    );

    public $helpers = array('Formata', 'FilterResults.Search', 'CakePtbr.Formatacao', 'Js' => array('Jquery'));
	
	public function beforeFilter() {
	    parent::beforeFilter();
		
		# Autoriza métodos públicos
	    $this->Auth->allow('home', 'pesquisa', 'empresa', 'auto_completar', 'anunciar_empresa', 'cadastrar_empresa', 'sugerir_correcao', 'sorteio');

		# Titulo geral
		if(empty($title_for_layout)){

			$this->set('title_for_layout', 'Empresas');
		}
	}
	
	/**
	 * Página inicial do guia.
	 *
	 * @access public
	 */
	public function home(){

		# Configurações da Página
		$this->layout = 'home';

		$this->_homeSEO();

		# FIX - bug de página
		if( $this->here != $this->webroot ){

			$this->redirect('/');
		}

		# Anúncio Premium
		$banner_premium = $this->getBannerPremium();
		$this->set('banner_premium', $banner_premium);
	}

	/**
	 * Página temporário de sorteio.
	 *
	 * @access public
	 */
	public function sorteio(){

		$this->set('q', 'sorteio');
		$this->_sorteioSEO();

		if($this->Auth->loggedIn()){

			# Configurações da Página
			$this->layout = 'default';
			
			# Anúncio Premium
			$banner_premium = $this->getBannerPremium();
			$this->set('banner_premium', $banner_premium);
		}
		else{
			
			$this->Session->setFlash($this->mmAuth['need_login'], 'layout/flash/flash_info');

			# Redireciona o usuário após o login
			$loginRedirect = Router::url(array('controller'=>'contatos', 'action'=>'sorteio', 'plugin'=>false), true);
			$this->loginRedirect($loginRedirect);

			$this->render('/Users/login');
		}

	}


/**
==========================
CADASTRO E DIVULGAÇÃO
==========================
*/
	/**
	 * Cadastrar anúncio em minhas empresas.
	 *
	 * @access public
	 */
	public function anunciar_empresa($id=null){
		
		# redirect
		$redirect = array('controller'=>'anuncios', 'action'=>'anunciar_empresa', 'plugin'=>false);

		$this->set('pacotes', $this->pacotes);
		
		if($this->Auth->loggedIn()){

			# SELECIONAR EMPRESA
			if(isset($this->params['named']['anunciar'])){

				$this->set('anunciar', true);

				# Consulta empresas do usuário
				$minhas_empresas = $this->Contato->lista_empresas_user($this->user_id);
				$this->set('minhas_empresas', $minhas_empresas);

				# Se o usuário não tiver nenhuma empresa cadastrada, então redireciona.
				if(empty($minhas_empresas)){

					$this->Session->setFlash('Cadastre sua empresa para continuar.', 'layout/flash/flash_info');
					$this->redirect(array('controller'=>'contatos', 'action'=>'cadastrar_empresa', 'option'=>'completo'));
				}

				$this->render('anunciar_empresa_escolha');
			}
			
			# EMPRESA SELECIONADA
			if(!is_null($id)){

				$this->set('anunciar', true);
				
				# Verifica se a empresa existe
				if (!$this->Contato->exists($id)) {
					$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
					$this->redirect(array('controller'=>'contatos', 'actions'=>'anunciar_empresa'));
				}

				# Verifica se já contem pedido
				if(!in_array('Pedido', $this->uses)) $this->loadModel('Pedido');
				if($this->Pedido->pedido_ativo($id)){

					$this->Session->setFlash('Já existe um pedido em aberto. Verifique!', 'layout/flash/flash_info');
					$this->redirect(array('controller'=>'pedidos', 'action'=>'meus_pedidos'));
				}

				# Verifica responsável;
				$responsavel_id = $this->Contato->_responsavel_id($id);
				if($responsavel_id != $this->user_id){

					$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
					$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
				}

				# Consulta a empresa selecionada pelo ID
				$this->Contato->recursive = 0;
				$options = array(
					'conditions' => array(
						'Contato.'.$this->Contato->primaryKey => $id,
						'Contato.user_id'=>$this->user_id,
						'Contato.status'=>1
					)
				);
				$empresa_selecionada = $this->Contato->find('first', $options);

				if(!empty($empresa_selecionada)){

					$this->set('empresa_selecionada', $empresa_selecionada);
				}
			}
		}
		else{
			
			# Se quero anunciar então solicita o login e retorna a página de anúncie;
			if(isset($this->params['named']['anunciar'])){

				$this->Session->setFlash($this->mmAuth['need_login'], 'layout/flash/flash_info');

				$loginRedirect = Router::url(array('controller'=>'anuncios', 'action'=>'anunciar_empresa', 'anunciar'=>'true', 'plugin'=>false), true);
				$this->loginRedirect($loginRedirect);
			}
		}
	}

	/**
	 * Cadastrar uma empresa
	 *
	 * @access public
	 */
	public function cadastrar_empresa($option=null){

		# Verifica login
		if($this->Auth->loggedIn()){

			$this->set('option', $option);

			# redirect
			$redirect = array('controller'=>'contatos', 'action'=>'anunciar_empresa');

			if($this->request->is(array('post', 'put'))){

				# DADOS DE CADASTRO DO USUARIO
				if(!isset($this->request->data['Cadastro']) OR empty($this->request->data['Cadastro']['id'])){

					if(!in_array('User', $this->uses)) $this->loadModel('User');
					$this->User->recursive = 0;
					$User = $this->User->find('first',
						array(
							'conditions'=>array('User.id'=>$this->user_id),
							'fields'=>array(
								'User.id', 'User.nome', 'User.sbnome', 'User.email','User.cadastro_id',
								'Cadastro.id', 'Cadastro.telefone', 'Cadastro.cpf'
							)
						)
					);

					if(isset($this->request->data['Cadastro']) and empty($this->request->data['Cadastro']['id'])){

						$this->request->data['Cadastro']['id'] = $User['Cadastro']['id'];
					}
					else{
						
						$this->request->data = array_merge($this->request->data, $User);
					}
				}

				# PESQUISA
				if(isset($this->request->data['Pesquisa']['pesquisa'])){

					$pesquisa = $this->data['Pesquisa']['pesquisa'];

					if(!empty($pesquisa)){

						# Gera o array options de acordo com os parametros de pesquisa
						$options = $this->_optionsPesquisa($pesquisa, 'Cristalina');
						
						# Busca os contatos
						$this->Contato->recursive = 0;
						$empresas = $this->Contato->find('all', $options);
						$this->set('empresas', $empresas);

						// $this->request->data['Contato']['nome'] = $pesquisa;
					}
				}

				if(!in_array('User', $this->uses)) $this->loadModel('User');
				if(!in_array('Cadastro', $this->uses)) $this->loadModel('Cadastro');

				# VALIDAÇÃO - User
				$this->User->validator()->getField('nome') // Nome
					->getRule('notBlank')->allowEmpty = false;
				$this->User->validator()->getField('email') // E-mail
					->getRule('email')->allowEmpty = false;

				# VALIDAÇÃO - Cadastro
				$this->Cadastro->validator()->getField('telefone') // Telefone
					->getRule('notBlank')->allowEmpty = false;
				$this->Cadastro->validator()->getField('cpf') // CPF
					->getRule('valid')->allowEmpty = false;

				# VALIDAÇÃO - Contato
				$this->Contato->validator()->getField('cpf_cnpj')->getRule('lengthBetween')->rule = array('lengthBetween', 14, 14); // Contato CPF_CNPJ
				$this->Contato->validator()->getField('cpf_cnpj')->getRule('lengthBetween')->message = 'O CNPJ deve conter 14 digitos.'; // Contato CPF_CNPJ
				$this->Contato->validator()->getField('cpf_cnpj')->getRule('valid')->message = 'Insira um CNPJ válido!'; // Contato CPF_CNPJ


				$data = $this->request->data;
				if(isset($pesquisa)) $this->request->data['Contato']['nome'] = $pesquisa;

				# CADASTRO
				if (isset($data['Contato'])) {

					// Se a empresa não tiver endereço, então obriga a inserção do telefone
					if($data['Form']['endereco'] == 'nao'){

						$this->Contato->validator()->getField('fone1')
							->getRule('notBlank')->allowEmpty = false;
					}

					// Verifica o responsável pela Empresa/Negócio
					$e_responsavel = $data['Contato']['responsavel'];
					unset($data['Contato']['responsavel']); // Elimina valor do array para não ir ao BD

					if($e_responsavel){	

						# CRIA A EMPRESA E REGISTRA A CORREÇÃO.

							$data['Contato']['user_id'] = $this->user_id;
							$data['User']['id'] = $this->user_id;

							// Função de usuário
							if($this->role_id == ID_ROLE_USUARIO) $data['User']['role_id'] = ID_ROLE_CLIENTE;
							
							$dataUser['User'] = $data['User'];
							$dataUser['Cadastro'] = $data['Cadastro'];

							// Tenta salvar dados do usuário
							if(!in_array('User', $this->uses)) $this->loadModel('User');
							if($this->User->saveAssociated($dataUser)){

								// Se a empresa for informal, então altera a validação para CPF.
								$dataContato['Contato'] = $data['Contato'];
								if($dataContato['Contato']['informal']){

									$dataContato['Contato']['razao_social'] = $dataUser['User']['nome'].' '.$dataUser['User']['sbnome'];
									$dataContato['Contato']['cpf_cnpj'] = $dataUser['Cadastro']['cpf'];
									
									$this->Contato->validator()->getField('cpf_cnpj')->getRule('lengthBetween')->rule = array('lengthBetween', 11, 11); 
									$this->Contato->validator()->getField('cpf_cnpj')->getRule('lengthBetween')->message = 'O CPF deve conter 11 digitos.'; 
									$this->Contato->validator()->getField('cpf_cnpj')->getRule('valid')->message = 'CPF inválido!'; 
									
									unset($this->Contato->validate['cpf_cnpj']['isUnique']); 
								}
								unset($dataContato['Contato']['informal']);

								# Data Before
								$data_before = $dataContato;
								$data_before['Contato']['status']=0;


								// Tenta salvar a empresa
								if($this->Contato->save($dataContato)){

									// Tenta salvar a correção: salvaCorrecao(user_id, contato_id, data, dataBefore, dataAfter, acao)
									if(isset($dataContato['Contato']['fone1'])){

										$dataContato['Contato']['fone1'] = $this->Contato->foneFormatBeforeSave($dataContato['Contato']['fone1']);
									}
									if(!in_array('Correcao', $this->uses)) $this->loadModel('Correcao');
									$this->Correcao->salvaCorrecao($this->user_id, $this->Contato->id, $dataContato, $data_before, $dataContato, 'cadastrou');

									// Atualiza sessão do usuário
									$this->_atualizaSessaoUsuario($this->User->id, $this->session_fields);
									
									$loginRedirect = $this->loginRedirect(null, false);

									if(!empty( $loginRedirect )){

										$loginRedirect = $loginRedirect.'/cod:'.$this->Contato->id;
										$this->loginRedirect($loginRedirect);
									}
									else{

										$this->Session->setFlash(
											'Sucesso! Agora escolha um dos nossos serviços de publicidade.',
											'layout/flash/flash_success'
										);
										$this->redirect(array('controller'=>'anuncios', 'action'=>'anunciar_empresa'));
									}
								}
								else{

									$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
								}
							}
							else{

								$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
							}

					}else{

						# REGISTRA A CORREÇÃO MAS NÃO CRIA UMA EMPRESA AINDA.

							// Valida os dados da empresa antes de criar a correção.
							$dataContato['Contato'] = $data['Contato'];
							$this->Contato->set($dataContato);
							if($this->Contato->validates()){
								
								// 
								if(isset($dataContato['Contato']['fone1'])){

									$dataContato['Contato']['fone1'] = $this->Contato->foneFormatBeforeSave($dataContato['Contato']['fone1']);
								}

								// Tenta salvar a correção: salvaCorrecao(user_id, contato_id, data, dataBefore, dataAfter, acao)
								if(!in_array('Correcao', $this->uses)) $this->loadModel('Correcao');
								if( $this->Correcao->salvaCorrecao($this->user_id, null, $dataContato, null, $dataContato, 'cadastrou') ){

									# Página de agradecimento
									$this->Session->setFlash('Cadastro efetuado com sucesso!', 'layout/flash/flash_success');
									$this->redirect(array('controller'=>'contatos', 'action'=>'cadastro_concluido'));
								}
								else{

									$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
								}
							}
							else{

								$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
							}
					}
				}

				# Logradouros
				$this->loadModel('Logradouro');
				$logradouros = $this->Logradouro->listaLogradouros();
				
				# Bairros
				$this->loadModel('Bairro');
				$bairros = $this->Bairro->listaBairros();
				$this->set(compact('logradouros', 'bairros'));
			}			
		}
		else{

			$this->Session->setFlash($this->mmAuth['need_login'], 'layout/flash/flash_info');

			$loginRedirect = Router::url(array('controller'=>'contatos', 'action'=>'cadastrar_empresa', 'plugin'=>false), true);
			$this->loginRedirect($loginRedirect);
		}

		# Termos de uso e Politica de Privacidade
		if(!in_array('PostDocumento', $this->uses)) $this->loadModel('PostDocumento');
		$termos_de_uso = $this->PostDocumento->conteudo(Configure::read('Documentos.termos_de_uso'));
		$politica_privacidade = $this->PostDocumento->conteudo(Configure::read('Documentos.politica_privacidade'));
		
		$this->set('termos_de_uso', $termos_de_uso);
		$this->set('politica_privacidade', $politica_privacidade);
	}

	/**
	 * Reivindicar uma empresa, liga a empresa ao usuário.
	 *
	 * @param int $id (ID do Contato)
	 * @access public
	 */
	public function reivindicar_empresa($id=null){

		# VERIFICA SE A EMPRESA EXISTE

			if (!$this->Contato->exists($id)) {
				
				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'contatos', 'action'=>'cadastrar_empresa'));
			}

		# VERIFICA SE JÁ EXISTE USUÁRIO RESPONSÁVEL

			// Verifica o responsável pela Empresa/Negócio
			$responsavel_id = $this->Contato->_responsavel_id($id);
			if(is_null($responsavel_id)){
				
				if($this->request->is(array('post', 'put'))) {

					// Validação diferente do Model
					if(!in_array('User', $this->uses)) $this->loadModel('User');
					if(!in_array('Cadastro', $this->uses)) $this->loadModel('Cadastro');
					$this->User->validator()->getField('nome') // Nome
						->getRule('notBlank')->allowEmpty = false;
					$this->User->validator()->getField('email') // E-mail
						->getRule('email')->allowEmpty = false;
					$this->Cadastro->validator()->getField('telefone') // Telefone
						->getRule('notBlank')->allowEmpty = false;
					$this->Cadastro->validator()->getField('cpf') // CPF
						->getRule('valid')->allowEmpty = false;

					# VALIDAÇÃO - Contato
					$this->Contato->validator()->getField('cpf_cnpj')->getRule('lengthBetween')->rule = array('lengthBetween', 14, 14); // Contato CPF_CNPJ
					$this->Contato->validator()->getField('cpf_cnpj')->getRule('lengthBetween')->message = 'O CNPJ deve conter 14 digitos.'; // Contato CPF_CNPJ
					$this->Contato->validator()->getField('cpf_cnpj')->getRule('valid')->message = 'Insira um CNPJ válido!'; // Contato CPF_CNPJ

					$data = $this->data;
					$data['User']['id'] = $this->user_id; 
					unset($data['Contato']);

					# Função de usuário
					if($this->role_id > ID_ROLE_CLIENTE) $data['User']['role_id'] = ID_ROLE_CLIENTE;
							
					if($this->User->saveAssociated($data)){

						// Liga a empresa ao usuário responsável, com cargo/função
						$dataContato['Contato'] = $this->data['Contato'];
						$dataContato['Contato']['user_id'] = $this->user_id;
								
						// Se a empresa for informal, então altera a validação para CPF.
						if($dataContato['Contato']['informal']){

							$dataContato['Contato']['razao_social'] = $data['User']['nome'].' '.$data['User']['sbnome'];
							$dataContato['Contato']['cpf_cnpj'] = $data['Cadastro']['cpf'];
							
							$this->Contato->validator()->getField('cpf_cnpj')->getRule('lengthBetween')->rule = array('lengthBetween', 11, 11); 
							$this->Contato->validator()->getField('cpf_cnpj')->getRule('lengthBetween')->message = 'O CPF deve conter 11 digitos.'; 
							$this->Contato->validator()->getField('cpf_cnpj')->getRule('valid')->message = 'CPF inválido!'; 
							
							unset($this->Contato->validate['cpf_cnpj']['isUnique']); 
						}
						unset($dataContato['Contato']['informal']);

						// Fix de remediação para cpf_cnpj com máscara.
						if(isset($dataContato['Contato']['cpf_cnpj'])){

							$dataContato['Contato']['cpf_cnpj'] = preg_replace("/[^0-9]/", "", $dataContato['Contato']['cpf_cnpj']);
						}

						// Consulta dados da empresa recem salva
						$this->Contato->recursive = -1;
						$options = array(
							'conditions' => array('Contato.' . $this->Contato->primaryKey => $dataContato['Contato']['id']),
						);
						$Contato =  $this->Contato->find('first', $options);

						// Tenta salvar a empresa
						if($this->Contato->save($dataContato)){
							
							// Atualiza sessão do usuário
							$this->_atualizaSessaoUsuario($this->User->id, $this->session_fields);

							// cria o registro da correção
							if(!in_array('Correcao', $this->uses)) $this->loadModel('Correcao');

							if( $this->Correcao->salvaCorrecao($this->user_id, $dataContato['Contato']['id'], $Contato, $Contato, $dataContato, 'reivindicou') ){

								$loginRedirect = $this->loginRedirect(null, false);

								if(!empty( $loginRedirect )){

									$loginRedirect = $loginRedirect.'/cod:'.$this->Contato->id;
									$this->loginRedirect($loginRedirect);
								}
								else{

									$this->Session->setFlash(
										'Sucesso! Agora escolha um dos nossos serviços de publicidade.',
										'layout/flash/flash_success'
									);
									$this->redirect(array('controller'=>'anuncios', 'action'=>'anunciar_empresa'));
								}
							}
							else{

								$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
							}
							$this->Correcao->salvaCorrecao($this->user_id, $dataContato['Contato']['id'], $Contato, $data_before, $dataContato, 'reivindicou');
						}
						else{

							$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
						}
					}
					else{

						$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
					}
				}
				else{
					
					# Dados do usuário
					if(!in_array('User', $this->uses)) $this->loadModel('User');
					$this->User->recursive = 0;
					$User = $this->User->find('first',
						array(
							'conditions'=>array('User.id'=>$this->user_id),
							'fields'=>array(
								'User.id', 'User.nome', 'User.sbnome', 'User.email',
								'Cadastro.id', 'Cadastro.telefone', 'Cadastro.cpf'
							)
						)
					);
					$this->request->data['User']['id'] = $User['User']['id'];
					$this->request->data['User']['nome'] = $User['User']['nome'];
					$this->request->data['User']['sbnome'] = $User['User']['sbnome'];
					$this->request->data['User']['email'] = $User['User']['email'];
					$this->request->data['Cadastro']['telefone'] = $User['Cadastro']['telefone'];
					$this->request->data['Cadastro']['cpf'] = $User['Cadastro']['cpf'];
					$this->request->data['Cadastro']['id'] = $User['Cadastro']['id'];
				}

				# Faz a consulta
				$this->Contato->recursive = 0;
				$options = array('conditions' => array('Contato.' . $this->Contato->primaryKey => $id));
				$this->set('contato', $this->Contato->find('first', $options));
			}
			else{

				$this->Session->setFlash('Esta empresa já possui um responsável cadastrado.', 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'contatos', 'action'=>'cadastrar_empresa'));
			}
			
			# Termos de uso e Politica de Privacidade
			if(!in_array('PostDocumento', $this->uses)) $this->loadModel('PostDocumento');
			$termos_de_uso = $this->PostDocumento->conteudo(Configure::read('Documentos.termos_de_uso'));
			$politica_privacidade = $this->PostDocumento->conteudo(Configure::read('Documentos.politica_privacidade'));
			
			$this->set('termos_de_uso', $termos_de_uso);
			$this->set('politica_privacidade', $politica_privacidade);
	}

	/**
	 * Desistir de uma empresa, desliga a empresa do usuário.
	 *
	 * @param int $id (ID do Contato)
	 * @access public
	 */
	public function desistir_empresa($id=null){

		if($this->request->is(array('post', 'put'))) {

			$contato_id = $this->data['Contato']['id'];
			$user_pwd = $this->data['User']['password'];
			
			# Verifica permissão
			if(!$this->Contato->permissao_usuario($contato_id, $this->user_id)){

				$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
			}

			if(!in_array('User', $this->uses)) $this->loadModel('User');
			if($this->User->valida_senha_usuario($this->user_id, $user_pwd)){

				if( $this->Contato->revogar_empresa_usuario($contato_id, $this->user_id) ){

					$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
					$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
				}
				else{

					$this->Session->setFlash('Falha ao revogar o acesso, entre em contato.', 'layout/flash/flash_danger');
					$this->redirect(array('controller'=>'mensagens', 'action'=>'contato'));
				}
			}
			else{

				$this->Session->setFlash('Senha incorreta!', 'layout/flash/flash_danger');
			}
		}
		else{

			# Verifica se a empresa existe
			if (!$this->Contato->exists($id)) {

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
			}
		}

		# Faz a consulta
		$this->Contato->recursive = -1;
		$options = array(
			'conditions' => array('Contato.' . $this->Contato->primaryKey => $id, 'status'=>1),
			'fields' => array('id', 'nome', 'user_id', 'cargo_responsavel', 'status')
		);

		$this->request->data = $this->Contato->find('first', $options);
		
		// Se não encontrar registros
		if(empty($this->request->data)){

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas', 'plugin'=>false));
		}
	}

	public function cadastro_concluido(){

	}



	

/*
==========================
FUNÇÕES DE PESQUISA
==========================
*/
	/**
	 * Função de Pesquisa principal de empresas
	 *
	 * @return array $empresas
	 * @access public
	 */
	public function pesquisa($q=null){
		
		$this->layout = 'home';

		$empresas = array();

		// query
		if(!empty($this->request->query['q'])) $q = $this->request->query['q'];

		if(!empty($q)) {
			
			// filtra a variável
			$q = addslashes(trim($q));
			$q = str_replace('%', '', $q); // evita pesquisa com apenas um caractere.
			$this->set('q', $q);

			// Sorteio
			if(mb_strtolower($q) == 'sorteio') $this->redirect(array('controller'=>'contatos', 'action'=>'sorteio'));

			// seo
			$this->_pesquisaSEO($q);

			if(!empty($q) AND strlen($q) >= 2){

				// TAGS RELACIONADAS - com isso o model gera o campo "tags_rel"
				if(!in_array('Etiqueta', $this->uses)) $this->loadModel('Etiqueta');
				$this->Etiqueta->virtualFields['inpBusca'] = '"'.$q.'"';

				// gera o array options de acordo com os parametros de pesquisa
				$options = $this->_optionsPesquisa($q, 'Cristalina');
				
				// faz a consulta
				$this->Contato->recursive = 0;
				$this->paginate = $options;
				$empresas = $this->Paginator->paginate();

				// salva logs com estatisticas da pesquisa
				$this->_atualizarEstatisticasPesquisa($empresas, $q);

				// sugestão de pesquisa
				$lista = $this->_listaDicionario();
				$sugestoes = $this->Tool->didyoumean($q, $lista, 10, 3);
				if(!empty($sugestoes)) $this->set('sugestoes', $sugestoes);
			}
			else{

				$this->Session->setFlash('Digite pelo menos 2 caracteres para pesquisa', 'layout/flash/flash_info');
			}

			// anúncio premium
			$banners = array();
			foreach ($empresas as $empresa) {
				
				if(isset($empresa['BannerC']['id'])){

					if(!empty($empresa['BannerC']['id']) and !empty($empresa['BannerC']['imagem'])){

						// $banner_premium['BannerC'] = $empresa['BannerC'];
						$banners[]['BannerC'] = $empresa['BannerC'];
					}
				}
			}
			$banner_premium = $this->getBannerPremium($banners, true);
			$this->set('banner_premium', $banner_premium);
		}

		$this->set('empresas', $empresas);
	}

	/**
	 * Página exlusiva da Empresa
	 *
	 * @access public
	 */
	public function empresa(string $var=null, $gerenciar=false){

		# HABTM unbind
		$this->Contato->unbindModel(
			array('hasMany' => array('BannerB'))
		);

		# HABTM bind
		$this->Contato->bindModel(
			array(
				'hasOne' => array(
					'Etiqueta' => array(
						'conditions' => array(
							'NOT'=>array('Etiqueta.id'=>null),
							'Etiqueta.status' => true,
							'Etiqueta.inicio <= CURDATE()',
							'Etiqueta.fim >= CURDATE()',
						)
					),
					'BannerA' => array(
						'conditions' => array(
							'NOT'=>array('BannerA.id'=>null),
							'BannerA.status' => true,
							'BannerA.inicio <= CURDATE()',
							'BannerA.fim >= CURDATE()',
						)
					),
					'BannerC' => array(
						'conditions' => array(
							'NOT'=>array('BannerC.id'=>null),
							'BannerC.status' => true,
							'BannerC.inicio <= CURDATE()',
							'BannerC.fim >= CURDATE()',
						)
					),
				),
			),
			false
		);

		# HABTM bind
		$this->Contato->bindModel(
			array(
				'hasMany' => array(
					'ContatoImagem' => array(
						'className' => 'ContatoImagem',
						'foreignKey' => 'contato_id',
						'dependent' => false,
						'conditions' => array('status'=>true),
						'fields' => '',
						'order' => array('capa'=>'DESC'),
						'limit' => 4,
					),
				),
			),
			false
		);

		// RELEVÂNCIA - Campo Virtual 
		$this->_virtual_relevancia();

		// parâmetros de consulta
		$options = array(
			'conditions'=>array(
				'Contato.status' => 1
			),
		);

		// identificador
		if(is_numeric($var)){

			$options['conditions']['Contato.'.$this->Contato->primaryKey] = $var;
		}
		else{

			$options['conditions']['Contato.slug'] = $var;
		}
		
		// consulta
		$this->Contato->recursive = 1;
		$empresa = $this->Contato->find('first', $options);

		// galeria de imagens
		if($empresa['Contato']['relevancia'] <= 0){
			unset($empresa['ContatoImagem']);
		}

		$this->set('empresa', $empresa);
	
		// log de views
		if(!$gerenciar){

			$this->_atualizarEstatisticasPesquisa($empresa);
		}

		// SEO
		$this->_empresaSEO($empresa);
	}

	/**
	 * Editor visual
	 *
	 * @access public
	 */
	public function empresa_editor_visual($contato_id=null){

		// verifica permissão de usuário para essa empresa
		if(!$this->Contato->permissao_usuario($contato_id, $this->user_id)){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		$gerenciar = true;
		$this->set('gerenciar', $gerenciar);

		// get slug
		$this->Contato->id = $contato_id;
		$slug = $this->Contato->field('slug');

		$this->empresa($slug, $gerenciar);
		$this->render('empresa');
	}

	/**
	 * Gerenciar/editar dados da Empresa
	 *
	 * @return array $contato
	 * @access public
	 */
	public function gerenciar_empresa($contato_id=null){

		# Verifica se a empresa existe
		if (!$this->Contato->exists($contato_id)) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Verifica permissão
		if(!$this->Contato->permissao_usuario($contato_id, $this->user_id)){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# HABTM bind
		$this->Contato->bindModel(
			array(
				'hasMany' => array(
					'ContatoImagem' => array(
						'conditions' => array(
							'NOT'=>array('ContatoImagem.imagem'=>null),
							'ContatoImagem.status' => true,
						)
					),
				),
			),
			false
		);

		// RELEVÂNCIA
		$this->_virtual_relevancia();

		# Faz a consulta
		$this->Contato->recursive = 1;
		$options = array(
			'conditions' => array(
				'Contato.' . $this->Contato->primaryKey => $contato_id,
				'Contato.status'=>1
			),
			'callbacks' => true
		);

		$Contato = $this->Contato->find('first', $options);

		if(empty($Contato)){

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Views
		$this->loadModel('Viewer');

			$mes_anterior = date('m', strtotime('-1 months', strtotime(date('Y-m-d'))));
			$this->set('mes_anterior', $mes_anterior);

			// Banner A
			if(isset($Contato['BannerA']['id'])){

				$Contato['BannerA']['views'] = $this->Viewer->countViewsMes('BannerA', $Contato['BannerA']['id']);
				$Contato['BannerA']['views_ant'] = $this->Viewer->countViewsMes('BannerA', $Contato['BannerA']['id'], null, $mes_anterior);
			}

			// Banner C
			if(isset($Contato['BannerC']['id'])){

				$Contato['BannerC']['views'] = $this->Viewer->countViewsMes('BannerC', $Contato['BannerC']['id']);
				$Contato['BannerC']['views_ant'] = $this->Viewer->countViewsMes('BannerC', $Contato['BannerC']['id'], null, $mes_anterior);
			}

		$this->set('data', $Contato);
	}



	

/*	
==========================
FUNÇÕES AUXILIARES
==========================
*/

	/**
	 * Função de AutoCompletar que retorna os contatos e palavras chave.
	 *
	 * @param ajax $this->params['url']['q']
	 * @return json $contatos, $tags
	 */ 
	public function auto_completar(){

		$this->request->onlyAllow('ajax');
		$this->layout = 'ajax';
		if($this->request->is('ajax')){

			$q = addslashes(trim($this->params['url']['q']));
			$q = str_replace('%', '', $q); // evita pesquisa com apenas um caractere.

			if(strlen($q) > 2){

				# Models
				if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');
				if(!in_array('Tag', $this->uses)) $this->loadModel('Tag');

				# Find Empresas
				$optContatos = $this->_optionsPesquisa($q, 'Cristalina');
				$optContatos['fields'] = array('nome');
				$optContatos['limit'] = 4;
				$this->Contato->recursive = 0;
				$contatos = $this->Contato->find('all', $optContatos);

				# Find Palavras Chave
				$optTag = array(
					'conditions'=> array('Tag.tag LIKE'=>'%'.$q.'%'),
					'fields'=>array('tag'),
					'limit'=> 5,
					'group'=>'Tag.tag'
				);
				$this->Tag->recursive = -1;
				$tags = $this->Tag->find('all', $optTag);

				# Seta as variáveis
				$this->set(array(
					'q' => $q,									// Seta para a view
					'contatos' => $contatos,					// Seta para a view
					'tags' => $tags,							// Seta para a view
					'_jsonp' => true							// And wrap it in the callback function
				));
			}
		}
	}

	/**
	 * Auxiliar para criar o campo virtual relevancia;
	 *
	 * @return bool true
	 * @access protected
	 */
	protected function _virtual_relevancia(){

		# RELEVÂNCIA - Campo Virtual 
		$this->Contato->virtualFields['relevancia'] = 'IF(Etiqueta.status LIKE true, 1, 0) + IF(BannerA.status LIKE true, 1, 0) + IF(BannerC.status LIKE true, 1, 0)';
		
		return true;
	}

	/**
	 * Função auxiliar para retornar os parametros da pesquisa principal
	 *
	 * @return array $paramsPesquisa
	 * @access protected
	 */
	protected function _parametrosPesquisa(){

		$paramsPesquisa = array();
		if ($this->request->is('post')) {
			
			# Seta variáveis
			$paramsPesquisa['inpBusca'] =  addslashes(trim($this->request->data['Contato']['inpBusca']));
			$paramsPesquisa['inpCidade'] = addslashes(trim('Cristalina'));

			# Grava na sessão
			$this->Session->write('paramsPesquisa', $paramsPesquisa);
		}
		else{

			if($this->Session->read('paramsPesquisa')){
				$paramsPesquisa = $this->Session->read('paramsPesquisa');
			}
		}

		return $paramsPesquisa;	
	}

	/**
	 * Função auxiliar para gerar o array options para a pesquisa principal
	 *
	 * @param string $strBusca, string $strCidade
	 * @return array $options
	 * @access protected
	 */
	protected function _optionsPesquisa($strBusca=null, $strCidade=null){

		# HABTM unbind
		$this->Contato->unbindModel(
			array('hasMany' => array('BannerB'))
		);

		# HABTM bind
		$this->Contato->bindModel(
			array(
				'hasOne' => array(
					'Etiqueta' => array(
						'conditions' => array(
							'NOT'=>array('Etiqueta.id'=>null),
							'Etiqueta.status' => true,
							'Etiqueta.inicio <= CURDATE()',
							'Etiqueta.fim >= CURDATE()',
						)
					),
					'BannerA' => array(
						'conditions' => array(
							'NOT'=>array('BannerA.id'=>null),
							'BannerA.status' => true,
							'BannerA.inicio <= CURDATE()',
							'BannerA.fim >= CURDATE()',
						)
					),
					'BannerC' => array(
						'conditions' => array(
							'NOT'=>array('BannerC.id'=>null),
							'BannerC.status' => true,
							'BannerC.inicio <= CURDATE()',
							'BannerC.fim >= CURDATE()',
						)
					),
				),
			),
			false
		);

    	$options = array();
		$hoje = date('Y-m-d'); // Pega a data de pesquisa para os parametros da query
		$intBusca = preg_replace("/[^a-zA-Z0-9]/", "", $strBusca);

		$options = array(
			'limit'=>20,
			'order' => array(
				'Contato.relevancia' => 'DESC',
				'Contato.nome' => 'ASC'
			),
			'group'=>'Contato.id'
		);

		$conditions = array(
			'conditions'=>array(
				'Contato.status'=>true,
				'OR'=>array(
					'Contato.nome LIKE'=>'%'.$strBusca.'%',
					'Etiqueta.tags LIKE'=>'%|'.$strBusca.'|%',
				),
			)
		);

		// Contato.nome LIKE
		if(strlen($strBusca) < 3){

			unset($conditions['conditions']['OR']['Contato.nome LIKE']);
			$conditions['conditions']['OR']['Contato.nome LIKE'] = $strBusca.'%';
		}

		// Contato.fone1 LIKE
		if( strlen($intBusca) >= 4 ){

			if( strlen($intBusca) <=5 ){

				$conditions['conditions']['OR']['Contato.fone1 LIKE'] = (strlen($intBusca) == 4)? '%'.$intBusca : $intBusca.'%';
				$conditions['conditions']['OR']['Contato.fone2 LIKE'] = (strlen($intBusca) == 4)? '%'.$intBusca : $intBusca.'%';
				$conditions['conditions']['OR']['Contato.fone3 LIKE'] = (strlen($intBusca) == 4)? '%'.$intBusca : $intBusca.'%';
				$conditions['conditions']['OR']['Contato.fone4 LIKE'] = (strlen($intBusca) == 4)? '%'.$intBusca : $intBusca.'%';
			}

			if( strlen($intBusca) >= 6 ){

				$conditions['conditions']['OR']['Contato.fone1 LIKE'] = '%'.$intBusca.'%';
				$conditions['conditions']['OR']['Contato.fone2 LIKE'] = '%'.$intBusca.'%';
				$conditions['conditions']['OR']['Contato.fone3 LIKE'] = '%'.$intBusca.'%';
				$conditions['conditions']['OR']['Contato.fone4 LIKE'] = '%'.$intBusca.'%';
			}
		}

		$options = array_merge($conditions, $options);

		# RELEVÂNCIA - Campo Virtual 
		$this->_virtual_relevancia();

		return $options;
	}

	/**
	 * Função auxiliar para retornar uma lista de palavras como um dicionário
	 *
	 * @return array $lista
	 * @access protected
	 */
	protected function _listaDicionario() {

		# Empresas
		$lista_contatos = $this->Contato->find('list', array(
			'fields' => array('Contato.nome'),
			'conditions' => array('Contato.status'=>true),
			'recursive' => -1,
			'order' => array('Contato.nome'=>'DESC'),
			'group' => array('Contato.nome')
		));

		# Tags
		if(!in_array('Tag', $this->uses)) $this->loadModel('Tag');
		$lista_tags = $this->Tag->find('list', array(
			'fields' => array('Tag.tag'),
			'conditions' => array('Tag.status'=>true),
			'recursive' => -1,
			'order' => array('Tag.tag'=>'DESC'),
			'group' => array('Tag.tag'),
		));

		$lista = array_merge($lista_contatos, $lista_tags);

		$lista_final = array();
		foreach ($lista as $item) {

			$item = mb_strtolower(trim($item)); // elimina espaços e deixa minusculo
			$item = $this->Tool->retira_acentos($item);
			
			$array_item = explode(' ', $item); // separa palavras do item em um array

			foreach ($array_item as $k=>$palavra) {

				if(strlen($palavra) >= 2){

					$array = $array_item;
					$new_itens = array_splice($array, $k); // combinações possíveis
					
					$array_inverso = $array_item;
					$new_itens_inverso = array_splice($array_inverso, -$k); // combinações possíveis - inversa

					// Se o primeiro elemento do array conter menos de 2 caracteres, então elimina
					if(strlen(reset($new_itens_inverso)) <2){

						array_shift($new_itens_inverso);
					}

					// Se o último elemento do array conter menos de 2 caracteres, então elimina
					if(strlen(end($new_itens_inverso)) <2){

						array_pop($new_itens_inverso);
					}

					// insere a combinação como instring no array de lista.
					array_push($lista_final, implode(' ', $new_itens));
					array_push($lista_final, implode(' ', $new_itens_inverso));

					foreach ($new_itens as $palavra) {
						
						array_push($lista_final, $palavra);
					}
				}
			}
		}
		$lista_final = array_unique(array_filter($lista_final));

		return $lista_final;
	}

	/**
	 * Função auxiliar para Atualizar as estatísticas de pesquisa, exempo views, order_average
	 *
	 * @param array $dados
	 *
	 * @return boolean true or false
	 * @access protected
	 */
	protected function _atualizarEstatisticasPesquisa($dados=null, $search_string=null){
		
		// Salva logs de pesquisa
		if(!empty($search_string)){

			$this->loadModel('LogPesquisa');
			$this->LogPesquisa->saveLog(
				$this->Auth->user('id'),
				$search_string,
				$this->request->clientIp(),
				$this->request->is('mobile')
			);
		}

		# corrige matriz
		if(!array_key_exists(0, $dados)) $dados[0] = $dados;

		# Load Model
		if(!in_array('Viewer', $this->uses)) $this->loadModel('Viewer');

		foreach ($dados as $k=>$d) {
			
			foreach ($d as $model=>$val) {
				
				# Models aceitos
				$accepteds = array('Contato', 'BannerA', 'BannerC');
				$not_null = array('imagem');

				if(in_array($model, $accepteds)){

					$is_null = false;
					foreach ($not_null as $field) {
						
						if(array_key_exists($field, $val)){

							if($val[$field]==null) $is_null=true;
						}
					}

					if(!is_null($val['id']) and $is_null==false){

						# Salva log de views
						$this->Viewer->saveViewLog($model, $val['id'], $this->user_id);
					}
				}
			}
		}
	}



	

/*
==========================
FUNÇÕES SEO
==========================
*/
	protected function _homeSEO(){

		$this->set('title_for_layout', 'AONDE - Cristalina GO');
		$this->set('meta_robots', true);
		$this->set('meta_canonical', 'http://www.aonde.info/');

		$meta_default = array(
			'description' => 'Encontre rapidamente o telefone ou o endereço da empresa que procura em Cristalina GO',
			'keywords' => 'cristalina go, telefone, endereço, empresa'
		);
		$this->set('meta_default', $meta_default);

		$meta_facebook = array(
			'og:title' 			=> 'AONDE - Cristalina GO',
			'og:site_name' 		=> 'Aonde',
			'og:url'			=> 'http://www.aonde.info/',
			'og:description'	=> 'Encontre rapidamente o telefone ou o endereço da empresa que procura em Cristalina GO',
			// 'og:image' 			=> Router::url('/img/layout/AONDE-cristalina-go-ICONE.png', true),
			// 'og:image:width'	=> 68,
			// 'og:image:height' 	=> 68,
			// 'og:image:type' 	=> 'image/png',
			'og:type'			=> 'website',
			'og:locale'			=> 'pt_BR'
		);
		$this->set('meta_facebook', $meta_facebook);

		$meta_twitter = array(
			'twitter:card' 			=> 'summary',
			'twitter:site'			=> '@aonde',
			'twitter:domain'		=> 'www.aonde.info',
			'twitter:url'			=> 'http://www.aonde.info/',
			'twitter:title' 		=> 'AONDE - Cristalina GO',
			'twitter:description'	=> 'Encontre rapidamente o telefone ou o endereço da empresa que procura em Cristalina GO',
			'twitter:creator'		=> 'Royal Branding'
		);
		$this->set('meta_twitter', $meta_twitter);
	}

	protected function _pesquisaSEO($q=null){
			
		$this->set('meta_robots', true);

		// meta canonical
		$meta_canonical = Router::url(array('action'=>'pesquisa'), true);
		$meta_canonical .= '/'.Inflector::slug($q, '+');
		$this->set('meta_canonical', $meta_canonical);

		// title
		$title = mb_strtoupper($q).' em Cristalina GO';
		$this->set('title_for_layout', $title);

		// description
		$meta_description = 'Resultados de pesquisa por '.mb_strtoupper($q).' em Cristalina GO';
		
		// keywords
		$meta_keywords = mb_strtolower($q).', cristalina go, telefone, endereço, empresa';

		$meta_default = array(
			'description'=>$meta_description,
			'keywords'=>$meta_keywords 
		);

		$meta_facebook = array(
			'og:title' 			=> $title,
			'og:site_name' 		=> 'Aonde',
			'og:url'			=> $meta_canonical,
			'og:description'	=> $meta_description,
			'og:type'			=> 'website',
			'og:locale'			=> 'pt_BR'
		);

		$meta_twitter = array(
			'twitter:card' 			=> 'summary',
			'twitter:site'			=> '@aonde',
			'twitter:domain'		=> 'www.aonde.info',
			'twitter:url'			=> $meta_canonical,
			'twitter:title' 		=> $title,
			'twitter:description'	=> $meta_description,
			'twitter:creator'		=> 'Royal Branding'
		);

		$this->set(compact('meta_default', 'meta_facebook', 'meta_twitter'));
	}

	protected function _empresaSEO($data=null){

		# variáveis para função:
		$slug = (!empty($data['Contato']['slug']))? $data['Contato']['slug'] : $data['Contato']['id'];
		$nome = trim($data['Contato']['nome']);
		$fone = $data['Contato']['fone1'];
		$email = $data['Contato']['email'];;
		$site = $data['Contato']['url_website'];;
		$cidade = trim($data['Cidade']['nome']);
		$estado = trim($data['Cidade']['estado_sigla']);
		$logradouro = trim($data['Logradouro']['logradouro']);
		$end_bairro = trim($data['Bairro']['nome']);
		$cep = $data['Contato']['cep'];
		$meta_canonical = Router::url(array('controller'=>'contatos', 'action'=>'empresa', 'var'=>$slug), true);
		$meta_galeria = (isset($data['ContatoImagem']))? $data['ContatoImagem'] : array();

		// title
		$title = mb_strtoupper($nome);
		$title .= (!empty($end_bairro) or !empty($cidade) or !empty($estado))? ' - ' : '';
		$title .= (!empty($end_bairro))? ucfirst($end_bairro) : '';
		$title .= (!empty($cidade) and !empty($end_bairro))? ', '.ucfirst($cidade) : ' '.ucfirst($cidade);
		$title .= (!empty($estado))? ' '.$estado : ' '.$estado;

		// description
		$meta_description = 'Encontre o telefone, endereço, produtos e serviços da empresa '.mb_strtoupper($nome);
		$meta_description .= (!empty($logradouro) or !empty($end_bairro) or !empty($cidade) or !empty($estado))? ', ' : ' ';
		$meta_description .= (!empty($logradouro))? ucfirst($logradouro) : '';
		$meta_description .= (!empty($end_bairro) and !empty($logradouro))? ' - '.ucfirst($end_bairro) : ' '.ucfirst($end_bairro);
		$meta_description .= (!empty($cidade) and !empty($end_bairro))? ', '.ucfirst($cidade) : ' '.ucfirst($cidade);
		$meta_description .= (!empty($estado) and !empty($cidade))? ' '.ucfirst($estado) : ' '.ucfirst($estado);

		// keywords
		$meta_keywords = mb_strtolower($nome).', cristalina go, telefone, endereço, empresa';
		if(!empty($end_bairro)) $meta_keywords .= ', '.mb_strtolower($end_bairro);

		$this->set('meta_robots', true);

		$this->set('title_for_layout', $title);
		$this->set('meta_canonical', $meta_canonical);

		$meta_default = array(
			'description'=>$meta_description,
			'keywords'=>$meta_keywords 
		);

		$meta_facebook = array(
			'og:title' 			=> $title,
			'og:site_name' 		=> 'Aonde',
			'og:url'			=> $meta_canonical,
			'og:description'	=> $meta_description,
			// 'og:image' 			=> Router::url('/img/layout/AONDE-cristalina-go-ICONE.png', true),
			// 'og:image:width'	=> 68,
			// 'og:image:height' 	=> 68,
			// 'og:image:type' 	=> 'image/png',
			'og:type'			=> 'article',
			'og:locale'			=> 'pt_BR'
		);

		$meta_fb_business = array(
			// 'place:location:latitude' 					=> '-16.770517',
			// 'place:location:longitude' 					=> '-47.610462',
			'business:contact_data:street_address' 		=> ucfirst($logradouro),
			'business:contact_data:locality'		 	=> ucfirst($cidade),
			'business:contact_data:region' 		 		=> 'Goiás',
			'business:contact_data:country_name'		=> 'Brasil',
			'business:contact_data:postal_code'		 	=> $cep,
			'business:contact_data:email' 				=> $email,
			'business:contact_data:phone_number'		=> $fone,
			'business:contact_data:website'			 	=> $site
		);

		$meta_twitter = array(
			'twitter:card' 			=> 'summary',
			'twitter:site'			=> '@aonde',
			'twitter:domain'		=> 'www.aonde.info',
			'twitter:url'			=> $meta_canonical,
			'twitter:title' 		=> $title,
			'twitter:description'	=> $meta_description,
			'twitter:creator'		=> 'Royal Branding'
		);

		$this->set(compact('meta_default', 'meta_facebook', 'meta_galeria', 'meta_fb_business', 'meta_twitter'));
	}

	protected function _sorteioSEO($data=null){

		# variáveis para função:
		$meta_canonical = Router::url(array('controller'=>'contatos', 'action'=>'sorteio'), true);

		// title
		$title = 'Sorteio de brindes em Cristalina GO';

		// description
		$meta_description = 'Sorteio de brindes em Cristalina GO';

		// keywords
		$meta_keywords = 'cristalina go, sorteio, brindes';

		$this->set('meta_robots', true);

		$this->set('title_for_layout', $title);
		$this->set('meta_canonical', $meta_canonical);

		$meta_default = array(
			'description'=>$meta_description,
			'keywords'=>$meta_keywords 
		);

		$meta_facebook = array(
			'og:title' 			=> $title,
			'og:site_name' 		=> 'Aonde',
			'og:url'			=> $meta_canonical,
			'og:description'	=> $meta_description,
			'og:image' 			=> Router::url('/img/AONDE-flyer-sorteio-ABR-06-BRINDES.jpg', true),
			'og:image:width'	=> 353,
			'og:image:height' 	=> 631,
			'og:image:type' 	=> 'image/jpg',
			'og:type'			=> 'article',
			'og:locale'			=> 'pt_BR'
		);

		$meta_twitter = array(
			'twitter:card' 			=> 'summary',
			'twitter:site'			=> '@aonde',
			'twitter:domain'		=> 'www.aonde.info',
			'twitter:url'			=> $meta_canonical,
			'twitter:title' 		=> $title,
			'twitter:description'	=> $meta_description,
			'twitter:creator'		=> 'Royal Branding'
		);

		$this->set(compact('meta_default', 'meta_facebook', 'meta_twitter'));
	}

	


/*	
==========================
FUNÇÕES DE CLIENTE/USUÁRIO
==========================
*/
	
	/**
	 * Exibe as empresas do cliente para edição
	 *
	 * @return array $empressas
	 */
	public function minhas_empresas(){		
		
		# Paginate Options
		$options = array(
			'conditions' => array('Contato.user_id'=>$this->user_id),
			'fields' => array('id', 'nome', 'status'),
			'order'=>array('nome'=>'ASC', 'status'=>'DESC')
		);

		$this->Contato->recursive = -1;
		$this->set('minhas_empresas', $this->Contato->find('all', $options));
	}

	/**
	 * Editar A - Edita nome, descrição;
	 *
	 * @param int $id
	 */
	public function editar_a($id=null){

		# Variáveis para view
		$this->set('contato_id', $id);
		$this->set('nome', $this->Contato->get_nome($id) );

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			# Tenta salvar os dados
			$data['Contato']['id'] = $this->data['Contato']['id'];
			$data['Contato']['nome'] = $this->data['Contato']['nome'];
			$data['Contato']['descricao'] = $this->data['Contato']['descricao'];

			if($this->Contato->save($data)){
				
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'contatos', 'action'=>$this->action, $this->Contato->id));
			}
			else{
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}
		}
		else {

			# Verifica o registro existe
			if (!$this->Contato->exists($id)) {
				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'dashboards', 'action'=>'index', 'plugin'=>false));
			}

			$options = array(
				'conditions' => array(
					'Contato.' . $this->Contato->primaryKey => $id,
					'Contato.status'=>true
				),
				'fields'=>array('id', 'nome', 'descricao', 'status'),
			);
			$this->request->data = $this->Contato->find('first', $options);

			// Se não encontrar registros
			if(empty($this->request->data)){

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas', 'plugin'=>false));
			}
		}
	}

	/**
	 * Editar Endereço;
	 *
	 * @param int $id
	 */
	public function editar_endereco($id=null){

		# Variáveis para view
		$this->set('contato_id', $id);
		$this->set('nome', $this->Contato->get_nome($id) );

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			# Array que será salvo no BD
			$data['Contato']['id'] = $this->data['Contato']['id'];
			$data['Contato']['logradouro_id'] = $this->data['Contato']['logradouro_id'];
			$data['Contato']['end_num'] = $this->data['Contato']['end_num'];
			$data['Contato']['end_comp'] = $this->data['Contato']['end_comp'];
			$data['Contato']['bairro_id'] = $this->data['Contato']['bairro_id'];
			$data['Contato']['end_ref'] = $this->data['Contato']['end_ref'];
			$data['Contato']['cidade_id'] = 71;
			$data['Contato']['cep'] = '73850000';

			if($this->Contato->save($data)){
				
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'contatos', 'action'=>$this->action, $this->Contato->id));
			}
			else{
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}
		}
		else {

			# Verifica o registro existe
			if (!$this->Contato->exists($id)) {
				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'dashboards', 'action'=>'index', 'plugin'=>false));
			}

			$options = array(
				'conditions' => array(
					'Contato.' . $this->Contato->primaryKey => $id,
					'Contato.status'=>true
				),
				'fields'=>array('id', 'logradouro_id', 'end_num', 'end_comp', 'bairro_id', 'end_ref', 'cidade_id', 'cep', 'status'),
			);
			$this->request->data = $this->Contato->find('first', $options);

			// Se não encontrar registros
			if(empty($this->request->data)){

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas', 'plugin'=>false));
			}
		}
		
		# Logradouros
		$this->loadModel('Logradouro');
		$logradouros = $this->Logradouro->listaLogradouros();

		# Bairros
		$this->loadModel('Bairro');
		$bairros = $this->Bairro->listaBairros();

		$this->set(compact('logradouros', 'bairros'));
	}

	/**
	 * Editar Telefones;
	 *
	 * @param int $id
	 */
	public function editar_telefone($id=null){

		# Variáveis para view
		$this->set('contato_id', $id);
		$this->set('nome', $this->Contato->get_nome($id) );

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			# Array que será salvo no BD
			$data['Contato']['id'] = $this->data['Contato']['id'];
			$data['Contato']['fone1'] = $this->data['Contato']['fone1'];
			$data['Contato']['fone2'] = $this->data['Contato']['fone2'];
			$data['Contato']['fone3'] = $this->data['Contato']['fone3'];
			$data['Contato']['fone4'] = $this->data['Contato']['fone4'];

			if($this->Contato->save($data)){
				
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'contatos', 'action'=>$this->action, $this->Contato->id));
			}
			else{
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}
		}
		else {

			# Verifica o registro existe
			if (!$this->Contato->exists($id)) {
				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'dashboards', 'action'=>'index', 'plugin'=>false));
			}

			$options = array(
				'conditions' => array(
					'Contato.' . $this->Contato->primaryKey => $id,
					'Contato.status'=>true
				),
				'fields'=>array('id', 'fone1', 'fone2', 'fone3', 'fone4', 'status'),
			);
			$this->request->data = $this->Contato->find('first', $options);

			// Se não encontrar registros
			if(empty($this->request->data)){

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas', 'plugin'=>false));
			}
		}
	}

	/**
	 * Editar e-mail, website e redes sociais;
	 *
	 * @param int $id
	 */
	public function editar_urls($id=null){

		# Variáveis para view
		$this->set('contato_id', $id);
		$this->set('nome', $this->Contato->get_nome($id) );

		# Verifica responsável;
		$responsavel_id = $this->Contato->_responsavel_id($id);
		if($responsavel_id != $this->user_id){

			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
		}

		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if($this->Contato->save($this->data)){
				
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'contatos', 'action'=>$this->action, 'contato_id'=>$this->Contato->id));
			}
			else{
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}
		}
		else {

			# Verifica o registro existe
			if (!$this->Contato->exists($id)) {
				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'dashboards', 'action'=>'index', 'plugin'=>false));
			}

			$options = array(
				'conditions' => array(
					'Contato.' . $this->Contato->primaryKey => $id,
					'Contato.status'=>true
				),
				'fields'=>array('id', 'email', 'url_website', 'url_facebook', 'url_twitter', 'url_google', 'status'),
			);
			$this->request->data = $this->Contato->find('first', $options);

			// Se não encontrar registros
			if(empty($this->request->data)){

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas', 'plugin'=>false));
			}
		}
	}



	

/*	
==========================
FUNÇÕES DE CRUD
==========================
*/

	public function index() {

		# Paginate Options
		$options = array(
			'conditions'=>array(),
			'order'=>'Contato.modified DESC'
		);
		$this->paginate = $options;

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('Contato')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_status' => array(
					'Contato.status' => array(
						'select' => $this->Filter->select('Todos', Configure::read('Option.status'))
					)
				)
			)
		);

		# Define conditions
		$this->Filter->setPaginate('conditions', $this->Filter->getConditions()); 
		
		# HABTM unbind
		$this->Contato->unbindModel(
			array(
				'hasOne' => array('Etiqueta', 'BannerA', 'BannerB', 'BannerC'),
				'belongsTo' => array('Cidade')
			)
		);

		$this->Contato->recursive = 0;
		$this->set('contatos', $this->Paginator->paginate());
	}

	public function view($id = null) {

		# Verifica se a função existe
		if (!$this->Contato->exists($id)) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		$options = array('conditions' => array('Contato.' . $this->Contato->primaryKey => $id));

		$this->Contato->recursive = 0;
		$this->set('contato', $this->Contato->find('first', $options));
	}

	public function delete($id = null) {

		$this->request->onlyAllow('post', 'delete');

		$this->Contato->id = $id;
		if (!$this->Contato->exists()) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}


		if ($this->Contato->delete()) {

			$this->Session->setFlash($this->mmCrud['deleted'], 'layout/flash/flash_success');
		}
		else {

			$this->Session->setFlash($this->mmCrud['not_deleted'], 'layout/flash/flash_warning');
		}

		return $this->redirect(array('action' => 'index'));
	}
	
	/**
	 * Alterar o usuário responsável pelo contato
	 *
	 * @param int $id
	 * @return void
	 */
	public function alterar_responsavel($id = null){
		
		# Verifica se o contato existe
		if (!$this->Contato->exists($id)) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}
		
		# Se o formulário foi enviado, tenta salvar
		if ($this->request->is(array('post', 'put'))) {

			if ($this->Contato->save($this->request->data)) {
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
			}
			else{
				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}

		}

		$options = array('conditions' => array('Contato.' . $this->Contato->primaryKey => $id));
		$this->Contato->recursive = -1;
		$this->request->data = $this->Contato->find('first', $options);

		# Logradouros
		$this->loadModel('User');
		$users = $this->User->listaUsuarios(true);

		$this->set(compact('users'));
	}

	/**
	 * Atualiza e gera slug de todas as empresas com o Slug nulo
	 *
	 * @access public
	 */
	public function update_slugs(){

		# Se diferente de Post
		if (!$this->request->is(array('post', 'put'))) {
			throw new MethodNotAllowedException();
		}

		$options = array(
			'conditions'=>array(
				'Contato.slug ='=>null
			)
		);

		$this->Contato->recursive = 0;
		$empresas = $this->Contato->find('all', $options);
		
		$count = 0;
		$content = '';
		foreach ($empresas as $data) {
			
			$id = $data['Contato']['id'];
			$nome = $data['Contato']['nome'];
			$cidade = $data['Cidade']['nome'];
			$estado = $data['Cidade']['estado_sigla'];

			if(!empty($nome) and !empty($cidade) and !empty($estado)){

				$update['Contato']['id'] = $id;
				$update['Contato']['slug'] = "$nome em $cidade $estado";
				if($this->Contato->save($update)){

					$count++;
				}
			}
		}

		if( $count > 0 ){

			$this->Session->setFlash('N° registros atualizados: '.$count, 'layout/flash/flash_success');
		}
		else{
			
			$this->Session->setFlash('Nenhum registro foi atualizado.', 'layout/flash/flash_danger');
		}

		$this->redirect(array('controller'=>'contatos', 'action'=>'index', 'plugin'=>false, 'admin'=>false));
		$this->render(false);
	}

}

?>