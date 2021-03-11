<?php
App::uses('AppModel', 'Model');

class Pedido extends AppModel {

	public $belongsTo = array(
		'Contato' => array(
			'className' => 'Contato',
			'foreignKey' => 'contato_id',
			'fields'=>array('id', 'nome', 'fone1', 'status')
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'fields'=>array('id', 'role_id', 'nome', 'sbnome', 'email', 'cadastro_id', 'status')
		),
	);

	public $validate = array(
		'contrato_id' => array(
			'checked' => array(
				'rule' => array('checked'),
				'message' => 'Você deve ler e concordar com o "contrato de anúncio".',
				'allowEmpty' => false,
				'required' => false
			)
		),
	);

	public $actsAs = array('Auditable.Auditable');

	public function afterFind($results, $primary = true) {

	    foreach ($results as $key => $val) {

			# EMPRESA + ID
			if ( isset($val['Contato']['nome']) && isset($val['Pedido']['contato_id']) ) {

				$results[$key]['Pedido']['contato'] = null;

				if(!empty($val['Contato']['nome'])){

					$results[$key]['Pedido']['contato'] = $val['Contato']['nome'];

					if(!empty($val['Pedido']['contato_id'])){

						$results[$key]['Pedido']['contato'] .= ' - #'.$val['Pedido']['contato_id'];
					}
				}
				else{

					if(!empty($val['Pedido']['contato_id'])){

						$results[$key]['Pedido']['contato'] = $val['Pedido']['contato_id'];
					}
				}
			}

			# PEDIDO - Unserialize
			if ( isset($val['Pedido']['pedido']) ) {

				$results[$key]['Pedido']['pedido'] = unserialize($results[$key]['Pedido']['pedido']);
			}
		}

	    return $results;
	}

	public function pedido_ativo($contato_id=null){

		# Parâmetros
		$options = array(
			'conditions'=>array(
				'contato_id' => $contato_id,
				'status'=>1
			),
		);
		$pedido = $this->find('first', $options);

		return $pedido;
	}
}