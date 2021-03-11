<?php
App::uses('AppModel', 'Model');

class Etiqueta extends AppModel {

	public $displayField = 'tags';

	public $belongsTo = array(
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
		),
	);

	public $actsAs = array('CakePtbr.AjusteData' => array('inicio', 'fim'), 'Auditable.Auditable');

	public $virtualFields = array(
		'vigente' => 'IF( Etiqueta.status=1 AND Etiqueta.inicio <= CURDATE() AND Etiqueta.fim >= CURDATE(), 1, 0 )'
	);

	public function beforeSave($options = array()) {

		if (!empty($this->data['Etiqueta']['tags'])) {
			$this->data['Etiqueta']['tags'] = $this->tagsBeforeSave($this->data['Etiqueta']['tags']);
		}

		return true;
	}

	public function afterSave($created, $options=array()){

		if(isset($this->data['Etiqueta']['tags'])){

			# Atualiza tabela de tags
			if(!empty($this->data['Etiqueta']['id']) and !empty($this->data['Etiqueta']['tags'])){
				
				$Tag = ClassRegistry::init('Tag');
				$Tag->_updateTagsToEtiqueta($this->data['Etiqueta']);
			}
		}
	}

	public function afterFind($results, $primary = true) {

		foreach ($results as $key => $val) {

			if (isset($val['Etiqueta']['tags'])) {

				//$results[$key]['Etiqueta']['tags'] = $this->tagsFormatAfterFind($val['Etiqueta']['tags']);
				$results[$key]['Etiqueta']['tags'] = $this->tagsOrderAfterFind($val['Etiqueta']['tags']);

				if(isset($val['Etiqueta']['inpBusca'])) {

					# Tags relacionadas
					$results[$key]['Etiqueta']['tags_rel'] = $this->tags_relacionadas($val['Etiqueta']['inpBusca'], $results[$key]['Etiqueta']['tags']);
				}
			}
		}

		return $results;
	}

	/**
	 * Retorna as tags relacionadas a uma determinada palavra
	 *
	 * @param string $needle, string $tags
	 * @return string $tags_rel
	 */
	public function tags_relacionadas($needle=null, $haystack=null) {

		# verifica parâmetros
		if( is_null($needle) or is_null($haystack) ) return null;

		# Array de tags
		$tags = explode('|', $haystack);
		$tags = array_filter($tags);

		# remove acentos
		$needle = $this->stringFilter($needle);

		$tags_relacionadas = array();

		foreach ($tags as $tag) {

			# remove acentos
			$item = $this->stringFilter($tag);

			if (strpos($item, $needle) !== FALSE) {

				$tags_relacionadas[] = $tag;
			}
		}

		# transforma no formato padrão de tags
		$tags_relacionadas = '|'.implode('|', $tags_relacionadas).'|';

		return $tags_relacionadas;
	}

	/**
	 * Ordena array de Tags 
	 *
	 * @param string $tags
	 */
	public function tagsOrderAfterFind($tags=null) {
		
		$tags = trim($tags, '|');
		$tags = explode('|', $tags);

		natcasesort($tags); // Ordem alfabética

		$tags = '|'.implode('|', $tags).'|';

		return mb_strtolower($tags);
	}

	/**
	 * Formata tags para serem exibidas nos formulários
	 *
	 * @param string $tags
	 */
	public function tagsFormatAfterFind($tags=null) {
		
		$tags = trim($tags, '|');
		$tags = str_replace('|', ',', $tags);

		return $tags;
	}

	/**
	 * Verifica e corrige as tags para o formato correto de BD
	 *
	 * @param string $tags
	 */
	public function tagsBeforeSave($tags=null) {
		
		$split_tags = explode(',', $tags);
		$implode = '|'.implode('|', $split_tags).'|';

		return $implode;
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
				'Etiqueta.status' => true,
				'Etiqueta.inicio <= CURDATE()',
				'Etiqueta.fim >= CURDATE()',
				'Etiqueta.contato_id'=>$contato_id
			),
			'order'=>array('Etiqueta.modified DESC'),
		);

		# Consulta
		return $this->find('first', $options);
	}
}
