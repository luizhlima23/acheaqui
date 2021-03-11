<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="pedidos index">
	
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
				Pedidos de anúncio
			</h2>
		</div>
	</div>

	<section class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="panel panel-default">

				<?php echo $this->element('layout/crud/table-panel_head', array('filter'=>true)); ?>

				<?php echo $this->element('layout/filtros/filter_pedidos'); ?>

				<?php if( $this->request->is('mobile') ): ?>
				<div class="table-responsive">
				<?php endif;?>
					<table class="table table-striped table-bordered">
						<?php if(!empty($pedidos)): ?>
						<thead>					
							<tr>
								<th width="5%" class="text-center"><?php echo $this->Paginator->sort('id', __('#')); ?></th>
								<th><?php echo $this->Paginator->sort('contato', __('Empresa')); ?></th>
								<th width="15%" class="text-center"><?php echo $this->Paginator->sort('created', __('Criado em')); ?></th>
								<th width="15%" class="text-center"><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
								<th width="5%" class="text-center"><?php echo __('Ações');?></th>
							</tr>
						</thead>
						<tbody class="searchable">
							<?php foreach ($pedidos as $d): ?>
							<tr>
								<td class="text-center"><?php echo h($d['Pedido']['id']); ?>&nbsp;</td>
								<td><?php echo h($d['Pedido']['contato']); ?>&nbsp;</td>
								<td class="text-center"><?php echo $this->Formatacao->dataHora($d['Pedido']['created']); ?>&nbsp;</td>
								<td class="text-center">
									<?php 
										$status_str = $this->Formata->status_string($d['Pedido']['status'], $status_pedido);
										switch ($d['Pedido']['status']) {
											case '2':
												echo '<span class="label label-success"><b class="fa fa-check"></b> '.$status_str.'</span>';
												break;
											
											case '1':
												echo '<span class="label label-warning">'.$status_str.'</span>';
												break;
											
											case '0':
												echo '<span class="label label-default">'.$status_str.'</span>';
												break;
											
											default:
												echo $status_str;
												break;
										}
									?>
								</td>
								<td class="actions text-center">
								<?php
									$id = $d['Pedido']['id'];
									$display = $d['Pedido']['contato'];
									echo $this->Html->link('ver detalhes',
										array('controller'=>'pedidos', 'action'=>'view', $id),
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