<h2 class="page-header">Ok, informe seus dados abaixo</h2>

<?php if(isset($contato)): ?>
<section>
	<?php if(!empty($contato)): ?>
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="row">
			<div class="filho text-left">
				<strong>
					<?php echo $this->Formata->nome($contato['Contato']['nome']); ?>
				</strong>
			</div>
		</div>
		<div class="row">
			<div class="filho text-left">
				<?php echo $this->Formata->endereco($contato['Contato']['end_completo']); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="row">
			<br>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<span class="fa fa-check"></span> Dados necessários:
					</h4>
				</div>
				<div class="panel-body">

					<?php echo $this->element('forms/form-contato_reivindicar', array('id'=>$contato['Contato']['id'], 'cache'=>false)); ?>

				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>