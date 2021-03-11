<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>

<div class="tags index">
	
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
							Etiquetas <small>tags</small>
						</td>
						<td width="20%">
						<?php 
							echo $this->Form->postLink('Atualizar Tags', 
								array(
									'controller'=>'tags',
									'action'=>'update',
									'plugin'=>false,
									'admin'=>false,
								),
								array(
									'inline'=>true,
									'escape'=>false,
									'class'=>'btn btn-primary pull-right',
									'confirm'=>__('Esta ação irá apagar toda a tabela de tags e criar novos valores de acordo com as Etiquetas, deseja continuar?'),
								)
							);
						?>
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

				<?php echo $this->element('layout/filtros/filter_tags'); ?>

				<?php if( $this->request->is('mobile') ): ?>
				<div class="table-responsive">
				<?php endif;?>
					<table class="table table-striped table-bordered">
						<?php if(!empty($tags)): ?>
						<thead>					
							<tr>
								<th width="5%" class="text-center"><?php echo $this->Paginator->sort('id', __('#')); ?></th>
								<th><?php echo $this->Paginator->sort('tag', __('Tag')); ?></th>
								<th width="10%" class="text-center"><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
							</tr>
						</thead>
						<tbody class="searchable">
							<?php foreach ($tags as $t): ?>
							<tr>
								<td class="text-center"><?php echo h($t['Tag']['id']); ?>&nbsp;</td>
								<td><?php echo h($t['Tag']['tag']); ?>&nbsp;</td>
								<td class="text-center">
								<?php
									$label_status = ($t['Tag']['status'])? 'label-default' : 'label-danger';
									echo $this->Html->tag('span',
										$this->Formata->status($t['Tag']['status']),
										array('class'=>'label '.$label_status)
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