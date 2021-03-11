<?php
App::uses('AppModel', 'Model');

$url = Router::fullBaseUrl();

class BannerC extends AppModel {

	public $useTable = 'banners_c';

	public $displayField = 'imagem';

	public $belongsTo = array(
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
		),
	);

	public function __construct() {
		parent::__construct();

		# Hash para upload
		Interpolation::add('hash', function($info){
			return sha1($info->getFilename() . Configure::read('Security.salt'));
		});

		return true;
	}

	# https://github.com/rickydunlop/Uploader/tree/master
	public $actsAs = array(
		'CakePtbr.AjusteData' => array('inicio', 'fim'),
		'Uploader.Upload' => array(
			'imagem' => array(
				'styles' => array(
					'original' => '750x150'
				),
				'path' => ':webroot/uploads/banners/premium/:id_:style-:hash.:extension', // Url onde serão salvos os uploads
				'url' => ':webroot/uploads/banners/premium/:id_:style-:hash.:extension', // Url de display do Helper
				'default_url' => ':webroot/uploads', // Em caso de falha no upload
				'resizeToMaxWidth' => true, // Reduz automatico quando > que maxWidth da Val.
				'quality' => 95, // Qualidade do Jpeg (default:90)
			)
		),
		'Auditable.Auditable'
	);

	public $validate = array(
		'imagem' => array(
			'attachmentPresence' => array(
				'rule' => array('attachmentPresence'),
				'message' => 'Escolha uma imagem para o Banner.',
			),
			'filesize' => array(
				'rule' => array('filesize', array('min' => '1KB', 'max' => '1MB')),
				'message' => 'Tamanho da imagem excede o limite permitido de 1MB.'
			),
			'contentType' => array(
				'rule' => array('contentType', array(
					'image/jpg', 'image/jpeg', 'image/png',
				)),
				'message' => 'Tipo de imagem não permitido.'
			),
			// 'exactWidth' => array(
			// 	'rule' => array('exactWidth', '100'),
			// 	'message' => 'A imagem deve ter exatamente 100 pixels de largura'
			// ),
			// 'exactHeight' => array(
			// 	'rule' => array('exactHeight', '100'),
			// 	'message' => 'A imagem deve ter exatamente 100 pixels de altura'
			// ),
			'minWidth' => array(
				'rule' => array('minWidth', '750'),
				'message' => 'A imagem deve ter no mínimo 750 pixels de largura'
			),
			'maxWidth' => array(
				'rule' => array('maxWidth', '750'),
				'message' => 'A imagem não pode ter mais de 750 pixels de largura'
			),
			'minHeight' => array(
				'rule' => array('minHeight', '150'),
				'message' => 'A imagem deve ter no mínimo 150 pixels de altura'
			),
			// 'maxHeight' => array(
			// 	'rule' => array('maxHeight', '500'),
			// 	'message' => 'A imagem não pode ter mais de 500 pixels de altura'
			// )
		),
		'url_redirect' => array(
			'rule' => array('url', true),
			'message' => 'Link inválido.',
			'allowEmpty' => true,
			'required' => false,
		),
	);

	public $virtualFields = array(
		'vigente' => 'IF( BannerC.status=1 AND BannerC.inicio <= CURDATE() AND BannerC.fim >= CURDATE(), 1, 0 )'
	);



/**
 *	CALLBACKS
 *	==========================================
 */
	public function beforeSave($options = array()) {

		# Url_redirect (verifica http)
		if(isset($this->data['BannerC']['url_redirect'])){

			$this->data['BannerC']['url_redirect'] = $this->urlFormatBeforeSave($this->data['BannerC']['url_redirect']);
		}

		return true;
	}

	public function beforeValidate($options = array()){

		# Url_redirect (verifica http)
		if(isset($this->data['BannerC']['url_redirect'])){

			$this->data['BannerC']['url_redirect'] = $this->urlFormatBeforeSave($this->data['BannerC']['url_redirect']);
		}
		
		return true;
	}




/**
 *	OUTROS METODsOS 
 *	==========================================
 */

	/**
	 * Retorna os banners premium ativos
	 *
	 * @param int $limit
	 * @return array $banner_premium
	 */
	public function lista($limit=false){

		$options = array(
			'conditions' => array(
				'imagem !=' => null,
				'status' => true,
				'inicio <= CURDATE()',
				'fim >= CURDATE()',
			),
			'fields'=>array(
				'id', 'contato_id', 'imagem', 'url_redirect', 'url_target', 'tags', 'status'
			),
			'limit'=>$limit
		);

		return $this->find('all', $options);
	}

	/** 
	 * Consulta o plano vigente atual
	 *
	 * @param int $contato_id
	 * @return array $first;
	 */
	public function planoVigente($contato_id=null){

		# Parametros
		$options = array(
			'conditions'=>array(
				'BannerC.status' => true,
				'BannerC.inicio <= CURDATE()',
				'BannerC.fim >= CURDATE()',
				'BannerC.contato_id'=>$contato_id
			),
			'order'=>array('BannerC.modified DESC'),
		);

		# Consulta
		return $this->find('first', $options);
	}
}
