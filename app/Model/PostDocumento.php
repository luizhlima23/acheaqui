<?php
App::uses('AppModel', 'Model');

class PostDocumento extends AppModel {

	public $useTable = 'post_documentos';

	public $displayField = 'titulo';

	public $actsAs = array(
		'Auditable.Auditable'
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
				'message' => 'O nome deve conter entre 2 e 50 caracteres.',
			)
		),
	);





/**
 *	CALLBACKS
 *	==========================================
 */
	public function beforeSave($options = array()) {

		# PostDocumento.slug_nome
		if (!empty($this->data['PostDocumento']['nome'])) {
			
			$this->data['PostDocumento']['slug_nome'] = mb_strtolower(Inflector::slug($this->data['PostDocumento']['nome']));
		}
	}




/**
 *	OUTROS 
 *	==========================================
 */
	public function conteudo($id=null){

		$this->id = $id;
		$data = $this->field('conteudo');

		return $data;
	}
}
