<div class="contatos">
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			
			<br><br>
			<p>
				Sua colaboração é fundamental para o bom funcionamento do guia.
			</p>
			<br>
			<?php 
				echo $this->Html->link('Continuar',
					array('controller'=>'contatos', 'action'=>'home', 'plugin'=>false, 'admin'=>false),
					array('class'=>'btn btn-primary btn-lg')
				);
			?>

		</div>
	</div>

</div>