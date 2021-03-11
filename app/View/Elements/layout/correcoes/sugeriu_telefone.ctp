<?php
	$cadastro = array(
		'telefone'=>'',
	);

	# fone
	if(isset($data['Contato']['fone1'])){

		if($data['Contato']['fone1']){

			$cadastro['telefone'] = $this->Empresa->fone($data['Contato']['fone1']);
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