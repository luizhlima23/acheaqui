
<?php
	// inline css
	echo $this->Html->css(
		array('/cropper/cropper.css', '/cropper/galeria_empresa.css'),
		array('block' => 'inlineCss')
	);
	// inline scripts
	echo $this->Html->script(
		array('/cropper/cropper.js', '/cropper/galeria_empresa.js'), 
		array('block' => 'inlineScripts')
	);
?>
<section id="sect-edit-galeria_empresa">
	
	<div class="form-group">
		<div class="row">
			<?php foreach($this->request->data as $k=>$data): ?>
			<div class="col-md-3">
				<?php echo $this->element('layout/cropper-galeria_empresa', array('k'=>$k, 'data'=>$data)); ?>
			</div>
			<?php endforeach;?>
		</div>
	</div>

</section>
