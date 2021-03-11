<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="logs view">
	
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
	
	<?php if(!empty($log)): ?>

		<?php 
			$id = $log['LogPesquisa']['id'];
			$display = "#$id - ".$log['LogPesquisa']['search_string'];
		?>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<h2 class="page-header">
				<table width="100%">
					<tr>
						<td width="80%">
						<?php echo $display; ?>
						</td>
						<td width="20%">
						</td>
					</tr>
				</table>
			</h2>
			<h3 class="page-subtitle">
				Mais detalhes
			</h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">

			<?php if( $this->request->is('mobile') ): ?>
			<div class="table-responsive">
			<?php endif;?>
				<table class="table table-striped table-bordered table-view">
					<tbody>
						<tr>
							<th><?php echo __('# ID'); ?></th>
							<td><?php echo h($log['LogPesquisa']['id']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Pesquisa'); ?></th>
							<td><?php echo h($log['LogPesquisa']['search_string']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Data'); ?></th>
							<td><?php echo $this->Formatacao->dataCompleta($log['LogPesquisa']['created']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Mobile'); ?></th>
							<td><?php echo $this->Formata->status($log['LogPesquisa']['is_mobile'], 2); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Usuário'); ?></th>
							<td><?php echo h($log['User']['nome_completo'].' - #'.$log['LogPesquisa']['user_id']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('IP'); ?></th>
							<td><?php echo h($log['LogPesquisa']['ip']); ?></td>
						</tr>
					</tbody>
				</table>
			<?php if( $this->request->is('mobile') ): ?>
			</div>
			<?php endif;?>

		</div>
	</div>

	<?php endif; ?>

</div>