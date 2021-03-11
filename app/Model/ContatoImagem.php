<?php
App::uses('AppModel', 'Model');

$url = Router::fullBaseUrl();

class ContatoImagem extends AppModel {

	public $useTable = 'contato_imagens';

	public $displayField = 'imagem';

	public $belongsTo = array(
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
		),
	);

	public $actsAs = array(
		'Auditable.Auditable'
	);

/**
 *	CALLBACKS
 *	==========================================
 */
	public function beforeSave($options = array()) {

		// codes

		return true;
	}

	public function beforeValidate($options = array()){

		// codes
		
		return true;
	}
}
