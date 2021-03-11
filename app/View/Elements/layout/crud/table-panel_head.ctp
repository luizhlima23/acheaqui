<div class="panel-heading ">
	<div class="row">
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 pull-left">
			<h3 class="panel-title pull-left" style="padding-top: 7.5px;"><i class="fa fa-list text-muted"></i></h3>
		</div>
		<div class="col-sm-6 col-sm-offset-4 col-md-6 col-lg-6 hidden-xs">
			<form class="form-inline pull-right">
				<div class="form-group">
					<input id="filter_table" type="text" class="form-control input-sm" placeholder="Filtro rápido...">
				</div>
				<?php
					if(isset($filter)){
						if($filter):
						?>
							<a href="javascript:void(0)" data-toggle="collapse" data-target="#filter-form" title="avançado" class="btn btn-link btn-sm">
								<span class="glyphicon glyphicon-filter" aria-hidden="true"></span> <?php echo __('avançado');?>
							</a>
						<?php endif;
					}
				?>
			</form>
		</div>
	</div>
</div>