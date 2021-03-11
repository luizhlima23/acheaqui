<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $components = array(
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
		'Facebook.Connect' => array(
			'model' => 'User',
			'modelFields' => array(
				'password' => 'password',
				'username' => 'email',
			),
			'createUser'=>true,
			'noAuth'=>false,
		),
    );

    public $helpers = array('Formata', 'FilterResults.Search', 'CakePtbr.Formatacao');
	
	public function beforeFilter() {
	    parent::beforeFilter();

		$this->Auth->allow('login', 'logout', 'change_password', 'remember_password', 'cadastro_usuario');

		# Campos de sessão do usuário
		$this->session_fields = Configure::read('Auth.session_fields');
	}




/*	
==========================
FACEBOOK CALLBACKS
==========================
*/
	public function beforeFacebookSave(){

		# Configurações padrões
		$this->Connect->authUser['User']['password'] = null;
		$this->Connect->authUser['User']['status'] = 1;
		$this->Connect->authUser['User']['role_id'] = ID_ROLE_USUARIO;

		# Busca API do facebook
		App::uses('FB', 'Facebook.Lib');
		$me = FB::api('/me?fields=first_name,last_name,picture'); // birthday
		
		# URL da Imagem de Perfil
		if(!empty($me['picture']['data']['url'])){
			// $this->Connect->authUser['User']['url_img'] = $me['picture']['data']['url'];
		}

		# Nome e Sobrenome
		if(!empty($me['first_name'])){
			$this->Connect->authUser['User']['nome'] = $me['first_name'];
		}
		if(!empty($me['last_name'])){
			$this->Connect->authUser['User']['sbnome'] = $me['last_name'];
		}

		# Data de nascimento
		// if(!empty($me['birthday'])){
		// 	$this->Connect->authUser['User']['Cadastro']['data_nascimento'] = $me['birthday'];
		// }

		return true;
	}
	public function beforeFacebookLogin($user){
		
		#Logic to happen before a facebook login
	}
	public function afterFacebookLogin(){

		// Salva logs de acesso
		$this->loadModel('LogAcesso');
		$this->LogAcesso->saveLog($this->Auth->user('id'), $this->request->clientIp(), $this->request->is('mobile'));

		# Bug Fix - Evita a "Mensagem de Faça login" após o login com facebook 
		$this->Session->delete('Message.auth');
		
		# Define variáveis na sessão do usuário
		$this->_atualizaSessaoUsuario(null, $this->session_fields);

		# Verifica campos do usuário
		$this->verifica_campos_usuario();

		# Se existir redirect então redireciona
		$this->loginRedirect(null);
	}




/*	
==========================
FUNÇÕES DE ACESSO
==========================
*/

	public function login($referer=null) {

		$this->set('title_for_layout', 'Login');

		# Verifica, se já estiver logado, direciona o usuário
		if($this->Auth->loggedIn()){

			# Define variáveis na sessão do usuário
			$this->_atualizaSessaoUsuario(null, $this->session_fields);

			# Se existir redirect então redireciona
			$this->loginRedirect(null);

			$this->redirect($this->Auth->redirectUrl());
		}

		if ($this->request->is('post')){

			if ($this->Auth->login()){	

				// Salva logs de acesso
				$this->loadModel('LogAcesso');
				$this->LogAcesso->saveLog($this->Auth->user('id'), $this->request->clientIp(), $this->request->is('mobile'));

				# Define variáveis na sessão do usuário
				$this->_atualizaSessaoUsuario(null, $this->session_fields);

				# Se existir redirect então redireciona
				$this->loginRedirect();

				$this->redirect($this->Auth->redirectUrl());
			}
			else{

				$this->Session->setFlash($this->mmAuth['incorrect_login'], 'layout/flash/flash_danger');
			}
		}
	}

	public function logout() {

		# Limpa Sessões
		$this->Session->destroy();
		$this->Session->setFlash(false);

	    $this->redirect($this->Auth->logout());
	}
	
	public function remember_password() {

		if ($this->request->is(array('post'))) {

			# Verifica se o email existe no sistema
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if (empty($user) OR $user['User']['id'] == 1) {
				$this->Session->setFlash($this->mmAuth['mail_not_exist'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'users', 'action'=>'remember_password', 'plugin'=>false));
			}

			$hash = $this->User->generateHashChangePassword();
			$data = array(
				'User' => array(
					'id' => $user['User']['id'],
					'user_hash_code' => $hash,
					'status' => 0
				)
			);

			# Tenta salvar
			if ($this->User->save($data)) {

				# CakeEmail 
				App::uses('CakeEmail', 'Network/Email');
				$email = new CakeEmail();
				$email->template('remember_password', 'default')
					->config('default')
					->emailFormat('html')
					->subject(__('Renovação de senha'))
					->to($user['User']['email'])
					->viewVars(array('hash' => $hash))
					->send();

				$this->Session->setFlash($this->mmAuth['mail_verify'], 'layout/flash/flash_info');
				$this->redirect(array('controller' => 'users', 'action' => 'login', 'plugin'=>false));
			}
			else{
				$this->Session->setFlash($this->mmAuth['not_renew_password'], 'layout/flash/flash_danger');
				$this->redirect(array('controller' => 'users', 'action' => 'login', 'plugin'=>false));
			}
		}
	}

	public function change_password($hash = null) {

		if(isset($this->request->data['User']['hash'])){
			$hash = $this->request->data['User']['hash'];
		}

		if(empty($hash) OR is_null($hash)){
			$this->redirect(array('controller' => 'users', 'action' => 'remember_password', 'plugin'=>false));
		}

		# Envia o hash para o formulário para verificar antes de alterar a senha
		$this->set('hash', $hash);

		if ($this->request->is('post')) {

			# Procura usuário pela Hash
			$user = $this->User->findByUserHashCode($hash);

			# Verifica usuário, se a hash for diferente ou em branco, então falha
			if ($user['User']['user_hash_code'] != $hash OR empty($user)) {
				
				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller' => 'users', 'action' => 'login', 'plugin'=>false));
			}

			# Se houver usuário, então tenta salvar
			if (!empty($user)) {

				# Configura alguns parâmetros
				$this->request->data['User']['id'] = $user['User']['id'];
				$this->request->data['User']['user_hash_code'] = '';
				$this->request->data['User']['status'] = 1;

				if ($this->User->save($this->request->data)) {
					
					$this->Session->setFlash($this->mmCrud['saved_password'], 'layout/flash/flash_success');
					$this->redirect(array('controller' => 'users', 'action' => 'login', 'dashboards', 'plugin'=>false));
				}
				else{

					$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
				}
			}
			else {

				$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'users', 'action' => 'login', 'plugin'=>false));
			}

		}	
	}

	public function cadastro_usuario(){
		
		# Se o formulário foi enviado
		if ($this->request->is(array('post', 'put'))) {
			
			$dados = $this->data;

			# Cria array padrão
			$dados['User']['role_id'] = ID_ROLE_USUARIO;
			$dados['User']['status'] = 1;

			# Termos de uso
			if(is_int(Configure::read('Documentos.termos_de_uso')) and Configure::read('Documentos.termos_de_uso') > 0){
				
				$dados['User']['termos_de_uso'] = Configure::read('Documentos.termos_de_uso');
			}

			# Tenta salvar os dados
			$this->User->create();
			if ($this->User->saveAssociated($dados)) {

				# Loga o usuário recem cadastrado
				$this->_atualizaSessaoUsuario($this->User->id, $this->session_fields);

				# Direciona
				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'users', 'action'=>'login'));
			}
			else {

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}
		}

		# Termos de uso e Politica de Privacidade
		if(!in_array('PostDocumento', $this->uses)) $this->loadModel('PostDocumento');
		$termos_de_uso = $this->PostDocumento->conteudo(Configure::read('Documentos.termos_de_uso'));
		$politica_privacidade = $this->PostDocumento->conteudo(Configure::read('Documentos.politica_privacidade'));
		
		$this->set('termos_de_uso', $termos_de_uso);
		$this->set('politica_privacidade', $politica_privacidade);
	}



/*	
==========================
FUNÇÕES DE USUÁRIO
==========================
*/
	public function meusdados(){
		
		# ID do usuário logado
		$id = $this->user_id;

		# Verifica se o usuário existe
		if (!$this->User->exists($id)) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('controller' => 'dashboards', 'action' => 'index'));
		}

		# Se o Formulário foi enviado, tenta Atualizar os dados no Banco
		if ($this->request->is(array('post', 'put'))) {

			if ($this->User->saveAssociated($this->request->data, array('validate' => 'only'))) {

				# Renova Auth Session
				$this->_atualizaSessaoUsuario(null, $this->session_fields);

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
			
				# Se existir redirect então redireciona
				$this->loginRedirect(null);

				$this->redirect( Router::url( $this->referer(), true ) );
			}
			else {

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}
		} 
		else {

			$options = array(
				'conditions' => array('User.' . $this->User->primaryKey => $id),
				'fields' => array(
					'id', 'nome', 'sbnome', 'email',
					'Cadastro.cpf', 'Cadastro.data_nascimento', 'Cadastro.sexo', 'Cadastro.telefone', 'Cadastro.id', 'status'
				),
			);
			$this->User->recursive = 0;
			$this->request->data = $this->User->find('first', $options);			
		}
	}




/*  
==========================
FUNÇÕES DE CRUD
==========================
*/
	public function index(){

		# Variáveis para função
		if(!in_array('Role', $this->uses)) $this->loadModel('Role');
		$roles = $this->Role->listaRoles();
		
		# Paginate Options
		$options = array(
			'conditions'=>array(),
			'fields'=>array('id', 'nome', 'email', 'role_id', 'status', 'created', 'Role.name', 'Role.id'),
			'order'=>'nome ASC'
		);
		$this->paginate = $options;

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('User')); // Estáticos
	    $this->Filter->addFilters(
	        array(
	            'f_role' => array(
	                'Role.id' => array(
	                    'select' => $this->Filter->select('Todos', $roles)
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

		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	public function view($id = null) {

		# Verifa se existe
		if (!$this->User->exists($id) OR $id == 1) {
			
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_info');
			$this->redirect(array('action' => 'index'));
		}

		$this->User->recursive = 1;
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/*  
==========================
OUTRAS
==========================
*/
	/**
	 * Alterar apenas a função de usuário
	 *
	 * @param int $id
	 * @return void
	 */
	public function alterar_funcao($id=null){
		
		# Verifica se o Usuário existe
		if (!$this->User->exists($id) OR $id == ID_ROLE_SUPERADMIN) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect($this->referer());
		}

		# Tenta salvar
		if($this->request->is(array('post', 'put'))){

			# Molda Array
			$data['User']['id'] = $this->request->data['User']['id'];
			$data['User']['role_id'] = $this->request->data['User']['role_id'];
			$data['User']['admin'] = $this->request->data['User']['admin'];

			if ($this->User->save($data)) {

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect(array('controller'=>'users', 'action'=>'index'));
			}
			else{

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
				$this->redirect(array('controller'=>'users', 'action'=>'index'));
			}
		}

		# Faz a consulta para o formulário
		$options = array(
			'conditions' => array(
				'User.' . $this->User->primaryKey => $id,
			),
			'fields'=>array('id', 'role_id', 'nome', 'sbnome', 'email', 'admin', 'Role.ordem')
		);
		$this->User->recursive = 0;
		$this->request->data = $this->User->find('first', $options);
		
		# Verifica se o Usuário pode alterar este registro
		if($this->request->data['Role']['ordem'] <= AuthComponent::user('Role.ordem')){
			$this->Session->setFlash($this->mmAuth['not_permission'], 'layout/flash/flash_danger');
			$this->redirect(array('controller'=>'users', 'action'=>'index'));
		}

		# Variáveis para o formulário
		$options_role = array(
			'conditions'=>array(
				'Role.id >='=> AuthComponent::user('role_id'), 'status'=>1
			),
		);
		$roles = $this->User->Role->find('list', $options_role);
		foreach ($roles as $k=>$v) {
			$roles[$k] = mb_strtoupper($v);
		}
		$this->set('roles', $roles);
	}

	/**
	 * Função auxiliar para atualizar a URL da imagem de perfil
	 *
	 * @param int $id, string $url
	 * @return boolean true or false
	 * @access protected
	 */
	protected function _updatePicture($id=null, $url=null){
		
		# Verifica se o usuário existe
		if (!$this->User->exists($id)) return false;

		# Atualiza URL do usuário
		$this->User->Cadastro->read(null, $id);
		$this->User->Cadastro->set('pic_url', $url);
		if($this->User->Cadastro->save()){
			return true;
		}

		return false;	
	}

}

?>