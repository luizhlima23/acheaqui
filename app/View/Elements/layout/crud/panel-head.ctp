<h3 class="panel-title">
	<span class="glyphicon glyphicon-list"></span>&nbsp;
	<div class="panel-buttons pull-right">

		<?php
			if(isset($quick_add)){
				if($quick_add AND !empty($quick_add)){
					echo $this->Html->link('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> '.__('Cadastro Rápido'), array('action'=>'quick_add'), array('escape'=>false, 'admin'=>false, 'plugin'=>false, 'class'=>'btn btn-xs btn-primary'));
				}
			}
		?>

		<?php
			if(isset($add)){
				if($add AND !empty($add)){
					echo $this->Html->link('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> '.__('Adicionar'), array('action'=>$add), array('escape'=>false, 'admin'=>false, 'plugin'=>false, 'class'=>'btn btn-xs btn-primary'));
				}
			}
		?>

		<?php 
			if(isset($filter)){
				if($filter):
				?>
					<a href="javascript:void(0)" data-toggle="collapse" data-target="#filter-form" title="Filtros avançados" class="btn btn-xs btn-success">
						<span class="glyphicon glyphicon-filter" aria-hidden="true"></span> <?php echo __('Filtros avançados');?>
					</a>
				<?php endif;
			}
		?>
		
	</div>
</h3>