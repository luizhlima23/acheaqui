<?php echo $this->Html->css(array('inline-minhasempresas.css')); ?>

<div class="contatos index">
	<div class="row">
		<div class="col-md-12">
			
			<h2 class="page-header">Minhas Empresas</h2>


			<section class="row minhas_empresas">
				<?php if(!empty($minhas_empresas)): ?>
					
					<?php foreach($minhas_empresas as $e): ?>
						
						<div class="col-xs-12 col-sm-6 col-md-4 empresa">
							<div class="col-md-12 e-title">
								<?php echo $e['Contato']['nome']; ?>
							</div>
							<div class="col-md-12 e-button">
								<div class="row">
								<?php
									if($e['Contato']['status']){

										echo $this->Html->link(
											'GERENCIAR',
											array(
												'controller'=>'contatos',
												'action'=>'gerenciar_empresa',
												'contato_id'=>$e['Contato']['id'],
											),
											array('class'=>'btn btn-default btn-block')
										);
									}
									else{

										echo $this->Html->link(
											'DESATIVADA',
											'javascript:void(0);',
											array('class'=>'btn btn-danger btn-block')
										);
									}
								?>
								</div>
							</div>
							<div class="col-md-12 e-alert" style="display: none;">
								Precisa de Atenção
							</div>
						</div>

					<?php endforeach; ?>

				<?php else: ?>

					<div class="col-xs-12 col-sm-12 col-md-12">
						<p>
							Nenhuma empresa encontrada! <br><br>
							<?php
								echo $this->Html->link('cadastrar minha empresa',
									array('controller'=>'contatos', 'action'=>'cadastrar_empresa'),
									array('class'=>'btn btn-primary ')
								);
							?>
						</p>
					</div>

				<?php endif; ?>
			</section>

		</div>
	</div>
</div>