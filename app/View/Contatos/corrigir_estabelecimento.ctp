<?php 
	$fields = array('nome', 'fone1', 'endereco_completo');
?>
<h2 class="page-header">Estabelecimento <small>Sugerir correção</small></h2>
<div class="row">
	<div class="col-md-9">
		<?php echo $this->element('forms/form-contato_correcao', array('fields'=>$fields)); ?>
	</div>
</div>