<table class="table table-bordered">
	<tr>
		<th colspan="2">Contatos:</th>
	</tr>
	<?php foreach($topContatos as $c): ?>
	<tr>
		<td>
		<?php
			echo $this->Html->link($this->Formata->nome($c['Contato']['nome']),
				array(
					'controller'=>'contatos',
					'action'=>'view',
					$c['Contato']['id'],
					'plugin'=>false
				)
			);
		?>
		</td>
		<td class="text-center"><?php echo $c['Contato']['views']; ?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<th colspan="2">Bairros:</th>
	</tr>
	<?php foreach($topBairros as $c): ?>
	<tr>
		<td>
		<?php
			echo $this->Html->link($c['Bairro']['nome'],
				array(
					'controller'=>'contatos',
					'action'=>'view',
					$c['Bairro']['id'],
					'plugin'=>false
				)
			);
		?>
		</td>
		<td class="text-center"><?php echo $c['Bairro']['views']; ?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<th colspan="2">Logradouros:</th>
	</tr>
	<?php foreach($topLogradouros as $c): ?>
	<tr>
		<td>
		<?php
			echo $this->Html->link($c['Logradouro']['logradouro'],
				array(
					'controller'=>'contatos',
					'action'=>'view',
					$c['Logradouro']['id'],
					'plugin'=>false
				)
			);
		?>
		</td>
		<td class="text-center"><?php echo $c['Logradouro']['views']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>