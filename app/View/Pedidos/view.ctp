<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
</style>

<div class="pedidos empresa">
	
	<!-- header -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2 class="page-header">
				Pedido #<?php echo $data['Pedido']['id']; ?>
			</h2>
			<h3>detalhes</h3>
		</div>
	</div>

	<!-- registro -->
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
			
			<?php if( $this->request->is('mobile') ): ?>
			<div class="table-responsive">
			<?php endif;?>
				<table class="table table-striped table-bordered table-view">
					<tbody>
						<tr>
							<th><?php echo __('# ID'); ?></th>
							<td><?php echo h($data['Pedido']['id']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Empresa'); ?></th>
							<td><?php echo h($data['Pedido']['contato']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Responsavel'); ?></th>
							<td>
								<?php 
									echo h($data['User']['nome'].' '.$data['User']['sbnome'].' - #'.$data['User']['id']);
									echo '&nbsp;&nbsp;&nbsp;'.$this->Html->link('ver mais',
										array('controller'=>'users', 'action'=>'view', $data['User']['id']),
										array('class'=>'btn-link')
									);
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('Serviços'); ?></th>
							<td>
								<?php foreach($servicos as $model=>$s): ?>

									<p>
										<?php echo $pacotes[$model]['nome'] ?> <small>( <?php echo $this->Formatacao->moeda($s['subtotal']); ?> )</small>
										<br>
										<em class="text-muted"><small><?php echo $this->Formatacao->data($s['inicio']); ?>
										 a 
										<?php echo $this->Formatacao->data($s['fim']); ?></small></em>
									</p>

								<?php endforeach; ?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('Status'); ?></th>
							<td>
								<?php 
									$status_str = $this->Formata->status_string($data['Pedido']['status'], $status_pedido);
									switch ($data['Pedido']['status']) {
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
						</tr>
						<tr>
							<th><?php echo __('Criado em'); ?></th>
							<td>
								<?php echo $this->Formatacao->dataCompleta($data['Pedido']['created']); ?>
								<br><small>Última atualização: <?php echo $this->Formatacao->dataHora($data['Pedido']['modified']); ?></small>
							</td>
						</tr>
					</tbody>
				</table>
			<?php if( $this->request->is('mobile') ): ?>
			</div>
			<?php endif;?>
			
			<?php 
				if($data['Pedido']['status'] == 1){

					echo $this->Form->postLink('Aprovar pedido', 
						array('controller'=>'pedidos', 'action'=>'aprovar_pedido', $data['Pedido']['id']),
						array('escape'=>false, 'class'=>'btn btn-success'),
						'Tem certeza que deseja aprovar o pedido #'.$data['Pedido']['id'].' ?'
					);
				}
			?>
			<br><br>
			<button href="javascript:void(0);" type="button" class="btn btn-muted text-no_underscore" data-toggle="modal" data-target="#ModalContrato">
				<b class="fa fa-file-text"></b> Contrato
			</button>

			<!-- Modal Contrato -->
			<?php echo $this->element('layout/contrato-anuncio_modal');?>

		</div>
	</div>

</div>