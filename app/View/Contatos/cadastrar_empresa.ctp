<h2 class="page-header">Qual o nome da empresa?</h2>

<!-- PESQUISA EMPRESA -->
<section class="row">
	<div class="col-md-12">

		<div class="contato form">
			<?php echo $this->Form->create('Pesquisa', array('url'=>array('controller'=>'contatos', 'action'=>'cadastrar_empresa', 'option'=>$option))); ?>
				<div class="row">
					<div class="form-group col-md-4">
						<?php echo $this->Form->input('pesquisa', array('class' => 'form-control input-lg', 'label' => false, 'placeholder'=>'digite aqui'));?>
					</div>
					<div class="form-group col-xs-12 col-sm-12 col-md-2">
					<?php echo $this->Form->button(__('Continuar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg btn-block', 'data-loading-text'=>'Aguarde...')); ?>
					</div>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>

	</div>
</section>

<?php if($this->request->data): ?>
<section>
	
	<?php if(isset($empresas)): ?>
	
		<?php if(!empty($empresas)): ?>

			<!-- Exibe Empresas e Form de Cadastro com Collapse -->
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-danger">
					<div class="panel-heading" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<span class="fa fa-info"></span>&nbsp;&nbsp;É uma destas abaixo?
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							<?php
								foreach($empresas as $d){

									if(is_null($d['Contato']['user_id'])){

										$btn = $this->Html->link('Reivindicar',
											array(
												'controller'=>'contatos', 'action'=>'reivindicar_empresa', 'id'=>$d['Contato']['id']
											),
											array(
												'class'=>'btn btn-info btn-block',
												'data-toggle'=>'tooltip', 'data-placement'=>'top',
												'title'=>'O responsável pela empresa pode alterar os dados de cadastro a qualquer momento no painel de controle.',
											)
										);
									}
									else{

										$btn = '<span class="text-muted">já possui dono</span>';
									}
									echo $this->element('layout/contatos/empresa_lista-button', array('dados'=>$d, 'btn'=>$btn));
								}
							?>
						</div>
					</div>
				</div>
				<br>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
						<h4 class="panel-title">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								<span class="fa fa-check"></span> Não, cadastrar uma nova
							</a>
						</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">

							<?php echo $this->element('forms/form-contato_cadastro_completo', array('option'=>$option)); ?>

						</div>
					</div>
				</div>
			</div>	

		<?php else: ?>

			<!-- Form de Cadastro -->
			<div class="col-md-12">
				<br>
				<div class="row">
					<?php echo $this->element('forms/form-contato_cadastro_completo', array('option'=>$option)); ?>
				</div>
			</div>

		<?php endif;?>

	<?php else: ?>
		
		<?php if(isset($this->request->data['Contato'])): ?>
			
			<!-- Exibe apenas Form de cadastro -->
			<div class="col-md-12">
				<br>
				<div class="row">
					<?php echo $this->element('forms/form-contato_cadastro_completo', array('option'=>$option)); ?>
				</div>
			</div>

		<?php endif;?>

	<?php endif;?>
	
</section>
<?php endif; ?>