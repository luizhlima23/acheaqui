<?php echo $this->Html->script( array('printThis'), array('block' => 'inlineScripts')); ?>
<div class="modal fade" id="ModalTermos" tabindex="-1" role="dialog" aria-labelledby="ModalTermosLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="col-md-12 print-content">
					<?php echo $this->element('layout/termos-uso_conteudo'); ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" onclick="$('.print-content').printThis();"><b class="fa fa-print"></b> imprimir</button>
				<button type="button" class="btn btn-link" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>