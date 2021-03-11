<div class="dropdown">
	<button class="select-aonde-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		Ordenados por
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
		<li>
			<?php echo $this->Paginator->sort('nome', 'a > z', array('direction' => 'asc', 'lock'=>true)); ?>
		</li>
		<li>
			<?php echo $this->Paginator->sort('nome', 'z > a', array('direction' => 'desc', 'lock'=>true)); ?>
		</li>
	</ul>
</div>


		<!-- ORDEM -->
		<div class="pai col-sm-9 col-md-8 hidden-xs" style="height:70px;">
			<div class="filho">
				<div class="row">
					<?php //echo $this->element('layout/topo-ordem'); ?>
				</div>
			</div>
		</div>