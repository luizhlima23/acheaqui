<?php echo $this->Html->css(array('bootstrap-social.css')); ?>

<?php if(isset($this->request->data)): ?>

<section>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<?php echo $this->Html->tag('h2', $this->request->data['Contato']['nome'], array('class'=>'page-header')); ?>

		</div>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
				
			<div class="filho">
				<p class="alert alert-danger text-left">
					<strong>Atenção: </strong>
					Após confirmar a desistência desta empresa, você não poderá mais gerencia-la e outras pessoas poderão reivindica-la.
				</p>
			</div>

		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">

			<?php echo $this->element('forms/form-desistir_empresa'); ?>

		</div>
	</div>

</section>

<?php endif; ?>