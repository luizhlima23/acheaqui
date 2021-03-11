<div id="box">
	<h1><?php echo Configure::read('Meta.title'); ?></h1>
	<p><?php echo __('Para completar seu cadastro, acesse o link:');?> <?php echo $this->Html->link(__('Completar Cadastro'), array('controller'=>'users', 'action'=>'change_password', $hash, 'full_base' => true)); ?></p>
</div>