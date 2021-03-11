<?php
	
	# Home
	Router::connect('/', array('controller' => 'contatos', 'action' => 'home'));
	
	# Termos de uso
	Router::connect('/termos-de-uso', array('controller'=>'posts', 'action'=>'termos_de_uso'));
	
	# Contato
	Router::connect('/contato', array('controller'=>'mensagens', 'action'=>'contato'));
	
	// temp
	Router::connect('/sorteio', array('controller'=>'contatos', 'action'=>'sorteio'));



/**
==========================
BUSCA PRINCIPAL
==========================
*/
	Router::connect('/cristalina-go/pesquisa/*', array('controller' => 'contatos', 'action' => 'pesquisa'));
	
	# Perfil da Empresa
	Router::connect('/empresa/:var',
		array('controller' => 'contatos', 'action' => 'empresa'),
		array(
			'pass' => array('var'),
			'var' => '[a-z0-9-]+', 
		)
	);

	# Perfil da Empresa
	Router::connect('/:cidade/:slug-:id',
		array('controller' => 'contatos', 'action' => 'detalhes'),
		array(
			'pass' => array('cidade', 'slug', 'id'),
			'cidade' => '[a-z-]+', // Letras e hífen
			'slug' => '[a-z0-9-]+', // Letras, números e hífen
			'id' => '[0-9]+', // Números
		)
	);

	# Gerenciar empresa
	Router::connect('/gerenciar-empresa/:contato_id',
		array('controller' => 'contatos', 'action' => 'gerenciar_empresa'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);

	# Editor visual
	Router::connect('/gerenciar-empresa/editor-visual/:contato_id',
		array('controller' => 'contatos', 'action' => 'empresa_editor_visual'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);



/**
==========================
ACESSOS
==========================
*/
	Router::connect('/login/*', array('controller'=>'users', 'action'=>'login'));

	Router::connect('/painel/inicio', array('controller'=>'dashboards', 'action'=>'index'));
	Router::connect('/painel/admin/inicio', array('controller'=>'dashboards', 'action'=>'admin_index'));



/**
==========================
CONTA DO USUÁRIO
==========================
*/
	Router::connect('/conta/meusdados', array('controller'=>'users', 'action'=>'meusdados'));
	Router::connect('/conta/solicitar-senha', array('controller'=>'users', 'action'=>'remember_password'));
	Router::connect('/conta/nova-senha/*', array('controller'=>'users', 'action'=>'change_password'));



/**
==========================
CADASTRO E DIVULGAÇÃO
==========================
*/
	# Anunciar Empresa
	Router::connect('/anunciar', array('controller'=>'anuncios', 'action'=>'anunciar_empresa'));

	# Cadastrar Empresa
	Router::connect('/cadastrar-empresa', array('controller'=>'contatos', 'action'=>'cadastrar_empresa'));
	Router::connect('/cadastrar-empresa/:option',
		array('controller' => 'contatos', 'action' => 'cadastrar_empresa'),
		array(
			'pass' => array('option'),
			'option' => '[a-z]+', // Letras
		)
	);

	# Reivindicar Empresa
	Router::connect('/reivindicar-empresa/:id',
		array('controller' => 'contatos', 'action' => 'reivindicar_empresa'),
		array(
			'pass' => array('id'),
			'id' => '[0-9]+', // Números
		)
	);

	# Desistir de Empresa
	Router::connect('/desistir-empresa/:id',
		array('controller' => 'contatos', 'action' => 'desistir_empresa'),
		array(
			'pass' => array('id'),
			'id' => '[0-9]+', // Números
		)
	);



/**
==========================
PRODUTOS E SERVIÇOS
==========================
*/
	# Editar Etiquetas
	Router::connect('/editar/etiquetas/:contato_id',
		array('controller' => 'etiquetas', 'action' => 'empresa'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);
	# Editar Banner Básico
	Router::connect('/editar/banner-basico/:contato_id',
		array('controller' => 'banners', 'action' => 'editar_banner_basico'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);
	# Editar Banner Rotativo
	Router::connect('/editar/banner-rotativo/:contato_id',
		array('controller' => 'banners', 'action' => 'editar_banner_rotativo'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);
	# Editar Banner Premium
	Router::connect('/editar/banner-premium/:contato_id',
		array('controller' => 'banners', 'action' => 'editar_banner_premium'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);



/**
==========================
DADOS DA EMPRESA
==========================
*/
	# Nome e Descrição
	Router::connect('/editar/nome-e-descricao/:contato_id',
		array('controller' => 'contatos', 'action' => 'editar_a'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);
	# Telefones
	Router::connect('/editar/telefones/:contato_id',
		array('controller' => 'contatos', 'action' => 'editar_telefone'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);
	# Endereço
	Router::connect('/editar/endereco/:contato_id',
		array('controller' => 'contatos', 'action' => 'editar_endereco'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);
	# URl
	Router::connect('/editar/urls/:contato_id',
		array('controller' => 'contatos', 'action' => 'editar_urls'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);



/**
==========================
CORREÇÕES / COLABORAÇÕES
==========================
*/
	# sugerir correção
	Router::connect('/sugerir-correcao/:contato_id',
		array('controller' => 'correcoes', 'action' => 'sugerir_correcao'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);

	# sugerir telefone
	Router::connect('/sugerir-telefone/:contato_id',
		array('controller' => 'correcoes', 'action' => 'sugerir_telefone'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);

	# empresa inexistente
	Router::connect('/empresa-inexistente/:contato_id',
		array('controller' => 'correcoes', 'action' => 'informar_inexistencia'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);

	# denunciar
	Router::connect('/denunciar/:contato_id',
		array('controller' => 'correcoes', 'action' => 'denunciar'),
		array(
			'pass' => array('contato_id'),
			'contato_id' => '[0-9]+', // Números
		)
	);

	# Minhas colaborações
	Router::connect('/minhas-colaboracoes/:id',
		array('controller' => 'correcoes', 'action' => 'user_view'),
		array(
			'pass' => array('id'),
			'id' => '[0-9]+', // Números
		)
	);
	Router::connect('/minhas-colaboracoes/*', array('controller'=>'correcoes', 'action'=>'user_index'));




/**
==========================
PEDIDOS
==========================
*/
	Router::connect('/meus-pedidos', array('controller'=>'pedidos', 'action'=>'user_index'));
	Router::connect('/meus-pedidos/:id',
		array('controller' => 'pedidos', 'action' => 'user_view'),
		array(
			'pass' => array('id'),
			'id' => '[0-9]+', // Números
		)
	);


/**
==========================
FACEBOOK
==========================
*/
	Router::connect('/novidades/*', array('controller'=>'incorporations', 'action'=>'public_view'));

/**
==========================
OUTROS
==========================
*/
	Router::connect('/me-cadastrar/*', array('controller'=>'users', 'action'=>'cadastro_usuario'));
	Router::connect('/minhas-empresas', array('controller'=>'contatos', 'action'=>'minhas_empresas'));
	Router::connect('/aviso/em-desenvolvimento/*', array('controller'=>'pages', 'action'=>'display', 'em_desenvolvimento'));



/**
==========================
PÁGINAS
==========================
*/
	Router::connect('/pagina/*', array('controller' => 'pages', 'action' => 'display'));




/**
==========================
AUDITABLE
==========================
*/
	Router::connect('/logs', array('controller'=>'loggers', 'action'=>'index', 'plugin'=>false));
	Router::connect('/log/:id',
		array('controller' => 'loggers', 'action' => 'view'),
		array(
			'pass' => array('id'),
			'id' => '[0-9]+', // Números
		)
	);



/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Extensions
 *
 */
	Router::parseExtensions('json');

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
