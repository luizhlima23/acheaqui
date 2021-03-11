<?php 
	$disabled_class = ''; 
	$disabled = false; 
?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 box-wrap">
		
		<!-- Titulo -->
		<div class="row titulo bkg-orange">
			<table class="titulo_v" style="width: 100%;">
				<tr>
					<td class="text-left">
						01
					</td>
					<td class="text-left">
						PACOTE DE<br>
						ETIQUETAS
					</td>
				</tr>
			</table>
		</div>
		
		<!-- Descrição -->
		<div class="row descricao">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<p class="text-center">
					São essenciais, pois é com o uso delas que sua empresa ou negócio será encontrado mais facilmente.
				</p>
				<p class="text-center">
					<strong>DICA</strong> Pense como seu cliente e cadastre etiquetas com as palavras ou termos que ele usaria na busca!
				</p>
			</div>
		</div>
		
		<!-- Vantagens -->
		<div class="row vantagens vantagens-orange">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<ul>
					<li>Seu anúncio aparece primeiro que os gratuitos</li>
					<li>Use para listar sua variedade de produtos e serviços</li>
					<li><strong>Página Empresarial Exclusiva</strong> publique e altere as informações de seus anúncios</li>
				</ul>
			</div>
		</div>
		
		<!-- Planos -->
		<div class="row planos">
			<?php
				$class_etiqueta = ($dados['status']==0)? 'disabled' : $disabled_class;
				$disabled_etiqueta = ($dados['status']==0)? true : $disabled;

				# Se esgotado!
				if($dados['disponivel'] == 0) echo $link_esgotado;

				foreach ($dados['Plano'] as $plano => $d) {

					if($d['status']){

						$titulo = $d['nome'];
						$descricao = $d['descricao'];
						$plano = array(
							$plano=>'<span class="radio-title"><strong>'.$titulo.' </strong></span>
										<span class="fa fa-star text-orange title-ico"></span>
										<br>
										<span class="title-desc"><small>'.$descricao.'</small></span>'
						);
						$attributes = array(
							'div'=>false,
							'class' => ''.$class_etiqueta,
							'label' => true,
							'type' => 'radio',
							'default'=> null,
							'legend' => false,
							'before' => '<div class="radio">',
							'after' => '</div>',
							'separator' => false,
							'options' => $plano,
							'hiddenField'=>false,
							'escape'=>false,
							'disabled'=>$disabled_etiqueta
						);
						echo $this->Form->input('pacote', $attributes); 
					}
				}
			?>
		</div>

		<!-- Rodapé -->
		<div class="row radape">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<p class="text-center">
					<span class="fa fa-star text-orange title-ico"></span>
					<br>
					Valores promocionais por tempo limitado
					<br>
					APROVEITE!
				</p>
			</div>
		</div>
		
		<!-- Selecao -->
		<div class="row selecao selecao-orange text-center">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<p>selecione um plano</p>
			</div>
		</div>

	</div>
</div>