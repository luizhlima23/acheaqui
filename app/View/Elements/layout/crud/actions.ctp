<?php

	//View
	if(isset($view) AND isset($id)){
		echo $this->Html->link('<span class="glyphicon glyphicon-search text-primary" aria-hidden="true" title="'.__("Ver mais").'"></span> ', array('action' => $view, $id), array('escape'=>false));	
	}

	//Edit
	if(isset($edit) AND isset($id)){
		echo $this->Html->link('<span class="glyphicon glyphicon-edit text-success" aria-hidden="true" title="'.__("Editar").'"></span> ', array('action' => $edit, $id), array('escape'=>false));
	}

	//Delete
	if(isset($delete) AND isset($id)){
		echo $this->Form->postLink('<span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" title="'.__("Excluir").'"></span> ', array('action' => $delete, $id), array('escape'=>false), __('Tem certeza de que deseja excluir # %s?', $nome));
		
}

?>
<?php if(isset($info) AND isset($id)): ?>
	<span class="glyphicon glyphicon-info-sign text-muted" aria-hidden="true" title="<?php echo '#'.$id; ?>"></span>
<?php endif; ?>