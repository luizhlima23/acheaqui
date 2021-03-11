<ul class="list-unstyled">
	<?php foreach ($logs as $log): ?>
	<li class="<?php echo $this->Auditor->type($log['Logger']['type']);?>">
		<small>
			<?php
				echo $this->Formatacao->dataHora($log['Logger']['created']);
				echo ' / '.$log['Logger']['responsible_name'];
			?>
		</small>
		<br />
		<p>
			<?php echo $this->Auditor->type($log['Logger']['type']).' ('.$log['Logger']['model_alias'].'): '; ?>
			<?php
				echo $this->Html->link($log['Logger']['model_id'],
					array(
						'controller'=>'loggers',
						'action'=>'view',
						$log['Logger']['id'],
						'plugin'=>false
					)
				);
			?>
		</p>
	</li>
	<?php endforeach; ?>
</ul>
