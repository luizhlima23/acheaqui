<?php
App::uses('AppModel', 'Model');

class Incorporation extends AppModel {

	public $useTable = 'fb_incorporations';

	public $displayField = 'incorporation';

	public $actsAs = array(
		'Auditable.Auditable'
	);

	public $validate = array(
		'description' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 2, 100),
				'message' => 'O nome deve conter entre 2 e 100 caracteres.',
			)
		),
		'incorporation' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo corretamente.',
				'allowEmpty' => false,
				'required' => false,
			),
		),
	);

}
