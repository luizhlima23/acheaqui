<ul class="pagination">
<?php
	//First
	echo $this->Paginator->first(__('Primeira'), array('tag' => 'li'), null, array());

	//Prev
	if($this->Paginator->hasPrev()){
		echo $this->Paginator->prev(__('&laquo;'), array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
	}
	
	//Numbers
	echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
	
	//Next
	if($this->Paginator->hasNext()){
		echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
	}

	//Last
	echo $this->Paginator->last(__('Última'), array('tag' => 'li'), null, array());
?>
</ul>
<p class="col-md-12 text-muted">
<?php
	echo $this->Paginator->counter(
		array(
			'format' => __('Página %page% de %pages%, exibindo %current% registros de um total de %count%, exibindo do %start% até o %end%')
		)
	);
?>
</p>