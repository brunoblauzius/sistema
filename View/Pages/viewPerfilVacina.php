
<div class="row">
	
	<div class="col-md-12">
		
		<?php if(count($vacinas) == 0 ): ?>
			<h4>Nenhum Registro foi encontrado...</h4>
		<?php else: ?>
			<div class="info-cont">
				<h3>Perfil: <?php echo $vacinas['Vacina']['nome'] ?></h3>
				<p><?php echo nl2br($vacinas['Vacina']['descricao']) ?></p>
			</div>
		<?php endif; ?>
	</div>

</div>