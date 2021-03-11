<ul class="list-unstyled">
	<?php foreach ($var as $key => $value): ?>
		<li class="link-cat">
			<?php
				$up_ico = ' <span class="span-cat glyphicon glyphicon-circle-arrow-up"></span>';
				$dw_ico = ' <span class="span-cat glyphicon glyphicon-circle-arrow-down"></span>';
				$edit_ico = ' <span class="span-cat glyphicon glyphicon-edit"></span>';
				echo h($value['Categoria']['nome']);
				echo $this->Html->link($up_ico, array('action' => 'moveup', $value['Categoria']['id'], 1), array('escape'=>false));
				echo $this->Html->link($dw_ico, array('action' => 'movedown', $value['Categoria']['id'], 1), array('escape'=>false));
				echo $this->Html->link($edit_ico, array('action' => 'edit', $value['Categoria']['id']), array('escape'=>false));
				if(!empty($value['children'])){
					echo $this->element('layout/categorias/children', array('var'=>$value['children']));
				}
			?>
		</li>
	<?php endforeach; ?>
</ul>