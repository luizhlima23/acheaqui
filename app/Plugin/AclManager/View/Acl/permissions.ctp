<div class="row">
	<div class="col-md-12">
		<h2 class="page-header">
			<?php echo sprintf(__d('acl_manager', "%s permissions"), $aroAlias); ?>
			<?php 
			$aroModels = Configure::read("AclManager.aros");
			if ($aroModels > 1): ?>
				<?php foreach ($aroModels as $aroModel): ?>
					<?php echo $this->Html->link($aroModel, array('aro' => $aroModel), array('class'=>'btn btn-default1')); ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</h2>
		<p>
			<ul class="nav nav-tabs">
				<li class="active"><?php echo $this->Html->link(__d('acl_manager', 'Manage permissions'), array('action' => 'permissions')); ?></li>
				<li><?php echo $this->Html->link(__d('acl_manager', 'Update ACOs'), array('action' => 'update_acos')); ?></li>
				<li><?php echo $this->Html->link(__d('acl_manager', 'Update AROs'), array('action' => 'update_aros')); ?></li>
				<li><?php echo $this->Html->link(__d('acl_manager', 'Drop ACOs/AROs'), array('action' => 'drop'), array(), __d('acl_manager', "Do you want to drop all ACOs and AROs?")); ?></li>
				<li><?php echo $this->Html->link(__d('acl_manager', 'Drop permissions'), array('action' => 'drop_perms'), array(), __d('acl_manager', "Do you want to drop all the permissions?")); ?></li>
			</ul>
		</p>
	</div>
</div>

<div class="row">
	<div class="form col-md-12">
	<?php echo $this->Form->create('Perms'); ?>
		<?php echo $this->Form->button(__('Salvar Permissões'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg pull-left', 'data-loading-text'=>'Aguarde...')); ?>
		<br /><br /><br />
		<?php echo $this->element('pagination'); ?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Action</th>
					<?php foreach ($aros as $aro): ?>
					<?php $aro = array_shift($aro); ?>
					<th style="font-size: 20px"><?php echo h($aro[$aroDisplayField]); ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
		<?php
		$uglyIdent = Configure::read('AclManager.uglyIdent'); 
		$lastIdent = null;
		foreach ($acos as $id => $aco) {
			$action = $aco['Action'];
			$alias = $aco['Aco']['alias'];
			$ident = substr_count($action, '/');
			if ($ident <= $lastIdent && !is_null($lastIdent)) {
				for ($i = 0; $i <= ($lastIdent - $ident); $i++) {
					?></tr><?php
				}
			}
			if ($ident != $lastIdent) {
				?><tr class='aclmanager-ident-<?php echo $ident; ?>'><?php
			}
			?><td  style="font-size: 16px"><?php echo ($ident == 1 ? "<strong>" : "" ) . ($uglyIdent ? str_repeat("&nbsp;&nbsp;", $ident) : "") . h($alias) . ($ident == 1 ? "</strong>" : "" ); ?></td>
			<?php foreach ($aros as $aro): 
				$inherit = $this->Form->value("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias]['id']}-inherit");
				$allowed = $this->Form->value("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias]['id']}"); 
				$value = $inherit ? 'inherit' : null; 
				$icon = $this->Html->image(($allowed ? 'test-pass-icon.png' : 'test-fail-icon.png')); ?>
				<td><?php echo $icon . " " . $this->Form->select("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias]['id']}", array(array('inherit' => __d('acl_manager', 'Inherit'), 'allow' => __d('acl_manager', 'Allow'), 'deny' => __d('acl_manager', 'Deny'))), array('empty' => __d('acl_manager', 'No change'), 'value' => $value)); ?></td>
			<?php endforeach; ?>
		<?php 
			$lastIdent = $ident;
		}
		for ($i = 0; $i <= $lastIdent; $i++) {
			?></tr><?php
		}
		?>
			</tbody>
		</table>
		<br />

		<?php echo $this->Form->button(__('Salvar Permissões'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
	
	<?php echo $this->Form->end(); ?>
	</div>
	<div class="col-md-12">
		<br />
		<?php echo $this->element('pagination'); ?>
	</div>
</div>