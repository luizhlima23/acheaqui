<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>

</head>
<body>

	<div id="container">
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

		</div>
		<div id="footer">

		</div>
	</div>

    <!-- jQuery -->
	<?php //echo $this->Html->script(array('_jquery.js')); ?>
	<?php //echo $this->Js->writeBuffer(array('cache' => FALSE)); ?>


</body>
</html>
