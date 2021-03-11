<?php if(isset($dados)): ?>

	<style type="text/css">
		.lista_hr-sep{
			padding-top:10px;
			padding-bottom:10px;
			margin:5px 2px;
			border-bottom: 0px dashed #CCC;
		}
		.lista_hr-sep:hover{
			background-color: #f3f3f3;
		}
	</style>

	<div class="row lista_hr-sep">
		<div class="col-xs-12 col-sm-12 col-md-12">
			
			<div class="col-xs-12 col-sm-9 col-md-9 pai">
				<div class="row">

					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="row">
							<div class="filho text-left">
								<strong><?php echo $this->Formata->nome($dados['Contato']['nome']); ?></strong>
							</div>
						</div>
						<div class="row">
							<div class="filho text-left">
								<?php echo $this->Formata->endereco($dados['Contato']['end_completo']); ?><br />
							</div>
						</div>
					</div>
					
				</div>
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3 pai">
				<div class="row text-right">

					<?php
						if(isset($btn)){

							echo $btn;
						}
					?>
					
				</div>
			</div>
			
		</div>
	</div>

<?php endif; ?>