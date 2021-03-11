<?php 

App::uses('Model', 'AppModel');

class Mensagen extends AppModel{

	public $useTable = false;

	public $validate = array(
		'nome' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Preencha este campo com seu Nome.',
				'allowEmpty' => false,
				'required' => true,
			),
		),
		'mensagem' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Digite sua mensagem aqui.',
				'allowEmpty' => false,
				'required' => true,
			),
			'lengthBetween' => array(
				'rule' => array('lengthBetween', 15, 1024),
				'message' => 'Número de caracteres, mínimo: 15, máximo: 1024.',
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Informe um e-mail válido',
				'allowEmpty' => false,
				'required' => true
			),
		),
	);
	
}
?>