<h2 class="page-header"><?php echo empty($this->data['Categoria']['id']) ? 'Adicionar' : 'Editar'; ?> Categoria</h2>
<div class="row">
	
	<div class="col-md-3">
		<div class="actions">
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo __('Ações'); ?></div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						<li>
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Lista'), array('action' => 'index'), array('escape' => false)); ?>
						</li>						
						<li>
							<?php echo empty($this->data['Categoria']['id']) ? null : $this->Html->link('<span class="glyphicon glyphicon-remove text-danger"></span>&nbsp;&nbsp;'.__('Excluir'), array('action' => 'delete', $this->data['Categoria']['id']), array('escape' => false, 'class'=>' text-danger')); ?>
						</li>						
					</ul>
				</div>
			</div>
		</div>			
	</div>

	<div class="col-md-9">
		<?php echo $this->element('forms/form-categoria'); ?>
	</div>

</div>