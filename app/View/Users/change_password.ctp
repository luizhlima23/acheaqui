<?php if(isset($this->request->data['User']['hash'])) $hash = $this->request->data['User']['hash']; ?>

<?php $this->set('title_for_layout', __('Nova senha') ); ?>
<h2 class="page-header">Digite uma nova senha</h2>
<div class="row">
	<div class="col-md-4">
		<div class="users form">
			<?php echo $this->element('forms/form-change_password', array('hash'=>$hash)); ?>
		</div>
	</div>
</div>