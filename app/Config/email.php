<?php

class EmailConfig {

	public $default = array(
		'transport' => 'Smtp',
		'from' => array('no-reply@royalbranding.com.br' => 'Aonde.info'),
		'host' => 'mail.royalbranding.com.br',
		'port' => 587,
		'timeout' => 30,
		'username' => 'no-reply@royalbranding.com.br',
		'password' => 'rt45RT45',
		'client' => null,
		'log' => false,
		'charset' => 'utf-8',
		'headerCharset' => 'utf-8',
	);
}
