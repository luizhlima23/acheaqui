<div class="correcao form">

	<?php echo $this->Form->create('Correcao', array('role' => 'form')); ?>
		
		<?php if(in_array('nome', $fields)): ?>
		<!-- Nome -->
		<div class="row">
			<div class="form-group col-md-6">
				<?php echo $this->Form->input('n_nome', array('class' => 'form-control', 'label' => 'Titulo', 'placeholder'=>'Nome do estabelecimento ou negócio'));?>
			</div>
		</div>
		<?php endif; ?>

		<?php if(in_array('fone1', $fields)): ?>
		<!-- Telefone -->
		<div class="row">
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('n_fone1', array('class' => 'form-control phone-mask', 'label' => 'Telefone', 'placeholder'=>'somente números'));?>
			</div>
		</div>
		<?php endif; ?>

		<?php if(in_array('endereco_completo', $fields)): ?>
		<!-- Endereço -->
		<div class="row">
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('n_logradouro_id', array('class' => 'form-control', 'label' => 'Logradouro', 'empty'=>'(Escolha um)', 'multiple'=>false, 'options'=>$logradouros));?>
			</div>
			<div class="form-group col-md-2">
				<?php echo $this->Form->input('n_end_num', array('class' => 'form-control', 'label' => 'Número'));?>
			</div>
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('n_end_comp', array('class' => 'form-control', 'label' => 'Complemento', 'placeholder'=>'ex.: Qd x Apt x'));?>
			</div>
		</div>

		<!-- localização -->
		<div class="row">
			<div class="form-group col-md-3">
				<?php echo $this->Form->input('n_bairro_id', array('class' => 'form-control', 'label' => 'Bairro', 'empty'=>'(Escolha um)', 'multiple'=>false, 'options'=>$bairros));?>
			</div>
			<div class="form-group col-md-4">
				<?php echo $this->Form->input('n_end_ref', array('class' => 'form-control', 'label' => 'Referência', 'placeholder'=>'ex.: próximo ao hospital municipal'));?>
			</div>
		</div>
		<?php endif; ?>

		<?php 
			# Configurações Padrões
			if(isset($this->request->data['Contato'])){

				echo $this->Form->hidden('Correcao.contato_id', array('value'=>$this->request->data['Contato']['id']));
				echo $this->Form->hidden('Correcao.nome', array('value'=>$this->request->data['Contato']['nome']));
				echo $this->Form->hidden('Correcao.fone1', array('value'=>$this->request->data['Contato']['fone1']));
				echo $this->Form->hidden('Correcao.end_completo', array('value'=>$this->request->data['Contato']['end_completo']));
			}
		?>

		<br />

		<?php echo $this->Form->button(__('Enviar'), array('id'=>'loadButton', 'type'=>'submit', 'class'=>'btn btn-primary btn-lg', 'data-loading-text'=>'Aguarde...')); ?>

		<?php echo $this->Html->link('Cancelar', 'javascript:window.history.go(-1);', array('class'=>'btn btn-link')); ?>

	<?php echo $this->Form->end(); ?>

</div>
