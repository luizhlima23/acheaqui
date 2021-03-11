<div id="box">
	<h1><?php echo Configure::read('Meta.title'); ?></h1>
	<p><?php echo __('Para redefinir sua senha, acesse o link:');?> <?php echo $this->Html->link(__('Registrar nova senha'), array('controller'=>'users', 'action'=>'change_password', $hash, 'full_base' => true)); ?></p>
	<?php echo $this->Html->tag('p',__('Se você não solicitou uma nova senha, por favor ignore este e-mail.'));?>
</div>