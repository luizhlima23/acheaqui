<?php echo $this->Form->create('Mensagen', array('url'=>array('controller'=>'mensagens', 'action'=>'contato')) ); ?>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-5 form-group">
			<?php 
				echo $this->Form->input('nome', 
					array('class' => 'form-control input-md', 'placeholder' => 'Nome', 'label'=>false)
				);
			?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-7 form-group">
			<?php echo $this->Form->input('email', array('class' => 'form-control input-md', 'placeholder' => 'E-mail', 'type'=>'email', 'label'=>false));?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 form-group">
			<?php echo $this->Form->input('mensagem', array('class' => 'form-control input-lg no-resize', 'placeholder' => 'Mensagem', 'label'=>false, 'type'=>'textarea'));?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 form-group">
			<?php 
				echo $this->Recaptcha->display(
					array(
						'lang'=>'pt-BR'
					)
				);
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 form-group">
			<?php
				echo $this->Form->button('Enviar Mensagem',
				array('type'=>'submit', 'id'=>'loadButton', 'class'=>'btn btn-block btn-primary btn-lg', 'escape'=>false, 'data-loading-text'=>'Aguarde...', 'autocomplete'=>'off'));
			?>
		</div>
	</div>

<?php echo $this->Form->end() ?>