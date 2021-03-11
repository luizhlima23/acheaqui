<style type="text/css">
	#tbPedidos tr:first-child td{
		border-top:0px !important;
	}
	#tbPedidos .Etiqueta strong{color: #F58634;}
	#tbPedidos .BannerA strong{color: #5CA47A;}
	#tbPedidos .BannerB strong{color: #718FC8;}
	#tbPedidos .BannerC strong{color: #A46080;}
	.tdServico strong{
		font-size: 18px;
	}
	.tdVigencia{
		font-size: 14px;
	}
	.tdValor{
		font-size: 14px;
	}
	.tdTotal{
		font-size: 18px;
	}
	#tbPedidos tfoot *{
		border-color: transparent !important;
	}
</style>

<div class="row">
	<div class=" col-xs-12 col-sm-12 col-md-12">
		<h2 class="page-header">
			Pedido <small>detalhes</small>
		</h2>
	</div>
</div>

<div class="row">
	<div class=" col-xs-12 col-sm-8 col-md-8">
		<table id="tbPedidos" class="table table-bordered table-striped">
			
			<thead>
				<tr>
					<th>Serviço selecionado</th>
					<th class="text-right">Valor</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($servicos as $model=>$s): ?>
					<?php 
						$servico = ($s['valor'] > 0)? $s['servico_id'].' - '.$s['servico_nome'] : '<small>'.$s['servico_nome'].'</small>';
						$plano = ($s['valor'] > 0)? '('.$s['plano_nome'].')' : '<small>(gratuito)</small>';
						$class = ($s['valor'] > 0)? $model : '';
					?>
					<tr>
						<td class="tdServico <?php echo $class; ?> text-left">
							<strong><?php echo $servico; ?></strong> <br class="visible-xs"><?php echo $plano; ?>
							<br>
							<em class="text-muted"><small><?php echo $this->Formatacao->data($s['inicio']); ?>
							 a 
							<?php echo $this->Formatacao->data($s['fim']); ?></small></em>
						</td>
						<td class="tdValor text-right">
							<?php echo $this->Formatacao->moeda($s['subtotal']); ?>
							<br class="visible-xs">
							<small class="text-muted">
								(<?php echo $this->Formatacao->moeda($s['valor']).' x '.$this->Formata->stringMeses_plano($s['plano']); ?>)
							</small>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td class="tdTotal text-right"><strong>Total: </strong><?php echo $this->Formatacao->moeda($total); ?></td>
				</tr>
			</tfoot>

		</table>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8">
		<p class="text-right text-muted">
			<?php if($contrato): ?>

			<br>
			<small>
				Ao confirmar você assume que concorda com o 
				<button type="button" class=" btn-link" data-toggle="modal" data-target="#ModalContrato">
					contrato de anúncio
				</button>
			</small>

			<?php else: ?>

				<br>
				<div class="alert alert-danger text-center">
					Não foi possível exibir o contrato, por este motivo, você não pode concluir o pedido.
					<br> Por favor entre em 
					<?php echo $this->Html->link('contato', array('controller'=>'mensagens', 'action'=>'contato'), array('class'=>' btn-link')); ?>
				</div>

			<?php endif; ?>
		</p>
		<br>
	</div>
</div>

<!-- Modal Contrato -->
<?php if($contrato): ?>
	<?php echo $this->element('layout/contrato-anuncio_modal');?>

	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8">

			<?php 
				echo $this->Form->create('Pedido', 
					array('url'=>array('controller'=>'pedidos', 'action'=>'salvar_pedido'), 'role'=>'form'));
			?>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-4 col-md-6 col-md-offset-6">
					<?php
						# Parâmetros
						echo $this->Form->hidden('contato_id', array('value'=>$empresa_selecionada['Contato']['id']));
						echo $this->Form->hidden('pedido', array('value'=>$_pedido));
						echo $this->Form->hidden('status', array('value'=>1));

						echo $this->Form->button(__('Confirmar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg btn-block', 'data-loading-text'=>'Aguarde...'));
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-8 col-sm-offset-4 col-md-6 col-md-offset-6 text-right">
					<?php echo $this->Html->link('Alterar', 'javascript: history.go(-1);', array('class'=>'btn btn-link btn-lg')); ?>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>

		</div>
	</div>

<?php endif; ?>