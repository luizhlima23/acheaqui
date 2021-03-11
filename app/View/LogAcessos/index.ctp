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
				<table width="100%">
					<tr>
						<td width="80%">
							Logs <small>de acessos</small>
						</td>
						<td width="20%">
						</td>
					</tr>
				</table>
			</h2>
		</div>
	</div>
	
	<section class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="panel panel-default">

				<?php echo $this->element('layout/crud/table-panel_head', array('filter'=>true)); ?>

				<?php echo $this->element('layout/filtros/filter_log_acessos'); ?>

				<?php if( $this->request->is('mobile') ): ?>
				<div class="table-responsive">
				<?php endif;?>
					<table class="table table-striped table-bordered">
						<?php if(!empty($logs)): ?>
						<thead>					
							<tr>
								<th width="5%" class="text-center"><?php echo $this->Paginator->sort('id', __('#')); ?></th>
								<th><?php echo $this->Paginator->sort('User.nome_completo', __('Úsuário')); ?></th>
								<th><?php echo $this->Paginator->sort('created', __('Data')); ?></th>
								<th><?php echo $this->Paginator->sort('ip', __('IP')); ?></th>
								<th><?php echo $this->Paginator->sort('is_mobile', __('Mobile')); ?></th>
								<th width="10%" class="text-center"><?php echo __('Ações');?></th>
							</tr>
						</thead>
						<tbody class="searchable">
							<?php foreach ($logs as $l): ?>
							<tr>
								<td class="text-center"><?php echo h($l['LogAcesso']['id']); ?>&nbsp;</td>
								<td><?php echo h($l['User']['nome_completo']); ?>&nbsp;</td>
								<td><?php echo $this->Formatacao->dataHora($l['LogAcesso']['created']); ?>&nbsp;</td>
								<td><?php echo h($l['LogAcesso']['ip']); ?>&nbsp;</td>
								<td><?php echo $this->Formata->status($l['LogAcesso']['is_mobile'], 2); ?>&nbsp;</td>
								<td class="actions text-center">
								<?php
									$id = $l['LogAcesso']['id'];
									$display = $l['User']['nome_completo'];
									echo $this->Html->link('ver detalhes',
										array('controller'=>'log_acessos', 'action'=>'view', $id),
										array('class'=>'btn btn-default btn-xs', 'escape'=>false)
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