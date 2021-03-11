<h2 class="page-header">Categorias</h2>

<div class="categorias index">
	
	<div class="row">
		<div class="col-md-12">
		<?php
			$link_add = '<span class="glyphicon glyphicon-plus"></span> Adicionar';
			echo $this->Html->link($link_add,
				array('controller'=>'categorias', 'action'=>'add'),
				array('escape'=>false, 'class'=> 'btn btn-primary pull-left')
			);
		?>
			<br /><br /><br />
		</div>	
	</div>

	<div class="row">
			
		<?php
			$media = round(count($categorias)/4); // Nº de categorias por coluna
			$l = 1;
		?>
		<?php foreach ($categorias as $key => $val): ?>

			<?php if($l == 1):?>
			<div class="categoria_item col-md-3">
			<?php endif; ?>

				<span>
					<strong class="link-cat">
						<?php echo h($val['Categoria']['nome']); ?>
						<?php
							$up_ico = ' <span class="span-cat glyphicon glyphicon-circle-arrow-up"></span>';
							$dw_ico = ' <span class="span-cat glyphicon glyphicon-circle-arrow-down"></span>';
							$edit_ico = ' <span class="span-cat glyphicon glyphicon-edit"></span>';
							echo $this->Html->link($up_ico, array('action' => 'moveup', $val['Categoria']['id'], 1), array('escape'=>false));
							echo $this->Html->link($dw_ico, array('action' => 'movedown', $val['Categoria']['id'], 1), array('escape'=>false));
							echo $this->Html->link($edit_ico, array('action' => 'edit', $val['Categoria']['id']), array('escape'=>false));
						?>
					</strong>
				</span>

				<?php echo $this->element('layout/categorias/children', array('var'=>$val['children'])); ?>			

			<?php if($l == $media): $l=1; ?>
			</div>
			<?php else: $l++; ?>
			<?php endif; ?>

		<?php endforeach; ?>

	</div>
</div>