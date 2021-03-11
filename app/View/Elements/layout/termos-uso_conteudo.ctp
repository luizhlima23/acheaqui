<?php echo $this->Html->css(array('inline-termos_uso.css')); ?>
<div id="termos_uso">

	<!-- TERMOS DE USO -->
	<?php 
		if(isset($termos_de_uso)){
			
			echo $termos_de_uso;
		}
	?>
		
	<!-- POLITICA DE PRIVACIDADE -->
	<?php 
		if(isset($politica_privacidade)){
			
			echo $politica_privacidade;
		}
	?>

</div>

<!-- ToTop -->
<div id="toTop" style="display: none;">
	<span class="fa fa-chevron-up" style="font-size:30px"></span>
	<br>Topo &nbsp;
</div>