<?php

class TagShell extends AppShell {

	public $uses = array('Tag', 'Etiqueta');

	public function main() {
		$this->out('TagShell');
	}

	public function update() {

		# Consulta Etiquetas
		$options = array(
			'conditions' => array(
				'Etiqueta.tags !=' => null,
				'Etiqueta.status' => true,
				'Etiqueta.inicio <= CURDATE()',
				'Etiqueta.fim >= CURDATE()',
			),
			'order'=>array('Etiqueta.modified DESC'),
		);
		$etiquetas = $this->Etiqueta->find('list', $options);

		# Separa e trata as tags
		$tags = array();
		foreach ($etiquetas as $k=>$val) {
			
			$array = explode('|', $val);		// Separa tags
			$array = array_filter($array);		// Elimina empty values
			$array = array_unique($array);		// Remove o valores duplicados de um array

			$tags = array_merge($tags, $array); // Junta os array 
		}

		# TRUNCATE TABLE tags
		$this->Tag->query('TRUNCATE TABLE tags;');

		# Gera array para BD
		foreach ($tags as $key=>$tag) {
			
			$Tag['Tag'] = array();
			$Tag['Tag']['tag'] = $tag;  
			$Tag['Tag']['status'] = 1;

			if( $this->Tag->saveAll($Tag, array('validates'=>false)) ){
				// return true;
			}
			else{
				// return false;
			}
		}

		// $count = $this->Tag->getAffectedRows();
		// $this->out('Registros atualizados: '.$count);
		$this->out('Atualização concluida!');
	}
}