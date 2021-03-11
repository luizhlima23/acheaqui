<?php
	$controller = $this->request->params['controller'];
	$action = $this->request->params['action'];
	$request_url = array('controller'=>$controller, 'action'=>$action);
?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php foreach($menus as $title => $links): ?>
	<?php
		$collapse = '';
		$LI = '';

		# Verifica URL atual para ver se contém no collapse
		foreach ($links as $link => $url) {
			
			if(isset($url['controller']) and isset($url['action'])){


				if($controller == $url['controller'] and $action == $url['action']){
					$collapse = 'in';
					$LI .= '<li class="active">'.$this->Html->link($link, $url, array('escape'=>false)).'</li>';
				}
				else{

					$LI .= '<li>'.$this->Html->link($link, $url, array('escape'=>false)).'</li>';
				}
			}
			else{

				$LI .= '<li>'.$this->Html->link($link, $url, array('escape'=>false)).'</li>';
			}
		}
		$link_id = Inflector::slug(mb_strtolower($title));
	?>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading<?php echo $link_id;?>">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $link_id;?>" aria-expanded="true" aria-controls="<?php echo $link_id;?>">
					<?php echo h($title); ?>
				</a>
			</h4>
		</div>
		<div id="<?php echo $link_id;?>" class="panel-collapse collapse <?php echo $collapse; ?>" role="tabpanel" aria-labelledby="heading<?php echo $link_id;?>">
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<?php echo $LI; ?>
				</ul>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>