<?php 
	echo $this->Html->script(
		array('inline-autocomplete.js'), 
		array('block' => 'inlineScripts')
	);
?>

<style type="text/css">
	html, body{color:#FFF !important;
		
		background: linear-gradient(135deg, rgba(167,224,127,1) 0%, rgba(0,255,255,1) 100%);
	}
	.vertical-center{min-height:100%;min-height:100vh;}
</style>

<div class="container">
	<div id="homeBox" class="vertical-center">
		<div id="centerBox" class="container text-center">

			

			<!-- Busca inicial -->
			<div id="divBusca" class="row" class="text-center">
				<div class="formBusca col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<?php echo $this->element('forms/mainSearch'); ?>	
				</div>
			</div>

			<!-- Diversos -->
			<div id="divDiversos" class="row" class="text-center">
				<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
					<div class="row">
						<em>
							empresas, produtos, serviços, fones...
						</em>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>