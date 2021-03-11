<?php 
	$id = $dados['Contato']['id'];
	$display = $dados['Contato']['nome'];
	$options = array(
		'texto'=>'<i class="fa fa-ellipsis-v btn-icon_white"></i>',
		'class'=>'item-options',
		'caret'=>false
	);
	$ico_edit = '<i class="fa fa-pencil nav-icon"></i>';
	$ico_report = '<i class="fa fa-ban nav-icon"></i>';
	$ico_flag = '<i class="fa fa-flag nav-icon"></i>';
	$ico_close = '<i class="fa fa-window-close nav-icon"></i>';
	$ico_ban = '<i class="fa fa-ban nav-icon"></i>';
	$menu = array(
		$ico_edit.__('corrigir') => array(
			'tipo'=>'link', 
			'url'=>array('controller'=>'correcoes', 'action'=>'sugerir_correcao', 'contato_id'=>$id)
		),
		$ico_flag.__('reivindicar') => array(
			'tipo'=>'link', 
			'url'=>array('controller'=>'contatos', 'action'=>'reivindicar_empresa', 'id'=>$id)
		),
		$ico_ban.__('denunciar') => array(
			'tipo'=>'link', 
			'url'=>array('controller'=>'correcoes', 'action'=>'denunciar', 'contato_id'=>$id)
		),
		$ico_close.__('não existe') => array(
			'tipo'=>'link', 
			'url'=>array('controller'=>'correcoes', 'action'=>'informar_inexistencia', 'contato_id'=>$id)
		),
	);
?>
<style type="text/css">
	.item-options{
		margin-right:0px;
		font-size: 1.3em;
		padding:1px 5px;
	}
</style>
<div class="row modelo-1">
	
	<div class="col-xs-11 col-sm-10 col-md-10 col-lg-10">
		<div class="row">

			<!-- main col 1 -->
			<div class="col-xs-12 col-sm-6 col-md-5">
				<div class="row">

					<!-- Nome(xs, sm, md) -->
					<div class="col-xs-8 col-sm-8 col-md-8">
						<div class="row">
							<div id="nme" class="text-left">
								<?php
									$nome = $this->Formata->nome($dados['Contato']['nome']);
									$slug = (!empty($dados['Contato']['slug']))? $dados['Contato']['slug'] : $dados['Contato']['id'];
									echo $this->Html->link($nome,
										array('controller'=>'contatos', 'action'=>'empresa', 'var'=>$slug)
									);
								?>
							</div>
						</div>
					</div>

					<!-- Fone(xs, sm, md) -->
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="row">
							<div id="fne" class="text-center fne-xs-fix">
								<?php
									if(!empty($dados['Contato']['fone1'])){

										echo '<div>'.$this->Formata->fone($dados['Contato']['fone1']).'</div>';
									}
									else{

										$ico_sabe = '<span class="btn-icon_white label-sabe_fone"><i class="fa fa-phone"></i> sabe?</span>';
										echo $this->Html->link($ico_sabe,
											array('controller'=>'correcoes', 'action'=>'sugerir_telefone', 'contato_id'=>$dados['Contato']['id']),
											array('escape'=>false)
										);
									}
								?>
							</div>
						</div>
					</div>

				</div>
			</div>

			<!-- main col 2 -->
			<div class="col-xs-12 col-sm-6 col-md-7">
				<div class="row">

					<!-- Endereço(xs, sm, md) -->
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="row">
							<div id="end" class="text-left">
								<?php echo $this->Formata->endereco($dados['Contato']['end_completo']); ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		
		</div>
	</div>

	<div class="visible-xs">
		<?php echo $this->element('layout/btn-dropdown', array('options'=>$options, 'menu'=>$menu)); ?>
	</div>

	<div class="hidden-xs col-sm-2 col-md-2 col-lg-2">
		<div class="row">
			<?php echo $this->element('layout/btn-dropdown', array('options'=>$options, 'menu'=>$menu)); ?>
		</div>
	</div>

</div>