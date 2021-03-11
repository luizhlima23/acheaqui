<?php echo $this->Html->css(array('inline-painel_admin.css')); ?>
<div class="users view">
	
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
	
	<?php if(!empty($user)): ?>

		<?php 
			$id = $user['User']['id'];
			$display = $user['User']['nome'];
		?>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<h2 class="page-header">
				<table width="100%">
					<tr>
						<td width="80%">
						<?php echo $display ?>
						</td>
						<td width="20%">
						</td>
					</tr>
				</table>
			</h2>
			<h3 class="page-subtitle">
				Mais detalhes
				<?php
					$msg_excluir = __('Tem certeza de que deseja excluir: #%s - %s?', $id, $display);
					$options = array(
						'texto'=>'<i class="fa fa-bars"></i>&nbsp;&nbsp;',
						'class'=>'btn btn-default dropdown-toggle',
					);
					$ico_role = '<i class="fa fa-key nav-icon"></i>';
					$menu = array(
						$ico_role.__('Alterar Função') => array('tipo'=>'link', 'url'=>array('controller'=>'users', 'action'=>'alterar_funcao', $id)),
					);

					echo $this->element('layout/btn-dropdown', array('options'=>$options, 'menu'=>$menu));
				 ?>
			</h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">

			<?php if( $this->request->is('mobile') ): ?>
			<div class="table-responsive">
			<?php endif;?>
				<table class="table table-striped table-bordered table-view">
					<tbody>
						<tr>
							<th><?php echo __('# ID'); ?></th>
							<td><?php echo h($user['User']['id']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Nome'); ?></th>
							<td><?php echo h($user['User']['nome']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Sobrenome'); ?></th>
							<td><?php echo h($user['User']['sbnome']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('CPF'); ?></th>
							<td><?php echo $this->Formata->cpf_cnpj($user['Cadastro']['cpf']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Telefone'); ?></th>
							<td><?php echo $this->Empresa->fone($user['Cadastro']['telefone']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Data de nascimento'); ?></th>
							<td><?php echo $this->Formatacao->data($user['Cadastro']['data_nascimento']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Sexo'); ?></th>
							<td><?php echo h($user['Cadastro']['sexo']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('E-mail'); ?></th>
							<td><?php echo h($user['User']['email']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Função'); ?></th>
							<td>
								<?php 
									echo $this->Html->link($user['Role']['name'],
										array('controller'=>'roles', 'action'=>'view', $user['Role']['id'])
									);
								?>
							</td>
						</tr>
						<tr>
							<th><?php echo __('Administrador?'); ?></th>
							<td><?php echo $this->Formata->status($user['User']['admin'], 2); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Status'); ?></th>
							<td>
							<?php
								$label_status = ($user['User']['status'])? 'label-default' : 'label-danger';
								echo $this->Html->tag('span',
									$this->Formata->status($user['User']['status']),
									array('class'=>'label '.$label_status)
								);
							?>								
							</td>
						</tr>
						<tr>
							<th><?php echo __('Criado'); ?></th>
							<td><?php echo $this->Formatacao->dataCompleta($user['User']['created']); ?></td>
						</tr>
						<tr>
							<th><?php echo __('Modificado'); ?></th>
							<td><?php echo $this->Formatacao->dataCompleta($user['User']['modified']); ?></td>
						</tr>
					</tbody>
				</table>
			<?php if( $this->request->is('mobile') ): ?>
			</div>
			<?php endif;?>

		</div>
	</div>

	<?php endif; ?>

</div>