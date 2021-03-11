<div class="contato form">

	<?php echo $this->Form->create('Contato', array('role' => 'form')); ?>
		
		<div class="row">
			<div class="form-group form-radio col-md-4">
			<?php
				echo $this->Form->input('Plano.banner',
					array('type'=>'checkbox', 'label'=>'Exibir Banner na Listagem', 'hiddenField' => false, 'div'=>false, 'class'=>'text-center', 'value' => true)
				);
			?>
			<br />
			<?php
				echo $this->Form->input('Plano.btligue',
					array('type'=>'checkbox', 'label'=>'Botão "Ligue Grátis"', 'hiddenField' => false, 'div'=>false, 'class'=>'text-center', 'value' => true)
				);
			?>
			</div>
		</div>

		<!-- Limite de Palavras Chave -->
		<div class="row">
			<div class="form-group col-md-3">
				<?php echo $this->Form->input('Plano.numtags', array('class' => 'form-control', 'label' => 'Limite de Palavras Chave', 'placeholder'=>false, 'type'=>'number'));?>
			</div>
		</div>

		<!-- Data de Vigência do Plano -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('Plano.inicio', array('type'=>'text', 'class'=>'form-control date-mask', 'label' => 'Data de Início', 'placeholder'=>'00/00/0000'));?>
			</div>
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('Plano.fim', array('type'=>'text', 'class'=>'form-control date-mask', 'label' => 'Fim', 'placeholder'=>'00/00/0000'));?>
			</div>
		</div>

		<!-- Situação -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('Plano.status', array('type'=>'select', 'class'=>'form-control','options' => array(1=>__('Ativado'), 0=>__('Desativado')),'label' =>__('Situação')) ); ?>
			</div>
		</div>

		<?php 
			# Configurações Padrões
			echo $this->Form->hidden('id');
			
			if($this->request->params['action'] == 'add'){

				echo $this->Form->hidden('Plano.contato_id', array('value'=>$contato_id));
			}
		?>

		<br />

		<?php echo $this->Form->button(__('Salvar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>


	<?php echo $this->Form->end(); ?>

</div>