<?php 
	echo $this->Html->script(
		array('inline-input_mask.js', 'bootstrap-select.min.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('/js/inputmask/inputmask.js', '/js/inputmask/inputmask.date.extensions.js', '/js/inputmask/inputmask.phone.extensions.js', '/js/inputmask/jquery.inputmask.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->css(array('bootstrap-select', 'inline-painel_admin.css'), array('block' => 'inlineCss'));
?>
<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
	#tb-correcao{
		background: #e8e8e8;
	}
	#tb-correcao tr td{
		padding:10px 20px;
		line-height: 100%;
		border:1px solid #e8e8e8;
	}
	#tb-correcao tr td:first-child{
		font-size: 2em;
		border-right:1px solid #FFF;
	}
</style>

<div class="correcoes empresa">
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<?php if(isset($admin_menu) and !empty($admin_menu)): ?>
			<!-- Admin menu -->
			<section id="admin_nav-menu" class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php echo $this->element('layout/admin_nav-menu', array('menu'=>$admin_menu)); ?>
				</div>
			</section>
			<?php endif; ?>

		</div>
	</div>

	<!-- header -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2 class="page-header">
				<?php echo $data['Data']['Contato']['nome']; ?>
			</h2>
			<h3>analisar registro</h3>
		</div>
	</div>
	
	<!-- registro -->
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
			<br>
			<table id="tb-correcao" class="text-muted" width="100%">
				<tr>
					<td width="15%">
						<?php echo '#'.$data['Correcao']['id']; ?>
					</td>
					<td width="80%">
						<?php 
							echo '<strong>'.$data['User']['nome'].' '.$data['User']['sbnome'].'</strong>';
							echo ' (#'.$data['User']['id'].')';
							echo '<br><small>  <i>'.$this->Formatacao->dataCompleta($data['Correcao']['created']).'</i></small>';
						?>
						<a class="btn btn-xs btn-link_muted" role="button" data-toggle="collapse" href="#rawData" aria-expanded="false" aria-controls="rawData">
							mais <b class="fa fa-caret-down"></b>
						</a>
					</td>
				</tr>
			</table>
			<div class="collapse" id="rawData">
				<table class="table table-bordered bg-warning">
				<?php
					foreach ($data['Data']['Contato'] as $k=>$v) {
						echo '<tr>';
						echo '<th class="text-right">'.$k.'</th>';
						echo '<td>'.$v.'</td>';
						echo '</tr>';
					}
				?>
				</table>
			</div>
		</div>
	</div>
	
	<!-- alterações -->
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

			<br>
			<h4><?php echo Inflector::humanize($data['Correcao']['acao']).': ';?></h4>
			<?php
				switch ($data['Correcao']['acao']) {
					
					case 'cadastrou':

						$registro = (!empty($data['Correcao']['data_after']))? $data['Correcao']['data_after'] : $data['Correcao']['data'];
						echo $this->element('layout/correcoes/cadastrou', array('data'=>$registro));
						break;
					
					case 'reivindicou':

						$data['Correcao']['data']['Contato']['cargo_responsavel'] = $data['Correcao']['data_after']['Contato']['cargo_responsavel'];
						$data['Correcao']['data']['Contato']['razao_social'] = $data['Correcao']['data_after']['Contato']['razao_social'];
						$data['Correcao']['data']['Contato']['cpf_cnpj'] = $data['Correcao']['data_after']['Contato']['cpf_cnpj'];

						echo $this->element('layout/correcoes/reivindicou', array('data'=>$data['Correcao']['data']));
						break;
					
					case 'corrigiu':

						echo $this->element('layout/correcoes/corrigiu', 
							array(
								'data_before'=>$data['Correcao']['data_before'],
								'data_after'=>$data['Correcao']['data_after'],
							)
						);
						break;
					
					case 'sugeriu_telefone':
					
						echo $this->element('layout/correcoes/sugeriu_telefone', array('data'=>$data['Correcao']['data_after']));
						break;
					
					case 'informou_inexistencia':
					
						echo $this->element('layout/correcoes/informou_inexistencia', array('data'=>$data['Correcao']['data']));
						break;
					
					case 'denunciou':
					
						echo $this->element('layout/correcoes/informou_inexistencia', array('data'=>$data['Correcao']['data']));
						break;
					
					default:
						# code...
						break;
				}
			?>

		</div>
	</div>
	
	<!-- relacionadas -->
	<?php if(!empty($empresas_relacionadas)): ?>
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

			<br>
			<h4>Empresas relacionadas:</h4>

			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

				<?php foreach($empresas_relacionadas as $k=>$d): ?>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading<?php echo $k;?>">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $k;?>" aria-expanded="true" aria-controls="collapse<?php echo $k;?>">
									<?php echo $d['Contato']['nome'].' - #'.$d['Contato']['id']; ?>
								</a>
							</h4>
						</div>
						<div id="collapse<?php echo $k;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $k;?>">
							<div class="panel-body">
								<table class="table">
									<tr>
										<th>Telefone: </th>
										<td><?php echo $this->Formata->fone($d['Contato']['fone1']); ?></td>
									</tr>
									<tr>
										<th>Endereço Completo: </th>
										<td><?php echo $d['Contato']['end_completo']; ?></td>
									</tr>
									<tr>
										<th>Razão social / Responsável: </th>
										<td><?php echo $d['Contato']['razao_social']; ?></td>
									</tr>
									<tr>
										<th>CNPJ / CPF: </th>
										<td><?php echo $this->Formata->cpf_cnpj($d['Contato']['cpf_cnpj']); ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>

				<?php endforeach; ?>

			</div>

		</div>
	</div>
	<?php endif; ?>
	
	<!-- formulário de análise -->
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
			
			<br>
			<h4>Análise: </h4>
			<?php 
				echo $this->element('forms/form-analisar_correcao', 
					array(
						'data_before'=>$data['Correcao']['data_before'],
						'data_after'=>$data['Correcao']['data_after'],
					)
				); 
			?>

		</div>
	</div>

</div>