<div class="row modelo-3">
	
	<div class="col-sm-10 col-md-10">
		<div class="row">
			
			<!-- main col 1 -->
			<div class="col-xs-12 col-sm-6 col-md-5">
				<div class="row">

					<div class="col-xs-9 col-sm-8 col-md-8">
						
						<!-- Nome(xs, sm, md) -->
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
						
						<!-- Endereço(xs) -->
						<div class="row visible-xs">
							<div id="end" class="text-left">
								<?php echo $this->Formata->endereco($dados['Contato']['end_completo']); ?>
							</div>
						</div>

						<!-- Tags(sm, md) -->
						<?php if(isset($dados['Etiqueta']['tags_rel'])): ?>
						<div class="row hidden-xs">
							<div class="tags text-left">
								<?php echo $this->element('layout/contatos/modelo_tag', array('tags'=>$dados['Etiqueta']['tags_rel'], 'limite'=>10, 'id'=>$dados['Contato']['id'], 'nome'=>$dados['Contato']['nome'])); ?>
							</div>
						</div>
						<?php endif; ?>

					</div>

					<div class="col-xs-3 col-sm-4 col-md-4">
						<div class="row">
							
							<!-- Fone(xs, sm, md) -->
							<div id="fne" class="text-center fne-xs-fix">
								<?php echo $this->element('layout/contatos/modelo2_fne', array('fones'=>$dados['Contato'])); ?>
							</div>

							<!-- Ferramentas(xs) -->
							<div class="filho text-right visible-xs">
								<?php echo $this->element('layout/contatos/modelo_frm', array('slug'=>$slug)); ?>
							</div>

						</div>
					</div>

				</div>
			</div>

			<!-- main col 2 -->
			<div class="hidden-xs col-sm-6 col-md-7">
				<div class="row">

					<!-- Endereço(sm, md) -->
					<div class="col-sm-12 col-md-12">
						<div class="row">
							<div id="end" class="text-left">
								<?php echo $this->Formata->endereco($dados['Contato']['end_completo']); ?>
							</div>
						</div>
					</div>

					<!-- Banner(sm, md) -->
					<div class="col-sm-12 col-md-12">
						<div class="row">
							<?php
								echo $this->element('layout/contatos/banner', array('data'=>$dados['BannerA'], 'model'=>'BannerA'));
							?>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
	
	<div class="col-sm-2 col-md-2">
		<div class="row">
			
			<!-- Ferramentas(sm, md) -->
			<div id="frm" class="hidden-xs col-sm-12 col-md-12 text-right">
				<div class="row">
					<?php echo $this->element('layout/contatos/modelo_frm', array('slug'=>$slug)); ?>
				</div>
			</div>

			<!-- Tags(xs) -->
			<?php if(isset($dados['Etiqueta']['tags_rel'])): ?>
			<div class="visible-xs col-xs-12">
				<div class="row tags text-left">
					<?php echo $this->element('layout/contatos/modelo_tag', array('tags'=>$dados['Etiqueta']['tags_rel'], 'limite'=>10, 'id'=>$dados['Contato']['id'], 'nome'=>$dados['Contato']['nome'])); ?>
				</div>
			</div>
			<?php endif; ?>

			<!-- Banner(xs) -->
			<div class="col-xs-12 visible-xs">
				<div class="row">
					<?php
						echo $this->element('layout/contatos/banner', array('data'=>$dados['BannerA'], 'model'=>'BannerA'));
					?>
				</div>
			</div>

		</div>
	</div>

</div>