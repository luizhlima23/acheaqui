<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="bairros view">
	
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
	
	<?php if(!empty($bairro)): ?>

		<?php 
			$id = $bairro['Bairro']['id'];
			$display = $bairro['Bairro']['nome'];
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
				<?php
					$msg_excluir = __('Tem certeza de que deseja excluir: #%s - %s?', $id, $display);
					$options = array(
						'texto'=>'<i class="fa fa-bars"></i>&nbsp;&nbsp;',
						'class'=>'btn btn-default dropdown-toggle',
					);
					$ico_edit = '<i class="fa fa-edit nav-icon"></i>';
					$ico_trash = '<i class="fa fa-trash-o nav-icon"></i>';
					$menu = array(
						$ico_edit.__('Editar') => array('tipo'=>'link', 'url'=>array('controller'=>'bairros', 'action'=>'edit', $id)),
						$ico_trash.__('Excluir') => array('tipo'=>'postlink', 'url'=>array('controller'=>'bairros', 'action'=>'delete', $id), 'msg'=>$msg_excluir),
					);

					echo $this->element('layout/btn-dropdown', array('options'=>$options, 'menu'=>$menu));
				 ?>
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
							<td><?php echo h($bairro['Bairro']['id']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Nome'); ?></th>
							<td><?php echo h($bairro['Bairro']['nome']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Cidade'); ?></th>
							<td><?php echo h($bairro['Cidade']['nome'].' - #'.$bairro['Cidade']['id']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Status'); ?></th>
							<td>
							<?php
								$label_status = ($bairro['Bairro']['status'])? 'label-default' : 'label-danger';
								echo $this->Html->tag('span',
									$this->Formata->status($bairro['Bairro']['status']),
									array('class'=>'label '.$label_status)
								);
							?>								
							</td>
						</tr>
						<tr>
							<th><?php echo __('Criado'); ?></th>
							<td><?php echo $this->Formatacao->dataCompleta($bairro['Bairro']['created']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Modificado'); ?></th>
							<td><?php echo $this->Formatacao->dataCompleta($bairro['Bairro']['modified']); ?></td>
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