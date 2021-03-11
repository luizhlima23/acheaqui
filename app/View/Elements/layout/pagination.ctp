<?php
	$padrao = array(
		'info'=>false,
		'first'=>true,
		'last'=>true,
		'prev'=>false,
		'next'=>false,
	);
	$p = (isset($options))? array_merge($padrao, $options) : $padrao;
?>
<?php if($p['info']): ?>
	<p class="text-muted">
		<?php
		echo $this->Paginator->counter(
			array(
				'format' => __('Página %page% de %pages%, exibindo %current% registros de um total de %count%, exibindo do %start% até o %end%')
			)
		);
		?>
	</p>
<?php endif; ?>
<ul class="pagination pagination-lg">
<?php
	//First
	if($p['first']){
		echo $this->Paginator->first(__('&laquo;'), array('tag' => 'li', 'escape'=>false, 'title'=>__('Primeira')), null, array());
	}

	//Prev
	if($this->Paginator->hasPrev() and $p['prev']){
		//echo $this->Paginator->prev(__('<'), array('tag' => 'li', 'escape' => false), array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
	}
	
	//Numbers
	echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
	
	//Next
	if($this->Paginator->hasNext() and $p['next']){
		//echo $this->Paginator->next('>', array('tag' => 'li', 'escape' => false), array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
	}

	//Last
	if($p['last']){
		echo $this->Paginator->last(__('&raquo;'), array('tag' => 'li', 'escape'=>false, 'title'=>__('Última')), null, array());
	}
?>
</ul>
