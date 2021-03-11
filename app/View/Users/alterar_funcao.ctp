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
	
	<?php if(!empty($this->request->data)): ?>

		<?php 
			$id = $this->request->data['User']['id'];
			$display = $this->request->data['User']['nome'];
		?>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<h2 class="page-header">
				<table width="100%">
					<tr>
						<td width="80%">
						<?php echo $this->Html->link($display, array('controller'=>'users', 'action'=>'view', $id)); ?>
						</td>
						<td width="20%">
						</td>
					</tr>
				</table>
			</h2>
			<h3 class="page-subtitle">
				Alterar função
			</h3>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			
			<div class="well">
			<?php echo $this->Form->create('User', array('role' => 'form')); ?>

				<!-- Função do Usuário -->
				<div class="row">
					<div class="form-group col-md-4">
						<?php echo $this->Form->input('role_id', array('type'=>'select', 'class'=>'form-control','options' =>$roles,'label' =>'Nova Função') ); ?>
					</div>
				</div>

				<!-- Administrador? -->
				<div class="row">
					<div class="form-group col-md-4 checkbox" style="margin-left:22px">
						<label for="is_admin" style="padding-left:0px;" data-toggle="tooltip" data-placement="right" title="Os administrador tem acesso a um menu exclusivo da sua função de usuário.">
						<?php
							echo $this->Form->input('admin',
								array(
									'id'=>'is_admin',
									'type'=>'checkbox',
									'label'=>false,
									'hiddenField' => true,
									'div'=>false, 'class'=>'text-left',
									'value' => true,
								)
							);
						?>
						É um administrador?
						</label>
					</div>
				</div>

				<?php 
					# Configurações Padrões
					echo $this->Form->hidden('id');
				?>
				
				<br />

				<?php echo $this->Form->button(__('Alterar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

				<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>
		
			<?php echo $this->Form->end(); ?>
			</div>

		</div>
	</div>

	<?php endif; ?>

</div>