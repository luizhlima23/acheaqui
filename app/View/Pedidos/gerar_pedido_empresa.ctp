<h3 class="page-header">Para qual das empresas abaixo?</h3>

<style type="text/css">
	.radio{margin-bottom: 0px;margin-top: 0px;}
	.lista .radio input[type="radio"]{
		visibility:hidden;
	} 
	.lista .radio label{
		margin-bottom: 5px;
		background: #EE3F23;
		color: #FFF;
		display: block;
		text-align: left;
		padding:20px;
		font-size: 18px;
		cursor: pointer;
	}
	.lista .radio label:hover{
		color: #FFF;
		background-color: #FF5135;
	}
	.lista .radio .disabled + label:hover{
		background: #E6E7E8; 
	}


 </style>
<?php if(isset($minhas_empresas)): ?>

	<?php
		# FORM do Pedido:
		echo $this->Form->create('Pedido', array('url'=>array('controller'=>'pedidos', 'action'=>'gerar_pedido'), 'role'=>'form'));
	?>
	
		<div class="col-md-12">
			<?php foreach($minhas_empresas as $k=>$e): ?>

				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4 lista">
						<div class="row">
						<?php
							$option = array(
								$k=>$e
							);
							$attributes = array(
								'div'=>false,
								'class' => '',
								'label' => true,
								'type' => 'radio',
								'default'=> null,
								'legend' => false,
								'before' => '<div class="radio">',
								'after' => '</div>',
								'separator' => false,
								'options' => $option,
								'hiddenField'=>false,
								'escape'=>false,
								'onclick'=>'this.form.submit();'
							);
							echo $this->Form->input('Pedido.contato_id', $attributes); 
						?>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
		</div>

		<?php 
			echo $this->Form->hidden('Pedido.pacote');
		?>

	<?php echo $this->Form->end(); ?>

<?php endif; ?>

<div class="col-md-12">
	<div class="row">
		<br>
		<?php 
			echo $this->Html->link('Cadastrar nova empresa',
				array('controller'=>'contatos', 'action'=>'cadastrar_empresa', 'option'=>'completo'),
				array('class'=>'text-muted')
			);
		?>
	</div>
</div>
