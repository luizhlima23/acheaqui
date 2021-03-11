<nav class="navbar navbar-default">
	<div class="container-fluid">

		<!-- Brand -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-admin_menu" aria-expanded="false">
				<span class="sr-only">Admin menu</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php 
				echo $this->Html->link(
					'<span class="fa fa-desktop"></span>&nbsp; Painel',
					array('controller'=>'dashboards', 'action'=>'index', 'plugin'=>false, 'admin'=>false),
					array('class'=>'navbar-brand', 'escape'=>false)
				);
			?>
		</div>

		<!-- nav links -->
		<div class="collapse navbar-collapse" id="nav-admin_menu">

			<!-- left -->
			<?php if(isset($menu['left'])): ?>
			<ul class="nav navbar-nav">
				<?php 
					foreach ($menu['left'] as $data) {
						

						if(isset($data['titulo'])){

							extract($data); // titulo, links

							echo '<li class="dropdown">';

								echo $this->Html->link(
									$titulo.'&nbsp;<span class="caret"></span>', 
									'javascript:void(0);', 
									array(
										'class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'role'=>'button',
										'aria-haspopup'=>'true', 'aria-expanded'=>'false', 'escape'=>false
									)
								);

								echo '<ul class="dropdown-menu">';
									foreach ($links as $li) {
										
										$e = each($li);

										if($e['key']=='divider'){

											echo '<li class="divider"></li>';
										}
										else{

											$link = $this->Html->link($e['key'], $e['value']);
											echo $this->Html->tag('li', $link);
										}
									}
								echo '</ul>';

							echo '</li>';
						}
						else{

							$e = each($data);

							$link = $this->Html->link($e['key'], $e['value']);
							echo $this->Html->tag('li', $link);
						}
					}
				?>
			</ul>
			<?php endif; ?>

			<!-- right -->
			<?php if(isset($menu['right'])): ?>
			<ul class="nav navbar-nav navbar-right">
				<?php 
					foreach ($menu['right'] as $data) {
						

						if(isset($data['titulo'])){

							extract($data); // titulo, links

							echo '<li class="dropdown">';

								echo $this->Html->link(
									$titulo.'&nbsp;<span class="caret"></span>', 
									'javascript:void(0);', 
									array(
										'class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'role'=>'button',
										'aria-haspopup'=>'true', 'aria-expanded'=>'false', 'escape'=>false
									)
								);

								echo '<ul class="dropdown-menu">';
									foreach ($links as $li) {
										
										$e = each($li);

										if($e['key']=='divider'){

											echo '<li class="divider"></li>';
										}
										else{

											$link = $this->Html->link($e['key'], $e['value']);
											echo $this->Html->tag('li', $link);
										}
									}
								echo '</ul>';

							echo '</li>';
						}
						else{

							$e = each($data);

							$link = $this->Html->link($e['key'], $e['value']);
							echo $this->Html->tag('li', $link);
						}
					}
				?>
			</ul>
			<?php endif; ?>

		</div>

	</div>
</nav>