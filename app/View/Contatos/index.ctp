<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="empresas index">
	
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
							Empresas
						</td>
						<td width="20%">
						<?php 
							echo $this->Form->postLink('Atualizar Slugs', 
								array(
									'controller'=>'contatos',
									'action'=>'update_slugs',
									'plugin'=>false,
									'admin'=>false,
								),
								array(
									'inline'=>true,
									'escape'=>false,
									'class'=>'btn btn-primary pull-right',
									'confirm'=>__('Esta ação irá gerar slugs para todas empresas sem o mesmo, deseja continuar?'),
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

				<?php echo $this->element('layout/crud/table-panel_head', array('filter'=>false)); ?>

				<?php //echo $this->element('layout/filtros/filter_contatos'); ?>		

				<?php if( $this->request->is('mobile') ): ?>
				<div class="table-responsive">
				<?php endif;?>
					<table class="table table-striped table-bordered">
						<?php if(!empty($contatos)): ?>
						<thead>					
							<tr>
								<th width="5%" class="text-center"><?php echo $this->Paginator->sort('id', __('#')); ?></th>
								<th><?php echo $this->Paginator->sort('nome', __('Nome')); ?></th>
								<th><?php echo $this->Paginator->sort('fone1', __('Telefone')); ?></th>
								<th><?php echo $this->Paginator->sort('end_completo', __('Endereço')); ?></th>
								<th width="10%" class="text-center"><?php echo $this->Paginator->sort('status', __('Status')); ?></th>
								<th width="10%" class="text-center"><?php echo __('Ações');?></th>
							</tr>
						</thead>
						<tbody class="searchable">
							<?php foreach ($contatos as $d): ?>
							<tr>
								<td class="text-center"><?php echo h($d['Contato']['id']); ?>&nbsp;</td>
								<td><?php echo h($d['Contato']['nome']); ?>&nbsp;</td>
								<td><?php echo $this->Formata->fone($d['Contato']['fone1']); ?>&nbsp;</td>
								<td><?php echo $d['Contato']['end_completo']; ?>&nbsp;</td>
								<td class="text-center">
								<?php
									$label_status = ($d['Contato']['status'])? 'label-default' : 'label-danger';
									echo $this->Html->tag('span',
										$this->Formata->status($d['Contato']['status']),
										array('class'=>'label '.$label_status)
									);
								?>
								</td>
								<td class="actions text-center">
								<?php
									$id = $d['Contato']['id'];
									$display = $d['Contato']['nome'];
									echo $this->Html->link('ver detalhes',
										array('controller'=>'contatos', 'action'=>'view', $id),
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