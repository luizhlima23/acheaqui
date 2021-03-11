<!-- Lista -->
<?php if(isset($index) AND isset($id)): ?>
	<li>
		<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Lista'), array('action' => $index), array('escape' => false, 'class'=>'text-primary')); ?>
	</li>
<?php endif; ?>

<!-- Ver Mais -->
<?php if(isset($view) AND isset($id)): ?>
	<li>
		View
	</li>
<?php endif; ?>

<!-- Editar -->
<?php if(isset($edit) AND isset($id)): ?>
	<li>
		<?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;'.__('Editar'), array('action' => $edit, $id), array('escape' => false, 'class'=>'text-success')); ?>
	</li>
<?php endif; ?>

<!-- Adicionar -->
<?php if(isset($add) AND isset($id)): ?>
	<li>
		<?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Adicionar'), array('action' => $add), array('escape' => false, 'class'=>'text-primary')); ?>
	</li>
<?php endif; ?>

<!-- Excluir -->
<?php if(isset($delete) AND isset($id)): ?>
	<li>
		<?php echo $this->Form->postLink(__('<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;'.__('Excluir')), array('action' => $delete, $id), array('escape' => false, 'class'=>'text-danger'), __('Tem certeza de que deseja excluir # %s?', $nome)); ?>
	</li>
<?php endif; ?>