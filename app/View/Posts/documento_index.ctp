<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="posts index">
	
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
							Documentos
						</td>
						<td width="20%">
						<?php 
							echo $this->Html->link(
								'<i class="fa fa-plus-square nav-icon"></i>'.'Novo documento',
								array('controller'=>'posts', 'action'=>'documento_add'),
								array('class'=>'btn btn-primary pull-right', 'escape'=>false)
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

				<?php //echo $this->element('layout/filtros/filter_correcoes'); ?>

				<?php if( $this->request->is('mobile') ): ?>
				<div class="table-responsive">
				<?php endif;?>
					<table class="table table-striped table-bordered">
						<?php if(!empty($posts)): ?>
						<thead>					
							<tr>
								<th width="5%" class="text-center"><?php echo $this->Paginator->sort('id', __('#')); ?></th>
								<th><?php echo $this->Paginator->sort('nome', __('Nome')); ?></th>
								<th width="15%" class="text-center"><?php echo $this->Paginator->sort('modified', __('Atualizado em')); ?></th>
								<th width="5%" class="text-center"><?php echo __('Ações');?></th>
							</tr>
						</thead>
						<tbody class="searchable">
							<?php foreach ($posts as $d): ?>
							<tr>
								<td class="text-center"><?php echo h($d['PostDocumento']['id']); ?>&nbsp;</td>
								<td><?php echo h($d['PostDocumento']['nome']); ?>&nbsp;</td>
								<td class="text-center"><?php echo $this->Formatacao->dataHora($d['PostDocumento']['modified']); ?>&nbsp;</td>
								<td class="actions text-center">
								<?php
									$id = $d['PostDocumento']['id'];
									$display = $d['PostDocumento']['nome'];
									$msg_excluir = __('Tem certeza de que deseja excluir: #%s - %s?', $id, $display);
									$options = array(
										'texto'=>'<i class="fa fa-bars"></i>&nbsp;&nbsp;',
										'class'=>'btn btn-xs btn-default dropdown-toggle',
									);
									$ico_list = '<i class="fa fa-search-plus nav-icon"></i>';
									$ico_edit = '<i class="fa fa-check-square-o nav-icon"></i>';
									$ico_trash = '<i class="fa fa-trash-o nav-icon"></i>';
									$menu = array(
										$ico_edit.__('Editar') => array('tipo'=>'link', 'url'=>array('controller'=>'posts', 'action'=>'documento_edit', $id)),
										$ico_trash.__('Excluir') => array('tipo'=>'postlink', 'url'=>array('controller'=>'posts', 'action'=>'documento_delete', $id), 'msg'=>$msg_excluir),
									);

									echo $this->element('layout/btn-dropdown', array('options'=>$options, 'menu'=>$menu));
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