<p class="text-center" style="background:white;padding:10px">
	<strong>Sucesso! O cadastro foi enviado para análise</strong>
</p>
<br />
<p class="text-center">
	<?php echo $this->Html->image('layout/AONDE-site-ico-SMILE.png', array('class'=>'responsive-img', 'width'=>'30px', 'height'=>'30px')); ?>
	<br />
	<strong>Obrigado por ajudar! <br />
	O guia fica melhor se você participa</strong>
</p>
<?php
	echo $this->Js->link('Cadastrar outra',
		array('action' => 'cadastro_estabelecimento', 'formulario'),
		array(
			'before' => $this->Js->get('#fom-cad_estabelecimento')->effect('fadeIn').$this->Js->get('#loading')->effect('fadeIn'),
			'success' => $this->Js->get('#loading')->effect('hide'),
			'update' => '.div-cad_estabelecimento',
			'class'=>'btn btn-block btn-aonde-primary',
			'escape'=>false
		)
	);
	echo $this->Html->script('jquery-2.1.1.min');
	echo $this->Js->writeBuffer(array('inline' => 'true'));
?>