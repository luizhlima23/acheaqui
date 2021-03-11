<?php
App::uses('AppController', 'Controller');

class PedidosController extends AppController {

	public $components = array(
		'Paginator',
		'FilterResults.Filter' => array(
			'auto' => array(
				'paginate' => false,
				'explode'  => true
			),
			'explode' => array(
				'character'   => ' ',
				'concatenate' => 'AND'
			)
		),
		'Tool',
		'RequestHandler'
	);

	public $helpers = array('Formata', 'CakePtbr.Formatacao', 'FilterResults.Search');

	public function beforeFilter() {
		parent::beforeFilter();

		# Status de Pedido
		$this->status_pedido = array(
			0=>'Desativado',
			1=>'Em aberto',
			2=>'Concluído'
		);
		$this->set('status_pedido', $this->status_pedido);

		# Pra ajudar nos detalhes do pedido
		$this->pacotes['Etiqueta'] = $this->pacotes['01'];
		$this->pacotes['BannerA'] = $this->pacotes['02'];
		$this->pacotes['BannerC'] = $this->pacotes['03'];
	}




/**
==========================
GESTOR
==========================
*/
	public function index(){

		# Options
		$options = array(
			'conditions'=>array(),
			'order'=>'Pedido.created DESC'
		);
		$this->paginate = $options;

		# Filtro
		Configure::load('filters');
		$this->Filter->addFilters(Configure::read('Pedido')); // Estáticos
		$this->Filter->addFilters(
			array(
				'f_status' => array(
					'Pedido.status' => array(
						'select' => $this->Filter->select('Todos', $this->status_pedido)
					)
				)
			)
		);

		# Mescla Conditions
		if($this->Filter->getConditions()){
			$options['conditions'] = array_merge($options['conditions'], $this->Filter->getConditions());		
			$this->Filter->setPaginate('conditions', $options['conditions']);
		}

		$this->Pedido->recursive = 0;
		$pedidos = $this->Paginator->paginate();

		$this->set('pedidos', $pedidos);
	}

	public function view($id=null){

		# Verifica se existe
		$this->Pedido->id = $id;
		if (!$this->Pedido->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		# parâmetros de consulta
		$options = array(
			'conditions'=>array(
				'Pedido.'.$this->Pedido->primaryKey => $id,
			)
		);
		$this->Pedido->recursive = 0;

		$pedido = $this->Pedido->find('first', $options);
		$this->set('data', $pedido);
		
		# Caso não encontre nenhum registro
		if(empty($pedido)){

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('action' => 'index'));
		}

		# Gera nova matriz de pedidos
		$servicos = array();
		$total = 0;
		foreach ($pedido['Pedido']['pedido'] as $k => $v) {

			$each = each($v[0]);
			$servicos[$each['key']] = $each['value'];

			$explode = explode('_', $each['value']['plano']);
			$servicos[$each['key']]['servico_id'] = $explode[0]; // ex.: 03		
			$servicos[$each['key']]['servico_nome'] = $this->pacotes[$explode[0]]['nome']; // Banner Premium
			$servicos[$each['key']]['plano_nome'] = $this->pacotes[$explode[0]]['Plano'][$each['value']['plano']]['nome']; // Plano Anual

			# Total
			$total += $each['value']['subtotal'];
		}
		$this->set(compact('servicos', 'total'));

		# Pacotes
		$this->set('pacotes', $this->pacotes);

		$contrato = $this->__contrato_anuncio($pedido['Pedido']['contato_id']);

		if(!empty($contrato)){

			$anexo = true;
		}
		else{

			$contrato = false;
			$anexo = false;
		}
		
		$this->set(compact('contrato', 'anexo'));
	}

	public function aprovar_pedido($id=null){

		$this->request->onlyAllow('post', 'aprovar_pedido');

		#Verifica se o pedido foi aprovado
		$this->Pedido->id = $id;
		if (!$this->Pedido->exists()) {
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'index'));
		}

		# Consulta pedido
		$options = array(
			'conditions'=>array(
				'Pedido.'.$this->Pedido->primaryKey => $id,
			)
		);
		$this->Pedido->recursive = 0;
		$pedido = $this->Pedido->find('first', $options);
		
		# Tenta aprovar o pedido, criando os serviços.
		if(!empty($pedido)){

			$contato_id = $pedido['Pedido']['contato_id'];
			$pedido_id = $pedido['Pedido']['id'];

			if($this->__ativar_anuncios_pedido($contato_id, $pedido_id, $pedido['Pedido']['pedido'])){

				$this->Session->setFlash($this->mmCrud['saved'], 'layout/flash/flash_success');
				$this->redirect($this->referer());
			}
			else{

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
				$this->redirect($this->referer());
			}

		}
		else{
			
			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('action' => 'index'));
		}
	}



/**
==========================
CLIENTE
==========================
*/
	public function user_index(){

		# Options
		$options = array(
			'conditions'=>array(
				'Pedido.user_id'=>$this->user_id
			),
			'order'=>'Pedido.created DESC'
		);
		$this->paginate = $options;

		$this->Pedido->recursive = 0;
		$pedidos = $this->Paginator->paginate();

		$this->set('pedidos', $pedidos);
	}

	public function user_view($id=null){

		# Verifica se existe
		$this->Pedido->id = $id;
		if (!$this->Pedido->exists()) {

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_warning');
			$this->redirect(array('action' => 'user_index'));
		}

		# parâmetros de consulta
		$options = array(
			'conditions'=>array(
				'Pedido.'.$this->Pedido->primaryKey => $id,
				'Pedido.user_id' => $this->user_id,
			)
		);
		$this->Pedido->recursive = 0;

		$pedido = $this->Pedido->find('first', $options);
		$this->set('data', $pedido);
		
		# Caso não encontre nenhum registro
		if(empty($pedido)){

			$this->Session->setFlash($this->mmCrud['invalid'], 'layout/flash/flash_danger');
			$this->redirect(array('action' => 'user_index'));
		}

		# Gera nova matriz de pedidos
		$servicos = array();
		$total = 0;
		foreach ($pedido['Pedido']['pedido'] as $k => $v) {

			$each = each($v[0]);
			$servicos[$each['key']] = $each['value'];

			$explode = explode('_', $each['value']['plano']);
			$servicos[$each['key']]['servico_id'] = $explode[0]; // ex.: 03		
			$servicos[$each['key']]['servico_nome'] = $this->pacotes[$explode[0]]['nome']; // Banner Premium
			$servicos[$each['key']]['plano_nome'] = $this->pacotes[$explode[0]]['Plano'][$each['value']['plano']]['nome']; // Plano Anual

			# Total
			$total += $each['value']['subtotal'];
		}
		$this->set(compact('servicos', 'total'));

		# Pacotes
		$this->set('pacotes', $this->pacotes);

		# Contrato e Anexos
		$contrato = $this->__contrato_anuncio($pedido['Pedido']['contato_id']);

		if(!empty($contrato)){

			$anexo = true;
		}
		else{

			$contrato = false;
			$anexo = false;
		}
		
		$this->set(compact('contrato', 'anexo'));
	}


	

/**
==========================
OUTROS
==========================
*/
	public function gerar_pedido(){

		# Dados do Formulário
		$pacote = (isset($this->params['named']['pac']))? $this->params['named']['pac'] : null;
		$contato_id = (isset($this->params['named']['cod']))? $this->params['named']['cod'] : null;
		if(isset($this->request->data['Pedido']['pacote'])) $pacote = $this->request->data['Pedido']['pacote'];
		if(isset($this->request->data['Pedido']['contato_id'])) $contato_id = $this->request->data['Pedido']['contato_id'];
		$this->request->data['Pedido']['pacote'] = $pacote;
		$this->request->data['Pedido']['contato_id'] = $contato_id;

		# VERIFICA DADOS
		if(empty($pacote)){

			$this->Session->setFlash('Selecione um plano de serviço', 'layout/flash/flash_info');
			$this->redirect(array('controller'=>'anuncios', 'action'=>'anunciar_empresa'));
		}

		if($this->Auth->loggedIn()){

			# SELECIONAR EMPRESA
			if(empty($contato_id)){

				# Consulta empresas do usuário
				if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');
				$minhas_empresas = $this->Contato->lista_empresas_user($this->user_id);
				$this->set('minhas_empresas', $minhas_empresas);

				# Se o usuário não tiver nenhuma empresa cadastrada, então redireciona.
				if(empty($minhas_empresas)){

					$this->Session->setFlash('Cadastre sua empresa para continuar.', 'layout/flash/flash_info');
					$this->redirect(array('controller'=>'contatos', 'action'=>'cadastrar_empresa', 'option'=>'completo'));
				}

				# Caso clique em Me cadastrar
				$loginRedirect = Router::url(
					array('controller'=>'pedidos', 'action'=>'gerar_pedido', 'pac'=>$pacote, 'plugin'=>false),
					true
				);
				$this->loginRedirect($loginRedirect, false);

				$this->render('gerar_pedido_empresa');

			}//Break
			else{

				# Verifica se já contem pedido
				if($this->Pedido->pedido_ativo($contato_id)){

					$this->Session->setFlash('Já existe um pedido em aberto. Verifique!', 'layout/flash/flash_info');
					$this->redirect(array('controller'=>'pedidos', 'action'=>'meus_pedidos'));
				}

				# Empresa Selecionada
				if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');
				$this->Contato->id = $contato_id;
				$contato_nome = $this->Contato->field('nome');
				$empresa_selecionada['Contato'] = array(
					'id'=>$contato_id,
					'nome'=>$contato_nome
				);
				$this->set('empresa_selecionada', $empresa_selecionada);

				# Gera pedido
				$pedido = $this->_gera_pedido($this->data['Pedido']['pacote'], $contato_id);
				$this->set('pedido', $pedido);
				$this->set('_pedido', serialize($pedido) );

				# Gera nova matriz de pedidos
				$servicos = array();
				foreach ($pedido as $k => $v) {
					
					$each = each($v[0]);
					$servicos[$each['key']] = $each['value'];

					$explode = explode('_', $each['value']['plano']);
					$servicos[$each['key']]['servico_id'] = $explode[0]; // ex.: 03		
					$servicos[$each['key']]['servico_nome'] = $this->pacotes[$explode[0]]['nome']; // Banner Premium
					$servicos[$each['key']]['plano_nome'] = $this->pacotes[$explode[0]]['Plano'][$each['value']['plano']]['nome']; // Plano Anual
				}
				$this->set('servicos', $servicos);

				# Pacotes
				$this->set('pacotes', $this->pacotes);

				# Contrato e Anexos
				$contrato = $this->__contrato_anuncio($contato_id);

				if(!empty($contrato)){

					$anexo = true;
				}
				else{

					$contrato = false;
					$anexo = false;
				}
				
				$this->set(compact('contrato', 'anexo'));
			}

		}
		else{

			$this->Session->setFlash($this->mmAuth['need_login'], 'layout/flash/flash_info');

			$loginRedirect = Router::url(array('controller'=>'pedidos', 'action'=>'gerar_pedido', 'pac'=>$pacote, 'cod'=>$contato_id, 'plugin'=>false), true);
			$this->loginRedirect($loginRedirect);
		}
	}

	public function salvar_pedido(){

		if($this->request->is(array('post', 'put'))){

			# Hash do Pedido
			if(!in_array('User', $this->uses)) $this->loadModel('User');
			$hash_pedido = $this->User->_generateUserHashCode();

			$this->request->data['Pedido']['hash_pedido'] = $hash_pedido;
			$this->request->data['Pedido']['user_id'] = $this->user_id;
		
			# Tenta Salver
			if($this->Pedido->save($this->data)){

				$this->Session->setFlash('Seu pedido foi salvo com sucesso, aguarde que entraremos em contato.', 'layout/flash/flash_info');

				# API DE PAGAMENTOS E REDIRECIONAMENTO
				//code

				$this->redirect(array('controller'=>'pedidos', 'action'=>'user_index'));

			}else{

				$this->Session->setFlash($this->mmCrud['not_saved'], 'layout/flash/flash_danger');
			}
		}

		$this->render(false);
	}

	/**
	 *	Verifica um código informado, utilizando a DAta e a Hora atual
	 *
	 * @param string $codigo
	 * @return boll true or false
	 **/
	protected function verifica_codigoTime($codigo=null){

		# Verificar código
		$hora = date('H');
		$dia = date('d');
		$mes = date('m');

		$codigo_verifica = 'A'.($hora+100).$dia.$mes;
		
		if($codigo == $codigo_verifica){

			return true;
		}

		return false;
	}

	/**
	 * Gera o contrato de anúncio de acordo o tipo de empresa
	 *
	 * @param int $contato_id, (opcional) array $data
	 * @return string $contrato
	 */
	protected function __contrato_anuncio(int $contato_id=null, array $data=null){

		$contrato = null;

		if(!empty($contato_id)){

			// Consulta empresa
			if(!in_array('Contato', $this->uses)) $this->loadModel('Contato');
			$this->Contato->recursive = 0;
			$empresa = $this->Contato->find('first', 
				array(
					'conditions'=>array('Contato.'.$this->Contato->primaryKey => $contato_id)
				)
			);

			$data = $empresa;
		}

		if(!empty($data) and is_array($data)){

			if(!in_array('PostDocumento', $this->uses)) $this->loadModel('PostDocumento');

			# Empresa informal ou Formal
			if ( empty($data['Contato']['razao_social']) or empty($data['Contato']['cpf_cnpj']) ) {

				// Informal = empresa sem CNPJ
				$user_nome = $this->Session->read('Auth.User.nome').' '.$this->Session->read('Auth.User.sbnome');
				$user_nome = mb_strtoupper($user_nome);
				
				if(!in_array('Cadastro', $this->uses)) $this->loadModel('Cadastro');
				$this->Cadastro->id = $this->user_cadastro_id;
				$user_cpf = $this->Cadastro->field('cpf');
				$user_cpf = $this->Tool->formatar('cpf', $user_cpf);

				$EMPRESA = mb_strtoupper($empresa['Contato']['nome']);
				// $ENDERECO = ucwords($empresa['Contato']['endereco']);

				$dados = array(
					'NOME'=>$user_nome,
					'CPF'=>$user_cpf,
					'EMPRESA'=>$EMPRESA,
					// 'ENDERECO'=>$ENDERECO,
				);

				$contrato_id = Configure::read('Documentos.contrato_informal');
				$contrato = $this->PostDocumento->conteudo($contrato_id);

				$contrato = $this->Tool->str_replaceAll($dados, $contrato);
			}
			else{

				// Formal = empresa com CNPJ
				$EMPRESA = mb_strtoupper($empresa['Contato']['razao_social']);
				$CNPJ = $this->Tool->formatar('cnpj', $empresa['Contato']['cpf_cnpj']);
				$ENDERECO = ucwords($empresa['Contato']['endereco']);

				$dados = array(
					'EMPRESA'=>$EMPRESA,
					'CNPJ'=>$CNPJ,
					// 'ENDERECO'=>$ENDERECO,
				);
				
				$contrato_id = Configure::read('Documentos.contrato');
				$contrato = $this->PostDocumento->conteudo($contrato_id);

				$contrato = $this->Tool->str_replaceAll($dados, $contrato);
			}
			$this->contrato_id = $contrato_id;

			# Se qualquer valor estiver em branco, então invalida o contrato
			foreach ($dados as $k => $v) {
				
				if(empty($v)){

					$contrato = false;
				}
			}
		}

		return $contrato;
	}

	/**
	 *	Ativa anúncios de uma empresa.
	 *
	 * @param int $contato_id, int $pedido_id, array $servicos
	 * @return bool true or false
	 **/
	public function __ativar_anuncios_pedido($contato_id=null, $pedido_id=null,  $pedido=null){

		$saved = false;
		foreach ($pedido as $servico_id => $data) {

			# Inseri os campos com os valores padrões
			foreach ($data as $key => $val) {
				
				$each = each($val);
				$model = $each['key'];
				$values = $each['value'];

				$data[$key][$model]['contato_id'] = $contato_id;
				$data[$key][$model]['status'] = 1;
			}

			# Cria os dados do pedido no BD
			switch ($servico_id) {
				case '01':
					$saved = $this->_saveEtiqueta($data[0]);
					break;
				
				case '02':
					$saved = $this->_saveBasico($data[0]);
					break;
				
				case '03':
					$saved = $this->_savePremium($data[0]);
					break;
				
				default:
					# code...
					break;
			}
		}

		if($saved){
			
			# Atualiza Pedido
			$this->Pedido->id = $pedido_id;
			$this->Pedido->saveField('hash_pedido', null);
			$this->Pedido->saveField('status', 2);

			return true;
		}
			
		return false;
	}

	protected function _saveEtiqueta($data=null){

		# Extrai variáveis
		extract($data['Etiqueta']);

		# Verifica Etiquetas
		if(!in_array('Etiqueta', $this->uses)) $this->loadModel('Etiqueta');
		$vigente = $this->Etiqueta->findByContatoId($contato_id);
		
		if(empty($vigente)){

			$this->Etiqueta->create();
			if( $this->Etiqueta->save($data, array('validates'=>false)) ){
				return true;
			}
		}
		else{

			$dataUpdate = $data;
			$dataUpdate['Etiqueta']['id']=$vigente['Etiqueta']['id'];
			$dataUpdate['Etiqueta']['status']=1;
			if( strtotime($inicio) >= $vigente['Etiqueta']['inicio']){
				unset($dataUpdate['Etiqueta']['inicio']);
			}
			if( $this->Etiqueta->save($dataUpdate, array('validates'=>false)) ){
				return true;
			}
		}

		return false;
	}

	protected function _saveBasico($data=null){

		# Extrai variáveis
		extract($data['BannerA']);

		# Verifica Etiquetas
		if(!in_array('BannerA', $this->uses)) $this->loadModel('BannerA');
		$vigente = $this->BannerA->findByContatoId($contato_id);
		
		if(empty($vigente)){

			$this->BannerA->create();
			if( $this->BannerA->save($data, array('validates'=>false)) ){
				return true;
			}
		}
		else{

			$dataUpdate = $data;
			$dataUpdate['BannerA']['id']=$vigente['BannerA']['id'];
			$dataUpdate['BannerA']['status']=1;
			if( strtotime($inicio) >= $vigente['BannerA']['inicio']){
				unset($dataUpdate['BannerA']['inicio']);
			}
			if( $this->BannerA->save($dataUpdate, array('validates'=>false)) ){
				return true;
			}
		}

		return false;
	}

	protected function _savePremium($data=null){

		# Extrai variáveis
		extract($data['BannerC']);

		# Verifica Etiquetas
		if(!in_array('BannerC', $this->uses)) $this->loadModel('BannerC');
		$vigente = $this->BannerC->findByContatoId($contato_id);
		
		if(empty($vigente)){

			$this->BannerC->create();
			if( $this->BannerC->save($data, array('validates'=>false)) ){
				return true;
			}
		}
		else{

			$dataUpdate = $data;
			$dataUpdate['BannerC']['id']=$vigente['BannerC']['id'];
			$dataUpdate['BannerC']['status']=1;
			if( strtotime($inicio) >= $vigente['BannerC']['inicio']){
				unset($dataUpdate['BannerC']['inicio']);
			}
			if( $this->BannerC->save($dataUpdate, array('validates'=>false)) ){
				return true;
			}
		}

		return false;
	}

	protected function _gera_pedido($anuncio=null, $contato_id=null){
		
		# Organiza variáveis
		$explode = explode('_', $anuncio);
		$plano = $anuncio;	// ex.: 03_anual
		$servico_id = $explode[0]; // ex.: 03		

		$total = 0;
		$hoje = date('Y-m-d');

		switch ($servico_id) {

			# pacote ETIQUETA
			case '01':
				$option = array(
					'contato_id'=>$contato_id,
					'servico_id'=>$servico_id,
					'plano'=>$plano,
					'inicio'=>$hoje
				);
				$pedido_etiqueta = $this->_pedidoEtiqueta($option);
				$pedido[$servico_id][] = $pedido_etiqueta;
				
				# Total
				$total += $pedido_etiqueta['Etiqueta']['subtotal'];
				break;

			# pacote BANNER BÁSICO
			case '02':
				$option = array(
					'contato_id'=>$contato_id,
					'servico_id'=>$servico_id,
					'plano'=>$plano,
					'inicio'=>$hoje
				);
				$pedido_banner_a = $this->_pedidoBannerA($option);
				$pedido[$servico_id][] = $pedido_banner_a;
				
				# Total
				$total += $pedido_banner_a['BannerA']['subtotal'];

				# gratuito - etiqueta
				$option['valor'] = 0;
				$option['subtotal'] = 0;
				unset($option['bonus']);
				$pedido['01'][] = $this->_pedidoEtiqueta($option);
				break;

			# pacote BANNER PREMIUM
			case '03':
				$option = array(
					'contato_id'=>$contato_id,
					'servico_id'=>$servico_id,
					'plano'=>$plano,
					'inicio'=>$hoje
				);
				$pedido_banner_c = $this->_pedidoBannerC($option);
				$pedido[$servico_id][] = $pedido_banner_c;
				
				# Total
				$total += $pedido_banner_c['BannerC']['subtotal'];

				# gratuito - etiqueta
				$option['valor'] = 0;
				$option['subtotal'] = 0;
				$pedido['01'][] = $this->_pedidoEtiqueta($option);

				# gratuito - banner básico
				$pedido['02'][] = $this->_pedidoBannerA($option);
				break;
			
			default:
				break;
		}

		# TOTAL
		$this->set('total', $total);

		return $pedido;
	}

	protected function _pedidoEtiqueta($option=null){

		if(is_null($option)) return false;

		extract($option); // contato_id, servico_id, plano, inicio

		# Variáveis
		if(!isset($inicio)) $inicio = date('Y-m-d');
		$vigencia_mes = $this->pacotes[$servico_id]['Plano'][$plano]['vigencia_mes']; // 12

		# Verifica se a empresa já possui um anuncio vigente
		if(!in_array('Etiqueta', $this->uses)) $this->loadModel('Etiqueta');
		$anuncio_vigente = $this->Etiqueta->planoVigente($contato_id);

			# Se existir anuncio vigente então configura o inicio do próximo
			if(!empty($anuncio_vigente['Etiqueta']['fim'])){

				$inicio = date('Y-m-d', strtotime($anuncio_vigente['Etiqueta']['fim'].' + 1 day'));
			}

		# Monta Pedido
		$pedido['inicio'] = $inicio;
		$pedido['fim'] =  date('Y-m-d', strtotime($inicio.' +'.$vigencia_mes.' month')); // fim+n (mêses)
		
		# Complementares
		$pedido['plano'] = $plano;
		$pedido['valor'] = (isset($valor))? $valor : $this->pacotes[$servico_id]['Plano'][$plano]['valor'];
		$pedido['subtotal'] = (isset($subtotal))? $subtotal : $vigencia_mes * $pedido['valor'];

		$return['Etiqueta'] = $pedido;

		return $return;
	}

	protected function _pedidoBannerA($option=null){

		if(is_null($option)) return false;

		extract($option); // contato_id, servico_id, plano, inicio

		# Variáveis
		if(!isset($inicio)) $inicio = date('Y-m-d');
		$vigencia_mes = $this->pacotes[$servico_id]['Plano'][$plano]['vigencia_mes']; // 12

		# Verifica se a empresa já possui um anuncio vigente
		if(!in_array('BannerA', $this->uses)) $this->loadModel('BannerA');
		$anuncio_vigente = $this->BannerA->planoVigente($contato_id);

			# Se existir anuncio vigente então configura o inicio do próximo
			if(!empty($anuncio_vigente['BannerA']['fim'])){

				$inicio = date('Y-m-d', strtotime($anuncio_vigente['BannerA']['fim'].' + 1 day'));
			}

		# Monta Pedido
		$pedido['inicio'] = $inicio;
		$pedido['fim'] =  date('Y-m-d', strtotime($inicio.' +'.$vigencia_mes.' month')); // fim+n (mêses)
		
		# Complementares
		$pedido['plano'] = $plano;
		$pedido['valor'] = (isset($valor))? $valor : $this->pacotes[$servico_id]['Plano'][$plano]['valor'];
		$pedido['subtotal'] = (isset($subtotal))? $subtotal : $vigencia_mes * $pedido['valor'];

		$return['BannerA'] = $pedido;

		return $return;
	}

	protected function _pedidoBannerC($option=null){

		if(is_null($option)) return false;

		extract($option); // contato_id, servico_id, plano, inicio

		# Variáveis
		if(!isset($inicio)) $inicio = date('Y-m-d');
		$vigencia_mes = $this->pacotes[$servico_id]['Plano'][$plano]['vigencia_mes']; // 12

		# Verifica se a empresa já possui um anuncio vigente
		if(!in_array('BannerC', $this->uses)) $this->loadModel('BannerC');
		$anuncio_vigente = $this->BannerC->planoVigente($contato_id);

			# Se existir anuncio vigente então configura o inicio do próximo
			if(!empty($anuncio_vigente['BannerC']['fim'])){

				$inicio = date('Y-m-d', strtotime($anuncio_vigente['BannerC']['fim'].' + 1 day'));
			}

		# Monta Pedido
		$pedido['inicio'] = $inicio;
		$pedido['fim'] =  date('Y-m-d', strtotime($inicio.' +'.$vigencia_mes.' month')); // fim+n (mêses)
		
		# Complementares
		$pedido['plano'] = $plano;
		$pedido['valor'] = (isset($valor))? $valor : $this->pacotes[$servico_id]['Plano'][$plano]['valor'];
		$pedido['subtotal'] = (isset($subtotal))? $subtotal : $vigencia_mes * $pedido['valor'];

		$return['BannerC'] = $pedido;

		return $return;
	}



}