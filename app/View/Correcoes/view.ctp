<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
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
			<h3>detalhes</h3>
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
	
	<!-- formulário de análise -->
	<div class="row">
		<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
			
			<br>
			<h4>Analise: </h4>
			<?php
				if(!is_null($data['Correcao']['resultado'])){

					switch ($data['Correcao']['resultado']) {
						
						case 'A':
							echo $this->Html->tag('p',
								'<strong>Aprovada!</strong><br>'.$data['Correcao']['motivo'],
								array('class'=>'alert alert-success')
							);
							break;
						
						case 'AC':
							echo $this->Html->tag('p',
								'<strong>Aprovada com alterações!</strong><br>'.$data['Correcao']['motivo'],
								array('class'=>'alert alert-warning')
							);
							break;
						
						case 'R':
							echo $this->Html->tag('p',
								'<strong>Reprovada!</strong><br>'.$data['Correcao']['motivo'],
								array('class'=>'alert alert-danger')
							);
							break;
						
						default:
							# code...
							break;
					}
				}
				else{

					echo $this->Html->tag('p', 'Em andamento!', array('class'=>'alert alert-info'));
				}
			?>

		</div>
	</div>

</div>