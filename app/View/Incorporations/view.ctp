<?php echo $this->Html->css(array('bootstrap-social.css')); ?>


<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<h2 class="page-header"><?php echo $data['Incorporation']['description']; ?></h2>
	</div>
</div>

<?php if(!empty($data['Incorporation']['incorporation'])): ?>

	<!-- FACEBOOK - postagem principal -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php echo $data['Incorporation']['incorporation'];	?>	
		</div>
	</div>

<?php endif; ?>

<?php if(!empty($data['Incorporation']['url'])): ?>

	<!-- FACEBOOK - botões e página -->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<br><br>

			<!-- salvar  -->
			<div class="fb-save" data-uri="<?php echo $data['Incorporation']['url']; ?>" data-size="large"></div>

			<!-- enviar  -->
			<br><br>
			<div class="fb-send" data-href="<?php echo $data['Incorporation']['url']; ?>" data-size="small"></div>

		</div>
	</div>

<?php endif; ?>

<br><br>