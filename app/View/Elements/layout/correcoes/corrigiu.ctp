<?php 

	if(!$data_before['Contato'] or !is_array($data_before['Contato'])){

		$data_before['Contato'] = array();
	}
	
	if(!$data_after['Contato'] or !is_array($data_after['Contato'])){

		$data_after['Contato'] = array();
	}
	
	##############
	##	BEFORE 	##
	##############

	$e_before = array();

	# nome
	if(isset($data_before['Contato']['nome'])){

		if(!empty($data_before['Contato']['nome'])){

			$e_before['Nome'] = $this->Empresa->nome($data_before['Contato']['nome']);
		}
		else{

			$e_before['Nome'] = '';
		}
	}

	# fone
	if(isset($data_before['Contato']['fone1'])){

		if($data_before['Contato']['fone1']){

			$e_before['Telefone'] = $this->Empresa->fone($data_before['Contato']['fone1']);
		}
		else{

			$e_before['Telefone'] = '';
		}
	}

	# endereço 
	$endereco = $this->Empresa->endereco_completo($data_before, $logradouros, $bairros);
	if(!empty($endereco)){

		$e_before['Endereço'] = $endereco;
	}
	else{

		$e_before['Endereço'] = '';
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
							<?php
								if(isset($e_before[$field])){

									if(!empty($e_before[$field]) and !empty($val)){

										echo '<span class="text-muted">'.$e_before[$field].'</span>';
										echo '<br>'.$val;
									}
									else{
										
										echo $val;
									}
								}
								else{
									
								}
							?>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>

<?php endforeach; ?>
