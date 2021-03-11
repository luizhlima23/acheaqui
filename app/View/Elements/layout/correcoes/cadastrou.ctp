<?php
	$cadastro = array(
		'nome'=>'',
		'telefone'=>'',
		'endereco'=>'',
		'razao_social'=>'',
		'cpf_cnpj'=>'',
		'cargo_responsavel'=>'',
	);

	# nome
	if(isset($data['Contato']['nome'])){

		if(!empty($data['Contato']['nome'])){

			$cadastro['nome'] = $this->Empresa->nome($data['Contato']['nome']);
		}
	}

	# fone
	if(isset($data['Contato']['fone1'])){

		if($data['Contato']['fone1']){

			$cadastro['telefone'] = $this->Empresa->fone($data['Contato']['fone1']);
		}
	}

	# endereço 
	$endereco_completo = $this->Empresa->endereco_completo($data, $logradouros, $bairros);
	if(!empty($endereco_completo)){

		$cadastro['endereco'] = $endereco_completo;
	}
	
	# Razão social
	if(isset($data['Contato']['razao_social'])){

		if($data['Contato']['razao_social']){

			$cadastro['razao_social'] = $data['Contato']['razao_social'];
		}
	}

	# CPF / CNPJ
	if(isset($data['Contato']['cpf_cnpj'])){

		if($data['Contato']['cpf_cnpj']){

			$cadastro['cpf_cnpj'] = $data['Contato']['cpf_cnpj'];
		}
	}

	# Cargo
	if(isset($data['Contato']['cargo_responsavel'])){

		if($data['Contato']['cargo_responsavel']){

			$cadastro['cargo_responsavel'] = $data['Contato']['cargo_responsavel'];
		}
	}

?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		
		<?php if( $this->request->is('mobile') ): ?>
		<div class="table-responsive">
		<?php endif;?>
			<table class="table table-bordered">
			<?php 
				foreach ($cadastro as $field => $value) {
					
					echo '<tr>';
						echo '<th>'.Inflector::humanize($field).': </th>';
						echo '<td>'.$value.'</td>';
					echo '</tr>';

				}
			?>
			</table>
		<?php if( $this->request->is('mobile') ): ?>
		</div>
		<?php endif;?>

	</div>
</div>