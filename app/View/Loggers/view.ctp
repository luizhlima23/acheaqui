<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
</style>

<div class="logs empresa">
	
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

	<!-- header -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2 class="page-header">
				Log de alterações <small><?php echo '#'.$log['Logger']['id']; ?></small>
			</h2>
			<h3>detalhes</h3>
		</div>
	</div>
	
	<!-- Detalhes -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<br>
			<?php if( $this->request->is('mobile') ): ?>
			<div class="table-responsive">
			<?php endif;?>
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<th><?php echo __('# ID'); ?></th>
							<td><?php echo h($log['Logger']['id']); ?>&nbsp;</td>
						</tr>
						<tr>
							<th><?php echo __('Tabela'); ?></th>
							<td><?php echo h($log['Logger']['model_alias']); ?>&nbsp;</td>
						</tr>
						<tr>
							<th><?php echo __('# ID do registro na Tabela'); ?></th>
							<td><?php echo h($log['Logger']['model_id']); ?>&nbsp;</td>
						</tr>
						<tr>
							<th><?php echo __('Alteração'); ?></th>
							<td><?php echo $this->Auditor->format($log['LogDetail']['difference'], $log['Logger']['type']); ?>&nbsp;</td>
						</tr>
						<tr>
							<th><?php echo __('Responsável'); ?></th>
							<td><?php echo h($log['User']['nome'].' '.$log['User']['sbnome']); ?>&nbsp;</td>
						</tr>
						<tr>
							<th><?php echo __('# ID do Responsável'); ?></th>
							<td><?php echo h($log['User']['id']); ?>&nbsp;</td>
						</tr>
						<tr>
							<th><?php echo __('Data e Hora'); ?></th>
							<td><?php echo $this->Formatacao->dataCompleta($log['Logger']['created']); ?>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			<?php if( $this->request->is('mobile') ): ?>
			</div>
			<?php endif;?>

		</div>
	</div>

</div>