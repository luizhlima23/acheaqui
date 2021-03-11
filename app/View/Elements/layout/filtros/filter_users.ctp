<?php $collapse = 'collapse'; if(isset($this->request['data']['filter'])){	$collapse = '';	} ?>
<?php echo $this->Search->create(null, array('id'=>'filter-form', 'class'=>''.$collapse.'')); ?>
<div class="panel-body">

	<div class="row">

		<!-- Código -->
		<div class="form-group col-xs-4 col-sm-1 col-md-1 col-lg-1">
			<?php echo $this->Search->input('f_cod', array('class'=>'form-control', 'placeholder'=>'# ID', 'type'=>'text'));?>
		</div>

		<!-- Nome -->
		<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
			<?php echo $this->Search->input('f_name', array('class'=>'form-control', 'placeholder'=>'Nome', 'type'=>'text'));?>
		</div>

		<!-- Email -->
		<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
			<?php echo $this->Search->input('f_email', array('class'=>'form-control', 'type'=>'email', 'placeholder'=>'E-mail'));?>
		</div>

	</div>
	<div class="row">

		<!-- Função -->
		<div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<?php 
				echo $this->Search->input('f_role', 
					array('empty'=>':: Função','multiple' => false, 'class'=>'form-control', 'type'=>'select')
				);
			?>
		</div>

		<!-- Status -->
		<div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<?php 
				echo $this->Search->input('f_status', 
					array('empty'=>':: Status','multiple' => false, 'class'=>'form-control', 'type'=>'select')
				);
			?>
		</div>

	</div>
</div>
<div class="panel-footer">
	<?php echo $this->Search->button(__('Filtrar'), array('type'=>'submit','class'=>'btn btn-success bsubmit btn-responsive', 'value'=>'0', 'name'=>'action-form')); ?>
</div>
<?php echo $this->Search->end(null, true); ?>