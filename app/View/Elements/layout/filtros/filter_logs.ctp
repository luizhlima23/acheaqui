<?php $collapse = 'collapse'; if(isset($this->request['data']['filter'])){	$collapse = '';	} ?>
<?php echo $this->Search->create(null, array('id'=>'filter-form', 'class'=>''.$collapse.'')); ?>
<div class="panel-body">
	<div class="row">
		
		<!-- # ID -->
		<div class="form-group col-xs-12 col-sm-3 col-md-2 col-lg-2">
			<?php 
				echo $this->Search->input('f_cod', 
					array('class'=>'form-control', 'type'=>'text', 'placeholder'=>'#')
				);
			?>
		</div>

		<!-- # ID do Responsável-->
		<div class="form-group col-xs-12 col-sm-3 col-md-2 col-lg-2">
			<?php 
				echo $this->Search->input('f_resp', 
					array('class'=>'form-control', 'type'=>'text', 'placeholder'=>'# ID do Responsável')
				);
			?>
		</div>

		<!-- TABELA -->
		<div class="form-group col-xs-12 col-sm-4 col-md-3 col-lg-3">
			<?php 
				echo $this->Search->input('f_tab', 
					array('class'=>'form-control', 'type'=>'text', 'placeholder'=>'Tabela')
				);
			?>
		</div>

		<!-- # ID DO REGISTRO NA TABELA -->
		<div class="form-group col-xs-12 col-sm-3 col-md-2 col-lg-2">
			<?php 
				echo $this->Search->input('f_mod', 
					array('class'=>'form-control', 'type'=>'text', 'placeholder'=>'# ID na Tabela')
				);
			?>
		</div>

		<!-- AÇÃO -->
		<div class="form-group col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<?php 
				echo $this->Search->input('f_act', 
					array('empty'=>':: Ação','multiple' => false, 'class'=>'form-control', 'type'=>'select')
				);
			?>
		</div>

	</div>
	<div class="row">
		<div class="col-md-12">
			<?php 
				$ico_filter = '<b class="fa fa-filter fa-1x"></b> ';
				echo $this->Search->button($ico_filter.__('Filtrar'), 
					array('type'=>'submit','class'=>'btn btn-primary', 'value'=>'0', 'name'=>'action-form')
				);
			?>
		</div>
	</div>
</div>
<div class="panel-footer">
</div>
<?php echo $this->Search->end(null, true); ?>