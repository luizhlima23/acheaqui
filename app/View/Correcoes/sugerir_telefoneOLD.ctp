<?php 
	$fields = array('fone1');
?>
<h2 class="page-header">Estabelecimento <small>Sugerir Telefone</small></h2>
<div class="row">
	<div class="col-md-9">
		<p class="text-muted">
		<?php
			# Nome
			if(!empty($this->request->data['Contato']['nome'])){
				echo $this->Formata->nome($this->request->data['Contato']['nome']).'</br>';
			}
			
			# Telefone
			if(!empty($this->request->data['Contato']['fone1'])){
				echo $this->Formata->fone($this->request->data['Contato']['fone1']).'</br>';
			}

			# Endereço Completo
			if(!empty($this->request->data['Contato']['end_completo'])){
				echo $this->request->data['Contato']['end_completo'].'</br>';
			}
		?>
		</p>
		<?php echo $this->element('forms/form-contato_correcao', array('fields'=>$fields)); ?>
	</div>
</div>