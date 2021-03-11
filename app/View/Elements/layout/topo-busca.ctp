<?php 
	echo $this->Html->script(
		array('inline-autocomplete.js'), 
		array('block' => 'inlineScripts')
	);
?>



<!-- BUSCA -->
<div class="pai col-xs-10 col-sm-6 col-md-5" style="height:45px; width:500px;position: relative;
  ">
	
	<div class="row">
		<div class="filho">
			<div id="divInpBusca" class="formBusca col-xs-12 col-sm-12 col-md-12">
				<?php echo $this->element('forms/mainSearch', array('cache'=>false)); ?>
			</div>
		</div>
	</div>

</div>

<!-- FRM (xs, sm, md) -->
<div class="pai col-xs-2 col-sm-3 col-md-5" style="height:50px;">	
	<div class="row">
		
		<!-- MENU (sm, md) -->
		<div class="hidden-xs col-sm-12 col-md-12" style="height:50px;">
			<div class="row">
				<div class="text-left">
			
					<div class="pai col-sm-8 col-md-8" style="line-height: 110%;min-height: 50px">
						<div class="filho">
						<?php if($this->request->action === 'pesquisa'): ?>
							<!-- count -->
							<strong>
								<?php
									if(isset($this->request->params['paging']['Contato']['count'])){
										echo $this->request->params['paging']['Contato']['count'];
									}
									else{
										echo '0';
									}
								?>
							</strong>
							resultado(s), ordenados por </strong><strong>Relevância</strong>
						<?php endif; ?>
						</div>
					</div>

					<div class="pai col-sm-4 col-md-4" style="line-height: 110%;min-height: 50px">
						<div class="row filho">
							<!-- voltar -->
							<?php 
								$icon_back = '<i class="fa fa-chevron-left btn-icon_white btn-voltar" title="Voltar"></i>';
								echo $this->Html->link($icon_back, 'javascript: history.go(-1);', array('class'=>'pull-right', 'escape'=>false, 'id'=>'icon_back'));
							?>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- MENU (xs) -->
		<div class="col-xs-12 hidden-sm hidden-md hidden-lg fix-xs">
			<div class="row text-right">
				<div class="dropdown">
					<?php
						$imgMENU = '<i class="fa fa-chevron-left btn-icon_white btn-voltar" title="Voltar"></i>';
						echo $this->Html->link($imgMENU,
							'javascript: history.go(-1);',
							array('escape'=>false)
						);
						// $imgMENU = '<i class="fa fa-option-vertical"></i>';
						// echo $this->Html->link($imgMENU,
						// 	'javascript: void(0);',
						// 	array('escape'=>false, 'id'=>'dropdownMenu1', 'class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'aria-haspopup'=>'true', 'aria-expanded'=>'true', 'style'=>'color:#FFF;font-size:200%;')
						// );
					?>
					<!-- <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
						<li><a href="javascript: history.go(-1);">Voltar</a></li>
					</ul> -->
				</div>
			</div>
		</div>

	</div>
</div>