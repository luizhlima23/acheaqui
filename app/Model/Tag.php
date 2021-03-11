<?php
App::uses('AppModel', 'Model');

class Tag extends AppModel {

	public $useTable = 'tags';

	public $displayField = 'tag';

	public $validate = array();

	public $belongsTo = array(
		'Etiqueta' => array(
			'className' => 'Etiqueta',
			'foreignKey' => 'etiqueta_id',
			'order' => ''
		),
	);
	
	public $actsAs = array('Auditable.Auditable');

/**
 *	CALLBACKS
 *	==========================================
 */
	public function beforeSave($options = array()) {

		if (!empty($this->data['Tag']['tag'])) {
			
			$this->data['Tag']['tag'] = $this->_tagBeforeSave($this->data['Tag']['tag']);
		}

		return true;
	}



/**
 *	OUTROS METODOS
 *	==========================================
 */

	/**
	 * Atualiza tabela de tags com dados de Etiqueta
	 *
	 * @param string $tags
	 */
	public function _updateTagsToEtiqueta($Etiqueta=null) {

		if(empty($Etiqueta)) return false;

		extract($Etiqueta);

		if(!empty($tags) and !empty($id)){

			# Exclui todas tags desse id de etiqueta
			$this->_deleteAllTagsToEtiqueta($id);

			# trata e converte em array
			if(!is_array($tags)){

				$tags = trim($tags, '|');
				$tags = explode('|', $tags);
				$tags = array_filter($tags);
			}

			foreach ($tags as $key=>$tag) {
				
				if( !$this->_update_tag($tag, $id) ) return false;
			}
		}

		return true;
	}

	/**
	 * Pesquisa e atualiza uma "tag"
	 *
	 * @param string $tag
	 */
	protected function _update_tag($tag=null, $etiqueta_id=null){

		# Verifica se já existe
		$options = array(
			'conditions'=>array(
				'Tag.etiqueta_id'=>$etiqueta_id,
				'Tag.tag LIKE'=>$tag
			),
		);
		$first = $this->find('first', $options);

		if(empty($first)){

			$Tag['Tag']['etiqueta_id'] = $etiqueta_id;
			$Tag['Tag']['tag'] = $tag;
			$Tag['Tag']['status'] = 1;

			$this->create();
			if( $this->saveAll($Tag) ) return true;
			$this->clear();
		}
		else{

			$Tag['Tag']['id'] = $first['Tag']['id'];
			$Tag['Tag']['etiqueta_id'] = $etiqueta_id;
			$Tag['Tag']['tag'] = $tag;

			if( $this->saveAll($Tag) ) return true;
			$this->clear();
		}

		return false;
	}

	/**
	 * Excluir todas tags de uma etiqueta
	 *
	 * @param int $etiqueta_id
	 */
	protected function _deleteAllTagsToEtiqueta($etiqueta_id=null) {

		if(empty($etiqueta_id)) return false;

		# Tenta excluir
		$this->deleteAll(array('Tag.etiqueta_id'=>$etiqueta_id), false);

		return false;
	}

	/**
	 * Formata tag 
	 *
	 * @param string $tag
	 * @return string $tag
	 */
	protected function _tagBeforeSave($tag=null) {
		
		$tag = mb_strtolower($tag);

		return $tag;
	}

}