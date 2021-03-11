<?php
App::uses('AuditableConfig', 'Auditable.Lib');
App::uses('CakeText', 'Utility');
/**
 * Helper para auxiliar na exibição dos logs gravados pelo behavior Auditable.
 *
 * Permite a formatação de acordo com as preferências do usuário das alterações
 * efetuadas em cada entrada do log.
 *
 * PHP version > 5.3.1
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Radig - Soluções em TI, www.radig.com.br
 * @link http://www.radig.com.br
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * @package radig.Auditable
 * @subpackage View.Helper
 */
class AuditorHelper extends AppHelper
{
	/**
	 * Configurações padrões
	 *
	 * @var array
	 */
	public $settings = array(
		'formats' => array(
			'general' => "Registro :action:<br />\n :data",
			'prepend' => "Campo",
			'pospend' => "<br />\n",
			'criou' => "\":field\" em \":value\"",
			'modificou' => "\":field\" de \":old\" para \":new\"",
			'deletou' => "\":field\" em \":value\""
		)
	);

	/**
	 * ENUM auxiliar para os tipos de logs
	 *
	 * @var array
	 */
	protected $typesEnum = array(
		'indefinido',
		'criou',
		'modificou',
		'deletou'
	);

	/**
	 * Retorna a string localizada que representa
	 * o tipo numérico do log.
	 *
	 * @param int $t
	 * @return string
	 */
	public function type($t)
	{
		return ucfirst(__d('auditable', $this->typesEnum[$t]));
	}

	/**
	 * Formata uma entrada de log gerada pelo AuditableBehavior para fácil
	 * visualização na view, baseada nas configurações do helper.
	 *
	 * @param array $data
	 * @param int $type
	 *
	 * @return string
	 */
	public function format($data, $type)
	{
		$func = 'unserialize';

		if (is_callable(AuditableConfig::$unserialize)) {
			$func = AuditableConfig::$unserialize;
		}

		$data = call_user_func($func, $data);

		$placeHolders = array();
		$prepend = __d('auditable', $this->settings['formats']['prepend']) . ' ';
		$pospend = ' ' . __d('auditable', $this->settings['formats']['pospend']);
		$humanDiff = '';
		$action = $this->typesEnum[$type];
		$actionMsg = __d('auditable', $this->settings['formats'][$action]);

		switch ($type) {
			case 2:
				$placeHolders['action'] = __d('auditable', 'modificou');

				foreach ($data as $field => $changes) {
					$humanDiff .= $prepend . CakeText::insert($actionMsg, array('field' => $field, 'old' => $changes['old'], 'new' => $changes['new'])) . $pospend;
				}

				break;

			case 1:
				$placeHolders['action'] = __d('auditable', 'criou');

			case 3:
				if (!isset($placeHolders['action'])) {
					$placeHolders['action'] = __d('auditable', 'deletou');
				}

				foreach ($data as $field => $value) {
					$humanDiff .= $prepend . CakeText::insert($actionMsg, compact('field', 'value')) . $pospend;
				}

				break;

			default:
				$placeHolders['action'] = __d('auditable', 'indefinido');
				$humanDiff .= __d('auditable', 'nenhuma alteração');
				break;
		}

		$placeHolders['data'] = $humanDiff;

		$msg = CakeText::insert(__d('auditable', $this->settings['formats']['general']), $placeHolders);

		return $msg;
	}
}
