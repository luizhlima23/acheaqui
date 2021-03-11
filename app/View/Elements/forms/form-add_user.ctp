<?php 
	echo $this->Html->script(
		array('inline-input_mask.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->script(
		array('/js/inputmask/inputmask.js', '/js/inputmask/inputmask.date.extensions.js', '/js/inputmask/jquery.inputmask.js'), 
		array('block' => 'inlineScripts')
	);
?>

<div class="user form">

	<p class="pull-right">
		<strong style="color:red">*</strong>
		<small><i> Campos obrigatórios</i></small>
	</p>
	
	<?php echo $this->Form->create('User', array('url'=>array('controller'=>'users', 'action'=>'cadastro_usuario'))); ?>
		
		<!-- Nome -->
		<div class="row">
			<div class="form-group required col-md-3">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'placeholder' => 'Nome *', 'label'=>false));?>
			</div>
		</div>

		<!-- E-mail -->
		<div class="row">
			<div class="form-group required col-md-3">
				<?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'E-mail *', 'label'=>false));?>
			</div>
		</div>

		<!-- Data de nascimento -->
		<div class="row">
			<div class="form-group required col-md-3">
				<?php echo $this->Form->input('Cadastro.data_nascimento', array('class' => 'form-control date-mask', 'placeholder' => 'Data de nascimento *', 'label'=>false, 'type'=>'text'));?>
			</div>
		</div>

		<!-- Senha -->
		<div class="row">
			<div class="form-group required col-md-3 password">
				<?php echo $this->Form->input('password', array('id'=>'passwordfield', 'class' => 'form-control', 'placeholder' => 'Senha *', 'label'=>false));?>
				<i class="fa fa-eye show-icon"></i>
			</div>
		</div>

		<!-- Contrato -->
		<div class="row">
			<div class="form-group col-md-3 checkbox text-left" style="margin-left:20px;padding-top:0px;margin-top: 0px;margin-bottom: 0px">
				<label for="aceito_termos_de_uso" style="padding-left:0px;">
				<?php
					echo $this->Form->input('aceito_termos_de_uso',
						array(
							'id'=>'aceito_termos_de_uso',
							'type'=>'checkbox',
							'label'=>false,
							'hiddenField' => true,
							'div'=>true, 'class'=>'text-left',
							'value' => true,
						)
					);
				?>
					Li e concordo com os 
					<button type="button" class=" btn-link" data-toggle="modal" data-target="#ModalTermos">
						termos de uso
					</button>
				</label>
			</div>
		</div>
		<?php echo $this->element('layout/termos-uso_modal'); ?>

		<br>
		
		<?php echo $this->Form->button(__('Cadastrar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>
		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>

<?php echo $this->Html->script(array('inline-password_show'), array('block' => 'inlineScripts'));  ?>
<?php echo $this->Html->css(array('inline-password_show'), array('block' => 'inlineCss'));  ?>