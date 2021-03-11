<?php 

	if(!$data_after['Contato'] or !is_array($data_after['Contato'])){

		$data_after['Contato'] = array();
	}
	

	##############
	##	AFTER 	##
	##############

	$e_after = array();

	# nome
	if(isset($data_after['Contato']['nome'])){

		$e_after['Nome'] = $this->Empresa->nome($data_after['Contato']['nome']);
	}

	# fone
	if(isset($data_after['Contato']['fone1'])){

		$e_after['Telefone'] = $this->Empresa->fone($data_after['Contato']['fone1']);
	}

	# endereço 
	$endereco = $this->Empresa->endereco_completo($data_after, $logradouros, $bairros);
	if(!empty($endereco)){

		$e_after['Endereço'] = $endereco;
	}

?>

<?php foreach ($e_after as $field => $val): ?>
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						
						<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
							<strong><?php echo $field; ?></strong>
						</div>
						<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
							<?php echo $val; ?>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>

<?php endforeach; ?>
