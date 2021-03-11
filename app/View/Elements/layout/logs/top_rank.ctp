<table class="table table-bordered">
	<tr>
		<th>Nome:</th>
		<th class="text-center">Média:</th>
	</tr>
	<?php foreach($topPos as $val): ?>
	<tr>
		<td>
		<?php
			echo $this->Html->link($this->Formata->nome($val['Contato']['nome']),
				array(
					'controller'=>'contatos',
					'action'=>'view',
					$val['Contato']['id'],
					'plugin'=>false
				)
			);
		?>
		</td>
		<td class="text-center"><?php echo $val['Contato']['average_order_media'].'º'; ?></td>
	</tr>
	<?php endforeach; ?>
</table>