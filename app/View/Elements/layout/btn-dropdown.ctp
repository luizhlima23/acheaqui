<?php 
	
	# Texto
	if(!isset($options['texto']))
		$options['texto'] = 'Menu';

	# Classe do Botão
	if(!isset($options['class']))
		$options['class'] = 'btn btn-default btn-xs dropdown-toggle';

	# Caret
	$caret = '<span class="caret"></span>';
	if(!isset($options['caret'])) $options['caret'] = true;
?>
<div id="dropdown-actions" class="btn-group pull-right">
	<a href="#" class="<?php echo $options['class'];?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		<?php echo $options['texto'];?> <?php if($options['caret'] === true) echo $caret; ?>
	</a>
	<ul class="dropdown-menu">
		<?php foreach($menu as $titulo=>$d): ?>

			<li>
			<?php
				switch ($d['tipo']) {
					
					case 'postlink':
						echo $this->Form->postLink($titulo, $d['url'], array('escape'=>false), $d['msg']);
						break;
					
					default:
						echo $this->Html->link($titulo, $d['url'], array('escape'=>false));
						break;
				}
			?>				
			</li>

		<?php endforeach;?>
	</ul>
</div>
