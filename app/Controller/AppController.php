<?php
App::uses('Controller', 'Controller');
App::uses('AuditableConfig', 'Auditable.Lib');

class AppController extends Controller {

	public $components = array(
		'Acl',
		'Auth',
		'Session',
		'DebugKit.Toolbar' => array('panels' => array('history' => false))
	);

	public $helpers = array(
		'AssetCompress.AssetCompress',
		'Facebook.Facebook',
		'Uploader.Upload'
	);

	protected $mmCrud = array();

	public function beforeFilter() {

		# AUTORIZA PÁGINAS ESTÁTICAS
		$this->Auth->allow('display');

		# AUTH COMPONENT - CONFIGURAÇÕES
		$this->Auth->loginError = __("Credenciais incorretas. Por favor, forneça um nome de usuário e senha válidos");
		$this->Auth->authError = __("Você não tem privilégios suficientes para acessar esse recurso");
		if(!$this->Auth->loggedIn()) $this->Auth->authError = __("Faça o login para continuar");
		
		$this->Auth->authorize = array(
			'Controller',
			'Actions' => array('actionPath' => 'controllers')
		);
		$this->Auth->loginAction = array(
			'controller' => 'users',
			'action' => 'login',
			'admin' => false,
			'plugin' => false
		);
		$this->Auth->logoutRedirect = array(
			'controller' => 'contatos',
			'action' => 'home',
			'admin' => false,
			'plugin' => false
		);
		$this->Auth->loginRedirect = array(
			'controller' => 'dashboards',
			'action' => 'index',
			'admin' => false,
			'plugin' => false
		);
		$this->Auth->authenticate = array(
			'Form' => array(
				'fields' => array(
					'username' => 'email', 'password' => 'password'
				),
				'scope' => array('User.status' => 1, 'Role.status' => 1)
			)
		);

		$this->set('referer', Router::url( $this->referer(), true ));

		# INCLUI ARQUIVO DE CONFIGURAÇÕES EXTRAS
		if (file_exists(APP . 'Config' . DS . 'config.php')) {	
			App::uses('PhpReader', 'Configure');
			Configure::config('PhpReader', new PhpReader());
			Configure::load('config', 'PhpReader');
		}

		# VARIÁVEIS GLOBAIS
		$this->_defineVars(Configure::read('Global.roles'));

		# VARIÁVEIS DE USUÁRIO
		$this->user_id = $this->Session->read('Auth.User.id');
		$this->user_isadmin = $this->Session->read('Auth.User.admin');
		$this->user_cadastro_id = $this->Session->read('Auth.User.cadastro_id');
		$this->role_id = $this->Session->read('Auth.User.role_id');
		$this->admin_menu = $this->Session->read('Auth.User.Role.admin_menu');

		# MENU DE ADMIN
		$Menu = Configure::read('Role.menu');
		$this->admin_menu = (isset($Menu[$this->admin_menu]))? $Menu[$this->admin_menu] : null;
		if($this->user_isadmin){
			
			$this->set('admin_menu', $this->admin_menu);
		}

		# THEMED
		$Theme = ($this->Auth->loggedIn())? 'Role'.$this->role_id : false;
		$this->theme = ucfirst(mb_strtolower($Theme));
		
		# MENSAGENS PADRÕES
		$this->mmCrud = array(
			'invalid' => __('Nenhum registro foi encontrado.'),
			'saved' => __('Os dados foram salvos.'),
			'saved_password' => __('Senha renovada com sucesso. Faça seu login!'),
			'not_saved' => __('Erro ao salvar os dados, verifique e tente novamente.'),
			'deleted' => __('Os dados foram removidos.'),
			'not_deleted' => __('Erro ao remover os dados. Por favor, tente novamente.'),
			'disabled' => __('Desativado com sucesso.'),
			'not_disabled' => __('Erro ao desativar o item. Por favor, tente novamente.'),
			'complete_cad' => __('Complete seu cadastro para continuar.'),
			'record_already_analyzed' => __('Este registro já foi analisado.'),
			'file_not_found' => __('Arquivo não encontrado.'),
			'file_deleted' => __('O arquivo foi removido.'),
		);
		$this->mmAuth = array(
			'incorrect_login' => __('Credenciais incorretas. Por favor, forneça um nome de usuário e senha válidos.'),
			'pass_not_match' => __('As senhas não coincidem.'),
			'mail_verify' => __('Acesse o e-mail informado para renovar a senha.'),
			'mail_failed' => __('Falha ao enviar o e-mail, contate o suporte do sistema.'),
			'mail_not_exist' => __('Este e-mail não existe em nosso sistema.'),
			'not_permission' => __('Você não tem permissão de acesso a estes dados.'),
			'not_renew_password' => __('Falha ao renovar a senha, entre em contato com o administrador do sistema!'),
			'need_login' => __('Faça o login para continuar.'),
			'user_disabled' => __('Cadastro desativado! Entre em contato com o administrador.'),
			'user_logout' => __('.'),
		);

		if($this->Auth->loggedIn()) {

			# Configurações do Plugin Auditable
			AuditableConfig::$responsibleId = $this->Auth->user('id');
		}

		# MENUS de usuário
		$user_menus = $this->_user_menus();
		$this->set('user_menus', $user_menus);

		# Diretório padrão de Banners
		$dir_banners = 'img'.'/'.'banners'.'/';
		if (!defined('DIR_BANNERS')) {
			define('DIR_BANNERS', $dir_banners);
		}
		$this->dir_banners = $dir_banners;
		$this->set('dir_banners', $this->dir_banners);

		# Serviços de Anúncio
		$this->pacotes = Configure::read('Servico');

		# VERIFICA CAMPOS OBRIGATÓRIOS DO USUÁRIO
		$this->verifica_campos_usuario();
	}

    public function isAuthorized($user) {
        return false;
        return $this->Auth->loggedIn();
    }

	/**
	 * Função auxiliar para criar o menu do usuário
	 *
	 * @return array $user_menus
	 **/
	protected function _user_menus(){
		
		# Menus disponiveis
		$menus = array(
			'A'=>array(
				'titulo'=>'Minha conta',
				'links'=>array(
					0=>array('Minhas empresas'=>array('controller'=>'contatos', 'action'=>'minhas_empresas')),
					1=>array('Meus dados'=>array('controller'=>'users', 'action'=>'meusdados')),
					2=>array('Alterar senha'=>array('controller'=>'users', 'action'=>'remember_password')),
				)
			),
			'B'=>array(
				'titulo'=>'Minhas atividades',
				'links'=>array(
					0=>array('Colaborações'=>array('controller'=>'correcoes', 'action'=>'user_index')),
					1=>array('Comentários'=>'#'),
				),
			),
			'C'=>array(
				'titulo'=>'Acessos e Permissões',
				'links'=>array(
					0=>array('Permissões ACL'=>array('controller'=>'acl', 'action'=>'permissions', 'plugin'=>'acl_manager')),
				),
			),
		);

		$MENU[ID_ROLE_SUPERADMIN] = array( // Superadmin
			'C'=>array(0),
		);
		$MENU[ID_ROLE_ADMIN] = array( // Administrador
			'A'=>array(0, 1, 2),
			'B'=>array(0)
		);
		$MENU[ID_ROLE_GESTOR_GERAL] = array( // Gestor Geral
			'A'=>array(0, 1, 2),
			'B'=>array(0)
		);
		$MENU[ID_ROLE_GESTOR_CONTEUDO] = array( // Gestor de conteudo
			'A'=>array(0, 1, 2),
			'B'=>array(0)
		);
		$MENU[ID_ROLE_GESTOR_FINANCEIRO] = array( // Gestor de conteudo
			'A'=>array(0, 1, 2),
			'B'=>array(0)
		);
		$MENU[ID_ROLE_CLIENTE] = array( // Cliente
			'A'=>array(0, 1, 2),
			'B'=>array(0)
		);
		$MENU[ID_ROLE_USUARIO] = array( // Usuário
			'A'=>array(1, 2),
			'B'=>array(0)
		);
		
		# Monta menu de acordo com o usuário
		$user_menus = null;
		foreach ($menus as $M => $D) {
			
			# Se existe o menu $M do usuário
			if(isset($MENU[$this->role_id][$M])){

				foreach ($MENU[$this->role_id][$M] as $n) {

					$item = each($menus[$M]['links'][$n]);
					$user_menus[$M][$D['titulo']][$item['key']] = $item['value'];
				}
			}
		}

		return $user_menus;
	}

	/**
	 * Função auxiliar definir variáveis de configuração do sistema
	 *
	 * @return boolean true or false
	 **/
	protected function _defineVars($vars=null){

		if(is_null($vars) or !is_array($vars)) return false;

		foreach ($vars as $k => $v) {

			if (!defined($k)) {
				define($k, $v);
			}
		}

		return true;
	}

/**
 * Função auxiliar para checar dados de cadastro do usuário!
 *
 * @return boolean true or false
 **/
    protected function _verificaCadastro($notempty=null){
        
        # Campos obrigatórios
        if(is_null($notempty)) return true;

        if(is_array($notempty)){
            
            if(is_numeric(AuthComponent::user('Cadastro.id'))){
                
                foreach ($notempty as $model => $campos) {

                    foreach ($campos as $key => $value) {
                        if(empty(AuthComponent::user("$model.$value"))) return false;
                    }
                }

                return true;
            }
        }

        return false;
    }

/**
 * Função atualizar os dados da sessão do usuário logado
 *
 * @return void
 **/
	protected function _atualizaSessaoUsuario($user_id=null, $fields=null){

		if(is_null($user_id)) $user_id = AuthComponent::user('id');

		# LoadModel
		if(!isset($this->User)) {
			$this->loadModel('User');
		}

		# Consulta o usuário
		$this->User->recursive = 0;
		$user = $this->User->read($fields, $user_id);

		# Organiza array
		$auth_user = (isset($user['User']))? $user['User'] : null;
		$auth_user['Role'] = (isset($user['Role']))? $user['Role'] : null;
		$auth_user['Cadastro'] = (isset($user['Cadastro']))? $user['Cadastro'] : null;

		# Atualiza Sessão
		$this->Auth->login($auth_user);
	}

	/**
	 * Função atualizar os dados da sessão do usuário logado
	 *
	 * @return void
	 **/
	public function loginRedirect($url=null, $redirect=true){
			
		if(!is_null($url)){

			$this->Session->write('loginRedirect', $url);

			if($redirect)
				$this->redirect(array('controller'=>'users', 'action'=>'login', 'plugin'=>false));
		}
		else{

			if( $url = $this->Session->read('loginRedirect') ){

				$this->Session->delete('loginRedirect');
				if($redirect) $this->redirect($url);
			}
		}

		return $url;
	}

	/**
	 * Verifica se o link é interno ou externo
	 *
	 * @param string $link
	 * @return bool true or false
	 **/
	public function verificarLink($link=null){

		$dominio = $_SERVER['SERVER_NAME'];

		$info = parse_url($link);
		$host = isset($info['host']) ? $info['host'] : "";
		
		return ((!empty($host) && strcasecmp($host, $dominio) == 0) ? true : false);
	}

	/**
	 * Auxiliar para criar o campo virtual increment;
	 *
	 * @return bool true
	 * @access public
	 */
	public function _virtual_increment($model=null){

		# Model
		if(!in_array($model, $this->uses)) $this->loadModel($model);

		# Cria o campo virutal
		if( $this->{$model}->virtualFields['increment'] = true ){
			return true;
		}
		
		return false;
	}

	/**
	 * Auxiliar para verificar e validar campos obrigatórios de um usuário logado
	 *
	 * @access protected
	 */
	public function verifica_campos_usuario(){

		$logout = ( $this->request->params['action']!='logout' OR $this->request->params['controller']!='users')? false : true;

		if($this->Auth->loggedIn() and !$logout and $this->role_id > ID_ROLE_SUPERADMIN){

			# DATA DE NASCIMENTO
			$action = 'meusdados';
			$controller = 'users';
			$data_nascimento = $this->Session->read('Auth.User.Cadastro.data_nascimento');

			if(empty($data_nascimento)){

				if( $this->request->params['action']!=$action OR $this->request->params['controller']!=$controller ){

					$this->Session->setFlash('Complete seus dados de cadastro para continuar.', 'layout/flash/flash_info');
					$this->redirect(array('controller'=>$controller, 'action'=>$action, 'admin'=>false, 'plugin'=>false));
				}
			}
		}
	}

	/**
	 * Retorna o próximo Banner Premium na lista de exibição
	 *
	 * @param bool $count (opcional): registrar a view do Banner;
	 * @access public
	 */
	public function getBannerPremium($banners=array(), $count=true){

		// Get Banners Premium
		$all_banners = $banners;
		if(empty($all_banners)){

			if(!in_array('BannerC', $this->uses)) $this->loadModel('BannerC');
			$all_banners = $this->BannerC->lista(12); // 12 = limite
		}

		// Retorna apenas o próximo a ser exibido
		$bannerPremium = $this->Banner->getBannerPremium($all_banners);

		// View Count
		if($count and !empty($bannerPremium['BannerC']['imagem'])){

			
			if(!in_array('Viewer', $this->uses)) $this->loadModel('Viewer');
			$this->Viewer->saveViewLog('BannerC', $bannerPremium['BannerC']['id'], $this->user_id);
		}

		return $bannerPremium;
	}

}
