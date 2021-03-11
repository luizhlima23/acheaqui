<?php if(!empty($tags)): ?>

	<?php foreach($tags as $k=>$t):?>

		<h4><?php echo $k; ?></h4>
		<ul class="list-inline">
			<?php foreach($t as $k=>$v): ?>

				<li>
					<?php
						$tag = mb_strtolower($v['tag']);
						$link = $tag;
						$link_class = 'btn-link';
						$plano_id = $this->request->params['pass'][0];
						echo $this->Js->link($link,
							array('controller'=>'planos', 'action'=>'insert_tag', $plano_id, $tag),
							array('update'=>'#left-box', 'escape'=>false, 'class'=>$link_class)
						);
					?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endforeach; ?>

<?php else: ?>

	<p>Nenhum resultado encontrado</p>
<?php endif; ?>