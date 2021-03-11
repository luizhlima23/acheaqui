<?php
	for ($i=1; $i <= 4; $i++) {
		$fone = $this->Formata->fone($fones['fone'.$i]);
		if(!empty($fone)){
			echo ($i>1) ? '<br />' : null;
			echo $this->Formata->fone($fones['fone'.$i]);
		}
	}
?>