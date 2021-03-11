<?php 

App::uses('AppController', 'Controller');

class MensagensController extends AppController{

	public $components = array('Session', 'Recaptcha.Recaptcha');
		
	public function beforeFilter() {
	    parent::beforeFilter();

	    $this->Auth->allow('contato', 'mensagem');
	}

	public function contato() {

		if ($this->request->is(array('post', 'put'))) {

			if ($this->Recaptcha->verify()) {
				
				# Válida dados antes de enviar
				$this->Mensagen->set($this->data);
				if($this->Mensagen->validates()){

					# CakeEmail
					App::uses('CakeEmail', 'Network/Email');
					$email = new CakeEmail();
					$email->template('mensagem_contato', 'default')
						->config('default')
						->emailFormat('html')
						->subject(__('Mensagem de contato'))
						->to( Configure::read('Email.contact_to') )
						->from( Configure::read('Email.contact_from') )
						->viewVars($this->data);

					# Tenta enviar
					if($email->send()){

						$this->Session->setFlash('Mensagem enviada com sucesso, entraremos em contato!', 'layout/flash/flash_success');
						$this->redirect(array('controller'=>'mensagens', 'action' =>'contato'));
					}
					else{

						$this->Session->setFlash('Falha ao enviar sua mensagem, verifique o formulário!', 'layout/flash/flash_danger');
					}
				}
				else{

					$this->Session->setFlash('Falha ao enviar sua mensagem, verifique o formulário!', 'layout/flash/flash_danger');
				}
			}
			else {

				// $error = $this->Recaptcha->error;
				$this->Session->setFlash('Você esqueceu de marcar "Não sou um robô".', 'layout/flash/flash_danger');
			}

		}

		$this->_contatoSEO();
	}

	public function mensagem(){

		$this->set('referer', $this->referer());
	}


	

/*
==========================
FUNÇÕES SEO
==========================
*/
	protected function _contatoSEO($data=null){

		# variáveis para função:
		$meta_canonical = Router::url(array('controller'=>'mensagens', 'action'=>'contato'), true);

		// title
		$title = 'Contato';

		// description
		$meta_description = 'Dúvidas, sugestões ou reclamações? Entre em contato com a equipe do Aonde';

		$this->set('meta_robots', 'noodp');

		$this->set('title_for_layout', $title);
		$this->set('meta_canonical', $meta_canonical);

		$meta_default = array(
			'description'=>$meta_description,
			// 'keywords'=>$meta_keywords 
		);

		$meta_facebook = array(
			'og:title' 			=> $title,
			'og:site_name' 		=> 'Aonde',
			'og:url'			=> $meta_canonical,
			'og:description'	=> $meta_description,
			'og:type'			=> 'article',
			'og:locale'			=> 'pt_BR',
			'article:publisher'	=> 'https://www.facebook.com/aonde.info'
		);

		$meta_fb_business = array(
			'business:contact_data:street_address' 		=> 'Rua Aymorés, Qd. M Lt. 208 - Setor Oeste (ao Lado Do Sindicato Rural)',
			'business:contact_data:locality'		 	=> 'Cristalina',
			'business:contact_data:region' 		 		=> 'Goiás',
			'business:contact_data:country_name'		=> 'Brasil',
			'business:contact_data:postal_code'		 	=> '73850-000',
			'business:contact_data:email' 				=> 'contato@aonde.info',
			'business:contact_data:phone_number'		=> '(61) 3612-3484',
			'business:contact_data:website'			 	=> 'www.aonde.info'
		);

		$meta_twitter = array(
			'twitter:card' 			=> 'summary',
			'twitter:site'			=> '@aonde',
			'twitter:domain'		=> 'www.aonde.info',
			'twitter:url'			=> $meta_canonical,
			'twitter:title' 		=> $title,
			'twitter:description'	=> $meta_description,
			'twitter:creator'		=> 'Royal Branding'
		);

		$this->set(compact('meta_default', 'meta_facebook', 'meta_fb_business', 'meta_twitter'));
	}
	
}