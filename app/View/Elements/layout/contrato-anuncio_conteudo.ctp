<div id="termos_uso">

	<!-- CONTRATO -->
	<?php 
		if(isset($contrato)){
			
			echo $contrato;
		}
	?>

	<!-- ANEXO -->
	<?php if($anexo): ?>
		<div style="color: #000;">
			<br><br><br>
			<h3><strong>ANEXO</strong></h3>
			<br>
			<table class="table table-bordered">
				
				<thead>
					<tr>
						<th>SERVIÇOS CONTRATADOS</th>
						<th>VIGÊNCIA</th>
						<th>VALOR</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($servicos as $model=>$s): ?>
						<tr>
							<td class="text-left">
								<?php echo $s['servico_nome']; ?>
							</td>
							<td>
								<small>
								<?php echo $this->Formatacao->data($s['inicio']); ?>
								 à 
								<?php echo $this->Formatacao->data($s['fim']); ?>
								</small>
							</td>
							<td class="text-right">
								<?php echo $this->Formatacao->moeda($s['subtotal']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td class="text-right" colspan="3"><strong>Total: </strong><?php echo $this->Formatacao->moeda($total); ?></td>
					</tr>
				</tfoot>

			</table>
		</div>
	<?php endif; ?>

</div>

<!-- ToTop -->
<div id="toTop" style="display: none;">
	<span class="fa fa-chevron-up" style="font-size:30px"></span>
	<br>Topo &nbsp;
</div>