<style type="text/css">
	.avatar-no_picture{
		width: 100%;
		height: 100%;
		background: red;
		display: block;
		clear: both;
	}
	/* Esconde o input */
	.browse input[type='file'] {
		display: none
	}

	/* Aparência que terá o seletor de arquivo */
	.browse {
		width: 100% !important;
	}	
</style>
<?php 
	$pic_icon = '<span class="fa fa-picture-o"></span>';
	$avatar_src = (!empty($data['ContatoImagem']['imagem']))? WWW_ROOT.$data['ContatoImagem']['imagem'] : null;

	// imagem
	$id = $data['ContatoImagem']['id'];
	$img = $data['ContatoImagem']['imagem'];
	$ex = (file_exists(WWW_ROOT.$img) and !empty($img))? true : false;
	$img = (file_exists(WWW_ROOT.$img) and !empty($img))? $img : 'img/layout/none.png';
	$img_url = (!empty($img))? Router::url('/'.$img, true) : '';
?>
<div id="crop-avatar<?php echo $k;?>">

	<!-- Current item -->
	<?php if(!empty($img)): ?>
	<div class="avatar-view" title="Alterar imagem">
		<?php 
			echo $this->Html->image($img_url, array('alt'=>'selecione uma imagem'));
		?>
	</div>
		<?php if($ex): ?>
		<div class="text-center" style="padding:10px;">
			<?php
				$titulo = '<span class="fa fa-trash"></span> excluir';
				$url = array('controller'=>'uploads', 'action'=>'delete_imagem_empresa', $id);
				$msg = 'Tem certeza que deseja excluir esta imagem?';
				echo $this->Form->postLink($titulo, $url, array('escape'=>false, 'class'=>'text-muted'), $msg);
			?>
		</div>
		<?php endif; ?>
	<br>
	<?php endif; ?>
	

	<!-- Cropping modal -->
	<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				
				<!-- Form -->
				<?php
					$id = $data['ContatoImagem']['id'];
					$contato_id = $data['ContatoImagem']['contato_id'];
					$capa = ($k===0)? true : false;

					echo $this->Form->create('ContatoImagem', 
						array(
							'type'=>'file', 
							'url'=>array('controller'=>'uploads', 'action'=>'ajax_galeria_empresa'),
							'class'=>'avatar-form'
						)
					);
				?>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span class="fa fa-times"></span></button>
						<h4 class="modal-title" id="avatar-modal-label">Alterar Imagem</h4>
					</div>
					<div class="modal-body">
						<div class="avatar-body">

							<!-- Upload image and data -->
							<div class="avatar-upload">

								<input type="hidden" class="avatar-id" name="avatar_id" value="<?php echo $id; ?>">
								<input type="hidden" class="avatar-contato_id" name="avatar_contato_id" value="<?php echo $contato_id; ?>">
								<input type="hidden" class="avatar-capa" name="avatar_capa" value="<?php echo $capa; ?>">
								<input type="hidden" class="avatar-status" name="avatar_status" value="true">

								<input type="hidden" class="avatar-src" name="avatar_src">
								<input type="hidden" class="avatar-data" name="avatar_data">
								
								<label class="browse btn btn-lg btn-primary">
									<span class="fa fa-picture-o"></span>&nbsp;&nbsp;&nbsp;selecione uma imagem...
									<input type="file" class="avatar-input" id="avatarInput" name="avatar_file" accept="image/*">
								</label>

							</div>

							<!-- Crop and preview -->
							<div class="row">
								<div class="col-md-12">
									<div class="avatar-wrapper"></div>
								</div>
							</div>

							<div class="row avatar-btns">
								<div class="col-md-3 col-md-offset-9">
									<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
									<button type="submit" class="btn btn-primary btn-lg btn-block avatar-save">Concluir</button>
								</div>
							</div>

						</div>
					</div>
				</form>

			</div>
		</div>
	</div>

</div>