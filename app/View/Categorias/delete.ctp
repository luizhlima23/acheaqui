<div>
	<h2>Excluir categoria</h2>
</div>

<div>
	<?php echo $this->Form->create('Categoria', array('type' => 'delete')); ?>
	<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

	<h3>Nome</h3>
	<p><?php echo h($this->data['Categoria']['nome']); ?>

	<h3>Sub categorias que também serão excluidas:</h3>
	<ul>
		<?php if (count($deleteCategoryList) <= 0): ?>
			<li>なし</li>
		<?php else: ?>
			<?php foreach($deleteCategoryList as $deleteCategory): ?>
			<li>
				<?php echo h($deleteCategory['Categoria']['nome']); ?>
			</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	
	<?php echo $this->Form->end(' Excluir '); ?>
</div>

<div class="pageLinks">
	<p><?php echo $this->Html->link('Lista', array('action' => 'edit', $this->data['Categoria']['id'])); ?></p>
</div>