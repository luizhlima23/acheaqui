<?php
	$id = $this->request->data['BannerA']['id'];

	# Imagem
	$url_imagem = $this->Upload->url($this->request->data, 'BannerA.imagem', array('style'=>'original'));
	$posicao = strpos($url_imagem, $this->webroot);
	$file = substr($url_imagem, $posicao+strlen($this->webroot)); 
?>

<div class="role form">

	<?php echo $this->Form->create('BannerA', array('role' => 'form', 'type'=>'file')); ?>
		
		<div class="row">
			<?php if(file_exists($file)): ?>
				
 				<div class="col-md-12">
					<?php 
						echo $this->Html->image('/'.$file, array('class'=>'responsive-img'));		
						echo '<br>';
						$icon_trash = 'Remover / Alterar';
						echo $this->Form->postLink($icon_trash, 
							array(
								'controller'=>'banners',
								'action'=>'delete_banner_basico_img',
								$id
							),
							array(
								'inline'=>false,
								'escape'=>false,
								'class'=>'btn btn-link btn-xs',
								'confirm'=>__('Tem certeza de que deseja excluir o banner?'),
							)
						);
					?>
					<br><br>
				</div>

			<?php else: ?>

				<div class="form-group required col-md-12">
					<?php
						echo $this->Form->input('imagem', 
							array(
								'type'=>'file',
								'multiple'=>'false',
								'label' => false
							)
						);
					?>
				</div>

			<?php endif; ?>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<?php 
					echo $this->Form->input('url_redirect', 
						array('class' => 'form-control', 'label' => 'Link do Banner', 'placeholder'=>'http://www.exemplo.com.br', 'value'=>null)
					);
				?>
			</div>
		</div>

		<!-- Parametros -->
		<?php echo $this->Form->hidden('id'); ?>

		<br>
		
		<?php
			echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...'));
								
			echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link'));
		?>
		
	<?php echo $this->Form->end(); ?>
	<?php echo $this->fetch('postLink'); ?>

</div>