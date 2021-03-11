<?php 
	
	# Filtros estáticos
	$config = array(
		'User' => array(
			'f_cod' => array(
			    'User.id' => array(
			        'operator' => '=',
			        'value' => array(
			            'before' => '',
			            'after'  => ''
			        )
			    )
			),
			'f_name' => array(
			    'User.nome' => array(
			        'operator' => 'LIKE',
			        'value' => array(
			            'before' => '%',
			            'after'  => '%' 
			        )
			    )
			),
			'f_email' => array(
			    'User.email' => array(
			        'operator' => 'LIKE',
			        'value' => array(
			            'before' => '%',
			            'after'  => '%' 
			        )
			    )
			),
		),
		'Role' => array(
			'f_cod' => array(
			    'Role.id' => array(
			        'operator' => '=',
			        'value' => array(
			            'before' => '',
			            'after'  => ''
			        )
			    )
			),
			'f_name' => array(
			    'Role.name' => array(
			        'operator' => 'LIKE',
			        'value' => array(
			            'before' => '%',
			            'after'  => '%' 
			        )
			    )
			),
		),
		'Contato' => array(
			'f_cod' => array(
			    'Contato.id' => array(
			        'operator' => '=',
			        'value' => array(
			            'before' => '',
			            'after'  => ''
			        )
			    )
			),
			'f_nome' => array(
			    'Contato.nome' => array(
			        'operator' => 'LIKE',
			        'value' => array(
			            'before' => '%',
			            'after'  => '%'
			        )
			    )
			),
			'f_fone1' => array(
			    'Contato.fone1' => array(
			        'operator' => 'LIKE',
			        'value' => array(
			            'before' => '%',
			            'after'  => '%'
			        )
			    )
			),
			'f_referencia' => array(
			    'Contato.end_ref' => array(
			        'operator' => 'LIKE',
			        'value' => array(
			            'before' => '%',
			            'after'  => '%'
			        )
			    )
			),
			'f_user' => array(
			    'User.name' => array(
			        'operator' => 'LIKE',
			        'value' => array(
			            'before' => '%',
			            'after'  => '%'
			        )
			    )
			),
		),
		'Log' => array(
			'f_cod' => array(
				'Logger.id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after'  => ''
					)
				)
			),
			'f_resp' => array(
				'Logger.responsible_id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after'  => ''
					)
				)
			),
			'f_tab' => array(
				'Logger.model_alias' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after'  => ''
					)
				)
			),
			'f_mod' => array(
				'Logger.model_id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after'  => ''
					)
				)
			)
		),
		'LogAcesso' => array(
			'f_cod' => array(
				'LogAcesso.id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_user_id' => array(
				'LogAcesso.user_id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after'  => ''
					)
				)
			),
			'f_ip' => array(
				'LogAcesso.ip' => array(
					'operator' => 'LIKE',
					'value' => array(
						'before' => '%',
						'after'  => '%'
					)
				)
			),
		),
		'LogPesquisa' => array(
			'f_cod' => array(
				'LogPesquisa.id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_search_string' => array(
				'LogPesquisa.search_string' => array(
					'operator' => 'LIKE',
					'value' => array(
						'before' => '%',
						'after'  => '%'
					)
				)
			),
			'f_user_id' => array(
				'LogPesquisa.user_id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after'  => ''
					)
				)
			),
			'f_ip' => array(
				'LogPesquisa.ip' => array(
					'operator' => 'LIKE',
					'value' => array(
						'before' => '%',
						'after'  => '%'
					)
				)
			),
		),
		'Logradouro' => array(
			'f_cod' => array(
				'Logradouro.id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_tipo' => array(
				'Logradouro.end_tipo' => array(
					'operator' => 'LIKE',
					'value' => array(
						'before' => '%',
						'after'  => '%'
					)
				)
			),
			'f_desc' => array(
				'Logradouro.descricao' => array(
					'operator' => 'LIKE',
					'value' => array(
						'before' => '%',
						'after'  => '%'
					)
				)
			),
		),
		'Bairro' => array(
			'f_cod' => array(
				'Bairro.id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_nome' => array(
				'Bairro.nome' => array(
					'operator' => 'LIKE',
					'value' => array(
						'before' => '%',
						'after'  => '%'
					)
				)
			),
		),
		'Correcao' => array(
			'f_cod' => array(
				'Correcao.id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_user_id' => array(
				'Correcao.user_id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_contato_id' => array(
				'Correcao.contato_id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
		),
		'Tag' => array(
			'f_cod' => array(
				'Tag.id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_tag' => array(
				'Tag.tag' => array(
					'operator' => 'LIKE',
					'value' => array(
						'before' => '%',
						'after'  => '%'
					)
				)
			),
		),
		'Pedido' => array(
			'f_cod' => array(
				'Pedido.id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_contato_id' => array(
				'Pedido.contato_id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
			'f_user_id' => array(
				'Pedido.user_id' => array(
					'operator' => '=',
					'value' => array(
						'before' => '',
						'after' => ''
					)
				)
			),
		),
	);

?>