<?php 
	$disabled_class = ''; 
	$disabled = false; 
?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 box-wrap">
		
		<!-- Titulo -->
		<div class="row titulo bkg-green">
			<table class="titulo_v" style="width: 100%;">
				<tr>
					<td class="text-left">
						02
					</td>
					<td class="text-left">
						BANNER<br>
						BÁSICO
					</td>
				</tr>
			</table>
		</div>
		
		<!-- Poder de Visualização -->
		<div class="row poder">
			<table class="poder_v" style="width: 100%;">
				<tr>
					<td class="text-left">
						Poder de<br>
						Visualização
					</td>
					<td class="text-left">
						médio
					</td>
				</tr>
			</table>
		</div>

		<!-- Descrição -->
		<div class="row descricao">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<p class="text-center">
					Aparece somente dentro do anúncio da sua empresa
				</p>
				<p class="text-center">
					Ideal para destacar sua empresa ou negócio entre outras que forem suas concorrentes diretas
				</p>
				<p class="text-center">
					<strong>DICA</strong> Use imagens e mensagens que atraiam o olhar do cliente, isso vale mais que destacar seu nome ou fone, lembre-se o cliente está em busca de produtos e serviços.
				</p>
			</div>
		</div>
		
		<!-- Vantagens -->
		<div class="row vantagens vantagens-green">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<ul>
					<li>Seu anúncio aparece primeiro que os gratuitos</li>
					<li>Use para demonstrar sua qualidade, produtos e serviços</li>
					<li><strong>Página Empresarial Exclusiva</strong> publique e altere as informações de seus anúncios</li>
				</ul>
			</div>
		</div>

		<!-- Bonus -->
		<div class="row selecao-orange">
			<table class="col-xs-12 col-sm-12 col-md-12">
				<tr>
					<td width="25%" class="text-center bonus-num">
						<strong>01</strong>
					</td>
					<td width="75%" class="text-left bonus-txt">
						<em><strong>PACOTE DE ETIQUETAS</strong><br>
						Grátis durante o plano</em>
					</td>
				</tr>
			</table>
		</div>
		
		<!-- Planos -->
		<div class="row planos">
			<?php
				$class_basico = ($dados['status']==0)? 'disabled' : $disabled_class;
				$disabled_basico = ($dados['status']==0)? true : $disabled;

				# Se esgotado!
				if($dados['disponivel'] == 0) echo $link_esgotado;

				foreach ($dados['Plano'] as $plano => $d) {
					
					if($d['status']){

						$titulo = $d['nome'];
						$descricao = $d['descricao'];
						$plano = array(
							$plano=>'<span class="radio-title"><strong>'.$titulo.' </strong></span>
										<span class="fa fa-star text-green title-ico"></span>
										<br>
										<span class="title-desc"><small>'.$descricao.'</small></span>');
						$attributes = array(
							'div'=>false,
							'class' => ''.$class_basico,
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
							'disabled'=>$disabled_basico
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
					<span class="fa fa-star text-green title-ico"></span>
					<br>
					Valores promocionais por tempo limitado
					<br>
					APROVEITE!
				</p>
			</div>
		</div>
		
		<!-- Selecao -->
		<div class="row selecao selecao-green text-center">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<p>selecione um plano</p>
			</div>
		</div>

	</div>
</div>