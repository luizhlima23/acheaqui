<?php 
	echo $this->Html->script(
		array('bootstrap-select.min.js'), 
		array('block' => 'inlineScripts')
	);
	echo $this->Html->css(array('bootstrap-select'), array('block' => 'inlineCss'));
?>
<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
</style>

<div class="correcoes empresa">
	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<h2 class="page-header">
				<?php echo $this->request->data['Contato']['nome']; ?>
			</h2>
			
			<h3>sugerir correção</h3>
			<br>
			<section id="form-correcao">
				<?php echo $this->element('forms/form-correcao_contato'); ?>
			</section>

		</div>
	</div>
</div>