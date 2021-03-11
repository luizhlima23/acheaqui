<?php
	# Carrega arquivo de configuração do Google
	Configure::load('google');
	$ua_code = Configure::read('Google_analytics.code');
?>
<?php if($ua_code): ?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', '<?php echo $ua_code; ?>', 'auto');
	ga('send', 'pageview');
</script>
<?php endif; ?>