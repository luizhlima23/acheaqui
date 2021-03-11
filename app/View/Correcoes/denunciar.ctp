<style type="text/css">
	.empresa h3 {font-weight: bold; font-style: italic;color: #CCC;font-size:28px;letter-spacing: -1px !important;}
</style>

<div class="correcoes empresa">
	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<h2 class="page-header">
				<?php echo $this->request->data['Contato']['nome']; ?>
			</h2>

		</div>
			
		<div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">

			<h3>denunciar</h3>
			<br>
			<section id="form-correcao">
				<?php echo $this->element('forms/form-correcao_contato-denunciar'); ?>
			</section>

		</div>
	</div>
</div>