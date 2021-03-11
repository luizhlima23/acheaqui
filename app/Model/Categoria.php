<?php
App::uses('AppModel', 'Model');

class Categoria extends AppModel {
	
	public $displayField = 'nome';

	public $actsAs = array('Tree', 'Auditable.Auditable');
	
}
