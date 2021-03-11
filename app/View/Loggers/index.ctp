<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="logs index">
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<?php if(isset($admin_menu) and !empty($admin_menu)): ?>
			<!-- Admin menu -->
			<section id="admin_nav-menu" class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php echo $this->element('layout/admin_nav-menu', array('menu'=>$admin_menu)); ?>
				</div>
			</section>
			<?php endif; ?>

		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<h2 class="page-header">
				Logs de alterações
			</h2>
		</div>
	</div>

	<section class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="panel panel-default">

				<?php echo $this->element('layout/crud/table-panel_head', array('filter'=>true)); ?>

				<?php echo $this->element('layout/filtros/filter_logs'); ?>

				<?php if( $this->request->is('mobile') ): ?>
				<div class="table-responsive">
				<?php endif;?>
					<table class="table table-striped table-bordered">
						<?php if(!empty($loggers)): ?>
						<thead>					
							<tr>
								<th width="5%" class="text-center"><?php echo $this->Paginator->sort('id', __('#')); ?></th>
								<th><?php echo $this->Paginator->sort('User.id', __('Responsável')); ?></th>
								<th><?php echo $this->Paginator->sort('type', __('Ação')); ?></th>
								<th><?php echo $this->Paginator->sort('model_alias', __('Tabela')); ?></th>
								<th width="10%" class="text-center"><?php echo $this->Paginator->sort('created', __('Data e Hora')); ?></th>
								<th width="5%" class="text-center"><?php echo __('Ações');?></th>
							</tr>
						</thead>
						<tbody class="searchable">
							<?php foreach ($loggers as $d): ?>
							<tr>
								<td class="text-center"><?php echo h($d['Logger']['id']); ?>&nbsp;</td>
								<td><?php echo h($d['User']['nome']); ?>&nbsp;</td>
								<td><?php echo $this->Auditor->type($d['Logger']['type']); ?>&nbsp;</td>
								<td><?php echo h($d['Logger']['model_alias']); ?>&nbsp;</td>
								<td class="text-center"><?php echo $this->Formatacao->dataHora($d['Logger']['created']); ?>&nbsp;</td>
								<td class="actions text-center">
								<?php
									$id = $d['Logger']['id'];
									echo $this->Html->link('ver detalhes',
										array('controller'=>'loggers', 'action'=>'view', 'id'=>$id),
										array('class'=>'btn btn-primary btn-xs', 'escape'=>false)
									);
								?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
						<?php else: ?>

							<tr>
								<td class="text-danger">Nenhum registro encontrado!</td>
							</tr>
						<?php endif; ?>
					</table>
				<?php if( $this->request->is('mobile') ): ?>
				</div>
				<?php endif;?>

			</div>
			
			<div class="text-center">
			<?php
				$pagination = array('info'=>true);
				echo $this->element('layout/pagination', array('options'=>$pagination));
			?>
			</div>

		</div>
	</section>

</div>