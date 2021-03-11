<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="correcoes index">
	
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

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<h2 class="page-header">
				Atualizações de empresas
			</h2>
		</div>
	</div>

	<section class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="panel panel-default">

				<?php echo $this->element('layout/crud/table-panel_head', array('filter'=>true)); ?>

				<?php echo $this->element('layout/filtros/filter_correcoes'); ?>

				<?php if( $this->request->is('mobile') ): ?>
				<div class="table-responsive">
				<?php endif;?>
					<table class="table table-striped table-bordered">
						<?php if(!empty($correcoes)): ?>
						<thead>					
							<tr>
								<th width="5%" class="text-center"><?php echo $this->Paginator->sort('id', __('#')); ?></th>
								<th><?php echo $this->Paginator->sort('User.nome', __('Usuário')); ?></th>
								<th><?php echo $this->Paginator->sort('acao', __('Ação')); ?></th>
								<th><?php echo $this->Paginator->sort('Data.Contato.nome', __('Empresa')); ?></th>
								<th width="10%" class="text-center"><?php echo $this->Paginator->sort('created', __('Data')); ?></th>
								<th width="10%" class="text-center"><?php echo $this->Paginator->sort('resultado', __('Resultado')); ?></th>
								<th width="5%" class="text-center"><?php echo __('Ações');?></th>
							</tr>
						</thead>
						<tbody class="searchable">
							<?php foreach ($correcoes as $d): ?>
							<tr>
								<td class="text-center"><?php echo h($d['Correcao']['id']); ?>&nbsp;</td>
								<td><?php echo h($d['User']['nome']); ?>&nbsp;</td>
								<td><?php echo h(Inflector::humanize($d['Correcao']['acao'])); ?>&nbsp;</td>
								<td><?php echo h($d['Data']['Contato']['nome']); ?>&nbsp;</td>
								<td class="text-center"><?php echo $this->Formatacao->data($d['Correcao']['created']); ?>&nbsp;</td>
								<td class="text-center">
								<?php
									$label_result = 'label-default';
									if($d['Correcao']['resultado'] == 'A') $label_result = 'label-success';
									if($d['Correcao']['resultado'] == 'R') $label_result = 'label-danger';
									if($d['Correcao']['resultado'] == 'AC') $label_result = 'label-warning';
									$opt_results = array('A'=>'Aprovado', 'R'=>'Reprovado', 'AC'=>'Aprovado com alterações');
									echo $this->Html->tag('span',
										$this->Formata->status_string($d['Correcao']['resultado'], $opt_results, 'Aguardando Análise'),
										array('class'=>'label '.$label_result)
									);
								?>
								</td>
								<td class="actions text-center">
								<?php
									$id = $d['Correcao']['id'];
									$display = $d['Data']['Contato']['nome'];
									$msg_excluir = __('Tem certeza de que deseja excluir: #%s - %s?', $id, $display);
									$options = array(
										'texto'=>'<i class="fa fa-bars"></i>&nbsp;&nbsp;',
										'class'=>'btn btn-xs btn-default dropdown-toggle',
									);
									$ico_list = '<i class="fa fa-search-plus nav-icon"></i>';
									$ico_edit = '<i class="fa fa-check-square-o nav-icon"></i>';
									$ico_trash = '<i class="fa fa-trash-o nav-icon"></i>';
									$menu = array(
										$ico_edit.__('Analisar') => array('tipo'=>'link', 'url'=>array('controller'=>'correcoes', 'action'=>'analisar_correcao', $id)),
										$ico_list.__('Visualizar') => array('tipo'=>'link', 'url'=>array('controller'=>'correcoes', 'action'=>'view', $id)),
										$ico_trash.__('Excluir') => array('tipo'=>'postlink', 'url'=>array('controller'=>'correcoes', 'action'=>'delete', $id), 'msg'=>$msg_excluir),
									);

									echo $this->element('layout/btn-dropdown', array('options'=>$options, 'menu'=>$menu));
								?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
						<?php else: ?>

							<tr>
								<td class="text-danger">Nenhum registro encontrado!</td>
							</tr>
						<?php endif; ?>
					</table>
				<?php if( $this->request->is('mobile') ): ?>
				</div>
				<?php endif;?>

			</div>
			
			<div class="text-center">
			<?php
				$pagination = array('info'=>true);
				echo $this->element('layout/pagination', array('options'=>$pagination));
			?>
			</div>

		</div>
	</section>

</div>