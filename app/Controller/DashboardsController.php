<?php
App::uses('AppController', 'Controller');

class DashboardsController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();

		$this->set('title_for_layout', 'Painel de controle');
	}

	public function index(){

		# redireciona usuário
		switch ($this->role_id) {

			case ID_ROLE_SUPERADMIN:
				$this->redirect(array('controller'=>'dashboards', 'action'=>'superadmin_index'));
				break;

			case ID_ROLE_ADMIN:
				$this->redirect(array('controller'=>'dashboards', 'action'=>'admin_index'));
				break;
			
			case ID_ROLE_GESTOR_GERAL:
				$this->redirect(array('controller'=>'dashboards', 'action'=>'gestor_geral_index'));
				break;
			
			case ID_ROLE_GESTOR_CONTEUDO:
				$this->redirect(array('controller'=>'dashboards', 'action'=>'gestor_conteudo_index'));
				break;
			
			case ID_ROLE_GESTOR_FINANCEIRO:
				$this->redirect(array('controller'=>'dashboards', 'action'=>'gestor_financeiro_index'));
				break;
			
			case ID_ROLE_CLIENTE:
				$this->redirect(array('controller'=>'contatos', 'action'=>'minhas_empresas'));
				break;
			
			default:
				$this->redirect(array('controller'=>'users', 'action'=>'meusdados'));
				break;
		}
	}

	public function superadmin_index(){
		# code here
	}

	public function admin_index(){
		# code here
	}

	public function gestor_geral_index(){
		# code here
	}

	public function gestor_conteudo_index(){
		# code here
	}
	
	public function gestor_financeiro_index(){
		# code here
	}
}
