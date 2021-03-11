<?php

	$config = array(
		
		# Informações do aplicativo
		'Application' => array(
			'name' 	  => 'Aonde',
			'version' => '1.0',
			'since'   => '2015',
			'author'  => 'Royal Branding',
			'status'  => 1,
			'maintenance' => 0,
		),
	
		# Termos de uso
		'Documentos' => array(
			'termos_de_uso' => 1,
			'politica_privacidade' => 2,
			'contrato' => 3,
			'contrato_informal' => 4,
		),
		
		# Conexão de email
		'Email' => array(
			'contact_from' => array('contato@royalbranding.com.br' => 'Contato - Royal Branding'), // De quem
			'contact_to' => array('andersoncorso89@gmail.com' => 'Anderson Corso'), // Para quem enviar
			'contact_cc' => array('copia@url.com' => 'Fulano copia') // Cópia
		),

		# AUTH configs
		'Auth' => array(
			'session_fields'=>array(
				'id', 'email', 'nome', 'sbnome', 'role_id', 'admin', 'url_img', 'cadastro_id',
				'Cadastro.data_nascimento',
				'Role.id', 'Role.name', 'Role.ordem', 'Role.admin_menu'
			)
		),

		# VARIÁVEIS GLOBAIS DE FUNÇÕES
		'Global.roles' => array(
			'ID_ROLE_SUPERADMIN'=>1,
			'ID_ROLE_ADMIN'=>2,
			'ID_ROLE_GESTOR_GERAL'=>3,
			'ID_ROLE_GESTOR_CONTEUDO'=>4,
			'ID_ROLE_CLIENTE'=>5,
			'ID_ROLE_USUARIO'=>6,
			'ID_ROLE_GESTOR_FINANCEIRO'=>7,
		),

		# Menu de Admin
		'Role.menu'=> array(
			'A'=>array( // Super admin
				'left'=>array(
					0=>array(
						'titulo'=>'Acesso ao sistema',
						'links'=>array(
							0=>array('Usuários'=>array('controller'=>'users', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Funções'=>array('controller'=>'roles', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							10=>array('divider'),
							11=>array('Permissões ACL'=>array('controller'=>'acl', 'action'=>'permissions', 'plugin'=>'acl_manager', 'admin'=>false)),
						),
					),
					1=>array('Empresas'=>array('controller'=>'contatos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
					2=>array(
						'titulo'=>'Anúncios',
						'links'=>array(
							0=>array('Etiquetas'=>array('controller'=>'etiquetas', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Banners'=>array('controller'=>'banners', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							10=>array('divider'),
							11=>array('Pedidos'=>array('controller'=>'pedidos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					3=>array(
						'titulo'=>'Atualizações',
						'links'=>array(
							0=>array('Empresas'=>array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					4=>array(
						'titulo'=>'Facebook',
						'links'=>array(
							0=>array('Incorporações'=>array('controller'=>'incorporations', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
				'right'=>array(
					0=>array(
						'titulo'=>'Biblioteca',
						'links'=>array(
							0=>array('Bairros'=>array('controller'=>'bairros', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Logradouros'=>array('controller'=>'logradouros', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							2=>array('Tags'=>array('controller'=>'tags', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							10=>array('divider'),
							11=>array('Documentos'=>array('controller'=>'posts', 'action'=>'documento_index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					1=>array(
						'titulo'=>'Auditoria',
						'links'=>array(
							0=>array('Logs de alterações'=>array('controller'=>'loggers', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Logs de acessos'=>array('controller'=>'log_acessos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							2=>array('Logs de pesquisas'=>array('controller'=>'log_pesquisas', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
			),
			'B'=>array( // Admin
				'left'=>array(
					0=>array(
						'titulo'=>'Acesso ao sistema',
						'links'=>array(
							0=>array('Usuários'=>array('controller'=>'users', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Funções'=>array('controller'=>'roles', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					1=>array('Empresas'=>array('controller'=>'contatos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
					2=>array(
						'titulo'=>'Anúncios',
						'links'=>array(
							0=>array('Etiquetas'=>array('controller'=>'etiquetas', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Banners'=>array('controller'=>'banners', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							10=>array('divider'),
							11=>array('Pedidos'=>array('controller'=>'pedidos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					3=>array(
						'titulo'=>'Atualizações',
						'links'=>array(
							0=>array('Empresas'=>array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					4=>array(
						'titulo'=>'Facebook',
						'links'=>array(
							0=>array('Incorporações'=>array('controller'=>'incorporations', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
				'right'=>array(
					0=>array(
						'titulo'=>'Biblioteca',
						'links'=>array(
							0=>array('Bairros'=>array('controller'=>'bairros', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Logradouros'=>array('controller'=>'logradouros', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							2=>array('Tags'=>array('controller'=>'tags', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							10=>array('divider'),
							11=>array('Documentos'=>array('controller'=>'posts', 'action'=>'documento_index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					1=>array(
						'titulo'=>'Auditoria',
						'links'=>array(
							0=>array('Logs de alterações'=>array('controller'=>'loggers', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Logs de acessos'=>array('controller'=>'log_acessos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							2=>array('Logs de pesquisas'=>array('controller'=>'log_pesquisas', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
			),
			'C'=>array( // Gestor Geral
				'left'=>array(
					0=>array(
						'titulo'=>'Acesso ao sistema',
						'links'=>array(
							0=>array('Usuários'=>array('controller'=>'users', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Funções'=>array('controller'=>'roles', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					1=>array('Empresas'=>array('controller'=>'contatos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
					2=>array(
						'titulo'=>'Anúncios',
						'links'=>array(
							0=>array('Etiquetas'=>array('controller'=>'etiquetas', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Banners'=>array('controller'=>'banners', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							10=>array('divider'),
							11=>array('Pedidos'=>array('controller'=>'pedidos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					3=>array(
						'titulo'=>'Atualizações',
						'links'=>array(
							0=>array('Empresas'=>array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
				'right'=>array(
					0=>array(
						'titulo'=>'Biblioteca',
						'links'=>array(
							0=>array('Bairros'=>array('controller'=>'bairros', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Logradouros'=>array('controller'=>'logradouros', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							2=>array('Tags'=>array('controller'=>'tags', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
			),
			'D'=>array( // Gestor de conteúdo
				'left'=>array(
					0=>array(
						'titulo'=>'Acesso ao sistema',
						'links'=>array(
							0=>array('Usuários'=>array('controller'=>'users', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Funções'=>array('controller'=>'roles', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					1=>array('Empresas'=>array('controller'=>'contatos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
					2=>array(
						'titulo'=>'Anúncios',
						'links'=>array(
							0=>array('Etiquetas'=>array('controller'=>'etiquetas', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Banners'=>array('controller'=>'banners', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					3=>array(
						'titulo'=>'Atualizações',
						'links'=>array(
							0=>array('Empresas'=>array('controller'=>'correcoes', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
				'right'=>array(
					0=>array(
						'titulo'=>'Biblioteca',
						'links'=>array(
							0=>array('Bairros'=>array('controller'=>'bairros', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Logradouros'=>array('controller'=>'logradouros', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							2=>array('Tags'=>array('controller'=>'tags', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
			),
			'E'=>array( // Gestor financeiro
				'left'=>array(
					0=>array(
						'titulo'=>'Acesso ao sistema',
						'links'=>array(
							0=>array('Usuários'=>array('controller'=>'users', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
					1=>array('Empresas'=>array('controller'=>'contatos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
					2=>array(
						'titulo'=>'Anúncios',
						'links'=>array(
							0=>array('Etiquetas'=>array('controller'=>'etiquetas', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							1=>array('Banners'=>array('controller'=>'banners', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
							10=>array('divider'),
							11=>array('Pedidos'=>array('controller'=>'pedidos', 'action'=>'index', 'plugin'=>false, 'admin'=>false)),
						),
					),
				),
			),
		),

		# Options
		'Option.status' => array(1=>__('Ativado'), 0=>__('Desativado')),
		'Option.status_2' => array(1=>__('Sim'), 0=>__('Não')),
		'Option.correcao' => array(1=>__('Aprovar'), 0=>__('Reprovar'), 2=>__('Alterar e Aprovar')),
		'Option.pessoa' => array('Física'=>__('Física'), 'Jurídica'=>__('Jurídica')),
		'Option.correcao' => array( 'A'=>__('Aprovar'), 'R'=>__('Reprovar'), 'AC'=>__('Aprovar com alterações') ),

		# PACOTES de Anúncio
		'Servico.01'=> array(
			'nome'=>'Pacote de Etiquetas',
			'disponivel'=>1,
			'status'=>1,
			'Plano'=>array(
				'01_anual'=>array(
					'vigencia_mes'=>12,
					'nome'=>'Plano Anual',
					'descricao'=>'a partir de 9,90/mês',
					'valor'=>9.90,
					'status'=>1
				),
			),
		),
		'Servico.02'=> array(
			'nome'=>'Banner Básico',
			'disponivel'=>1,
			'status'=>1,
			'Plano'=>array(
				'02_trimestral'=>array(
					'vigencia_mes'=>3,
					'nome'=>'Plano Trimestral',
					'descricao'=>'a partir de 49,90/mês',
					'valor'=>49.90,
					'status'=>1
				),
				'02_semestral'=>array(
					'vigencia_mes'=>6,
					'nome'=>'Plano Semestral',
					'descricao'=>'a partir de 39,90/mês',
					'valor'=>39.90,
					'status'=>1
				),
				'02_anual'=>array(
					'vigencia_mes'=>12,
					'nome'=>'Plano Anual',
					'descricao'=>'a partir de 29,90/mês',
					'valor'=>29.90,
					'status'=>1
				),
			),
		),
		'Servico.03'=> array(
			'nome'=>'Banner Premium',
			'disponivel'=>12,
			'status'=>1,
			'Plano'=>array(
				'03_mensal'=>array(
					'vigencia_mes'=>1,
					'nome'=>'Plano Mensal (Experimental)',
					'descricao'=>'a partir de 399,90/mês',
					'valor'=>399.90,
					'status'=>1
				),
				'03_trimestral'=>array(
					'vigencia_mes'=>3,
					'nome'=>'Plano Trimestral',
					'descricao'=>'a partir de 319,90/mês',
					'valor'=>319.90,
					'status'=>0
				),
				'03_semestral'=>array(
					'vigencia_mes'=>6,
					'nome'=>'Plano Semestral',
					'descricao'=>'a partir de 309,90/mês',
					'valor'=>309.90,
					'status'=>0
				),
				'03_anual'=>array(
					'vigencia_mes'=>12,
					'nome'=>'Plano Anual',
					'descricao'=>'a partir de 299,90/mês',
					'valor'=>299.90,
					'status'=>1
				),
			),
		),
		'Servico.04'=> array(
			'nome'=>'Banner Rotativo',
			'disponivel'=>0,
			'status'=>0,
			'Plano'=>array(
				'04_trimestral'=>array(
					'vigencia_mes'=>3,
					'nome'=>'Plano Trimestral',
					'descricao'=>'a partir de 109,90/mês',
					'valor'=>109.90,
					'status'=>0
				),
				'04_semestral'=>array(
					'vigencia_mes'=>6,
					'nome'=>'Plano Semestral',
					'descricao'=>'a partir de 99,90/mês',
					'valor'=>99.90,
					'status'=>0
				),
				'04_anual'=>array(
					'vigencia_mes'=>12,
					'nome'=>'Plano Anual',
					'descricao'=>'a partir de 89,90/mês',
					'valor'=>89.90,
					'status'=>0
				),
			),
		),

		# Twitter
		'Twitter'=>array(
			'via'=>'aonde', //(Criar conta do aonde)
		),
	);

?>