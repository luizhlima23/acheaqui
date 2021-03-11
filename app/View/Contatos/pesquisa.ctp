<style type="text/css">
	body{

		background: linear-gradient(135deg, rgba(167,224,127,1) 0%, rgba(0,255,255,1) 100%);
		
	}
	.div-conteudo{
		background: transparent;
	}
</style>
			
<div class="container" style="border-radius: 10px; margin-top: 25px; padding-top:10px; padding-bottom:10px; background: trasnparent;	 ">
	<div id="divResultados" class="col-xs-12 col-sm-12 col-md-12" style="background-color: #fff; padding-left:40px; padding-right:40px; padding-top:20px; padding-bottom:20px;border-radius: 10px">
		
		<!-- RESULTADOS -->	
		<?php if(!empty($empresas)): ?>
			
			<?php
				foreach($empresas as $d){

					$relevancia = $d['Contato']['relevancia'];

					switch (true) {

						case ($relevancia == 2 OR $relevancia == 3 OR $relevancia == 4):
							# PLANO tags, banner e ligue-gratis
							echo $this->element('layout/contatos/modelo3', array('dados'=>$d));
							break;
						
						case ($relevancia == 1):
							# PLANO apenas tags
							echo $this->element('layout/contatos/modelo2', array('dados'=>$d));
							break;
						
						default:
							# PLANO gratuito
							echo $this->element('layout/contatos/modelo1', array('dados'=>$d));
							break;
					}
				}
			?>

			<!-- PAGINAÇÃO -->	
			<?php if($this->request->params['paging']['Contato']['pageCount'] > 1): ?>
				<div class="row" style="border:1px; border-color:black">
					
					<?php 
						$pagination = array(
							'info'=>false,
							'first'=>true,
							'last'=>true,
							'prev'=>false,
							'next'=>false,
						);
						echo $this->element('layout/pagination', array('options'=>$pagination));
					?>
				</div>
			<?php endif; ?>
			
		<?php else: ?>
			
			<?php echo $this->element('layout/contatos/not_results'); ?>
		<?php endif; ?>
	</div>
</div>