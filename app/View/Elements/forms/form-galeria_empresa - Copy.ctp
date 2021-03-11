<div class="role form">
	
	<?php echo $this->Form->create('ContatoImagem', array('role' => 'form', 'type'=>'file')); ?>
		
		<div class="row">
			<div class="form-group col-md-4">
				<h4>Capa</h4>
				<div class="dropzone" data-width="768" data-height="768" data-ajax="false" data-originalsave="true" data-resize="true" data-originalsize="false" data-download="true" data-canvas="true" data-editstart="false" data-button-edit="false" style="width:100%;" data-image="<?php //echo $img; ?>" >
					<?php
						echo $this->Form->input("ContatoImagem.0.imagem", 
							array(
								'type'=>'file',
								'multiple'=>'false',
								'label' => false,
								'div'=>false,
								'name'=>"imagem.0",
							)
						);
						echo $this->Form->hidden("ContatoImagem.0.id");
					?>
				</div>
			</div>
		</div>

		<h4>Mais fotos</h4>
		<div class="row">

			<?php 
				$count = 4; // nº de fotos por empresa + capa
				for ($i=1; $i < $count+1; $i++): 
			?>
			<div class="form-group col-xs-6 col-md-3">
				<div class="dropzone" data-width="768" data-height="768" data-ajax="false" data-originalsave="true" data-resize="true" data-originalsize="false" data-download="false" data-canvas="true" data-image="<?php //echo $img; ?>" data-editstart="false" data-button-edit="false" style="width:100%;">
					<?php
						echo $this->Form->input("ContatoImagem.$i.imagem",
							array(
								'type'=>'file',
								'multiple'=>'false',
								'label' => false,
								'div'=>false,
								'required'=>false,
								'name'=>"imagem.$i",
							)
						);
						echo $this->Form->hidden("ContatoImagem.$i.id");
					?>
				</div>
			</div>
			<?php endfor;?>

		</div>

		<br>
		
		<?php
			echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...'));
			
			echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link'));
		?>
		
	<?php echo $this->Form->end(); ?>
	<?php echo $this->fetch('postLink'); ?>

</div>