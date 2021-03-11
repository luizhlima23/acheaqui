<?php
	$cadastro = array(
		'nome'=>'',
		'observacao'=>'',
	);

	# nome
	if(isset($data['Contato']['nome'])){

		if(!empty($data['Contato']['nome'])){

			$cadastro['nome'] = $this->Empresa->nome($data['Contato']['nome']);
		}
	}

	# observacao
	if(isset($data['Contato']['observacao'])){

		if(!empty($data['Contato']['observacao'])){

			$cadastro['observacao'] = $data['Contato']['observacao'];
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