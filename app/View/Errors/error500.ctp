<?php echo $this->element('layout/erros/erro_500'); ?>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>