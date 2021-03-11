<?php 
	if(isset($user_menus)){

		foreach ($user_menus as $menu) {

			echo $this->element('layout/panel-nav', array('menus'=>$menu));
		}
	}
?>