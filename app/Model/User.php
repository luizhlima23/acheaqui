<?php
App::uses('AppModel', 'Model');

class User extends AppModel {
	
	public $displayField = 'nome';

	public $validate = array(
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 6, 25),
				'message' => 'Sua senha deve ter entre 6 e 40 caracteres.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'confirm_password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 6, 25),
				'message' => 'Sua senha deve conter entre 6 e 25 caracteres.',
				'allowEmpty' => false,
				'required' => false
			),
		    'compare'    => array(
		        'rule'      => array('validate_passwords'),
		        'message' => 'As senhas que você digitou não são iguais.',
		    )
		),
		'role_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Insira uma função válida!',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'nome' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 3, 50),
				'message' => 'O nome deve conter entre 3 e 50 caracteres.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'sbnome' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 3, 50),
				'message' => 'O nome deve conter entre 3 e 50 caracteres.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Informe um e-mail válido',
				'allowEmpty' => false,
				'required' => false
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'E-mail já cadastrado em nosso sistema.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'facebook_id' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				'message' => 'Código de usuário no Facebook já cadastrado.',
				'allowEmpty' => true,
				'required' => false
			)
		),
		'status' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'aceito_termos_de_uso' => array(
			'checked' => array(
				'rule' => array('checked'),
				'message' => 'Você deve ler e concordar com os termos de uso.',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'admin' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => false,
				'required' => false
			),
		),
		'acl_admin' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Informe apenas números.',
				'allowEmpty' => false,
				'required' => false
			),
		),
		'created' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Informe a data e hora',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'modified' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				'message' => 'Informe a data e hora',
				'allowEmpty' => false,
				'required' => false
			)
		)
    );

	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cadastro' => array(
			'className' => 'Cadastro',
			'foreignKey' => 'cadastro_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function beforeSave($options = array()) {

		# Transforma senha normal em HASH antes de gravar no banco
		if (!empty($this->data['User']['password'])) {
	        $this->data['User']['password'] = AuthComponent::password(
	        	$this->data['User']['password']
	        );
		}

        return true;
    }

    public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false), 'Auditable.Auditable');

	public $virtualFields = array(
		'nome_completo' => 'CONCAT(User.nome, " ", User.sbnome)'
	);

   public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['role_id'])) {
            $roleId = $this->data['User']['role_id'];
        } else {
            $roleId = $this->field('role_id');
        }
        if (!$roleId) {
            return null;
        } else {
            return array('Role' => array('id' => $roleId));
        }
    }

	public function bindNode($user) {
	    return array('model' => 'Role', 'foreign_key' => $user['User']['role_id']);
	}

	public function validate_passwords() {
	    return $this->data[$this->alias]['password'] === $this->data[$this->alias]['confirm_password'];
	}

	public function valida_senha_usuario($user_id=null, $pwd=null){

		if(!empty($user_id) and !empty($pwd)){

			$user_pwd = $this->_getUserPassword($user_id);

			if($user_pwd === AuthComponent::password($pwd)){

				return true;
			}
		}

		return false;
	}

	/**
	 * Retorna a senha ainda com Hash do usuário informado
	 *
	 * @param int $user_id
	 * @return string $password
	 */
	protected function _getUserPassword($user_id=null){

		$this->id = $user_id;
		return $this->field('password');
	}

	public function generateHashChangePassword() {
		$salt = Configure::read('Security.salt');
		$salt_v2 = Configure::read('Security.cipherSeed');
		$rand = mt_rand(1,999999999);
		$rand_v2 = mt_rand(1,999999999);

		$hash = hash('sha256',$salt.$rand.$salt_v2.$rand_v2);

		return $hash;
	}

	/**
	 * Gera um Hash code de segurança
	 *
	 * @return string $hash
	 * @access protected 
	 */
	public function _generateUserHashCode() {

		$salt = Configure::read('Security.salt');
		$salt_v2 = Configure::read('Security.cipherSeed');
		$rand = mt_rand(1,999999999);
		$rand_v2 = mt_rand(1,999999999);

		$hash = hash('sha256',$salt.$rand.$salt_v2.$rand_v2);

		return $hash;
	}

/**
 * Função auxiliar para retornar uma lista com os usuários
 *
 * @return array $lista
 */
	public function listaUsuarios($show_id=false){

		$options = array(
			'conditions' => array('User.status' => 1),
			'recursive' => -1,
			'fields' => array('id', 'nome_completo'),
			'limit' => false,
			'callbacks' => true
		);

		$list = $this->find('list', $options);

		# Show ID
		if($show_id){
			foreach ($list as $id => $item) {
				
				$list[$id] = $item.' - #'.$id;
			}
		}

		return $list;
	}

/**
 * Função auxiliar alterar a Função do Usuário
 *
 * @return array $lista
 */
	public function _alteraFuncaoUsuario($user_id=null, $role_id=null){

		$this->id = $user_id;

		# Verifica se o usuário existe
		if (!$this->exists()) return false;

		# Altera Função do Usuário
		$this->saveField('role_id', $role_id);
	}

}
