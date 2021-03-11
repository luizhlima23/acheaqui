<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="logradouros view">
	
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
	
	<?php if(!empty($this->request->data)): ?>

		<?php 
			$id = $this->request->data['Logradouro']['id'];
			$display = $this->request->data['Logradouro']['descricao'];
		?>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<h2 class="page-header">
				<table width="100%">
					<tr>
						<td width="80%">
						<?php echo $this->Html->link($display, array('controller'=>'logradouros', 'action'=>'view', $id)); ?>
						</td>
						<td width="20%">
						</td>
					</tr>
				</table>
			</h2>
			<h3 class="page-subtitle">
				Editar
			</h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="well">
			<?php echo $this->element('forms/form-logradouro'); ?>
			</div>	
		</div>
	</div>

	<?php endif; ?>

</div>