<?php 
	$placeholder = 'O que procura em Cristalina?';
	$value = (isset($q))? $q : null;
?>

<?php echo $this->Form->create('Contato', array('type' => 'GET', 'url'=>array('controller'=>'contatos', 'action'=>'pesquisa')) ); ?>
	
	<div class="col-xs-10 col-sm-10 col-md-10">
		<div class="row">
		<?php 
			echo $this->Form->input('q', array(
				'id'=>'inpBusca',
				'type'=>'text',
				'placeholder'=>$placeholder,
				'onfocus'=>"this.placeholder = ''",
				'onblur'=>"this.placeholder = '".$placeholder."'",
				'div'=>false,
				'label'=>false,
				'class'=>'formvaluesubmit text-left',
				'autocomplete'=>'off',
				'value'=>$value
			));
		?>
		</div>
	</div>
	<div class="col-xs-2 col-sm-2 col-md-2">
		<div class="row">
		<?php
			$img = $this->Html->image('layout/AONDE-site-ico-BUSCA.png', array('id'=>'icoBusca', 'width'=>'38px', 'height'=>'45px'));
			echo $this->Form->button($img, array(
				'type'=>'submit',
				'class'=>'btn-image pull-right',
				'id'=>'btnBusca'
			));
		?>
		</div>
	</div>

<?php echo $this->Form->end(); ?>
