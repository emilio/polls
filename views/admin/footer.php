	<footer class="row admin-footer footer" role="contentinfo">
		<div class="span6 offset3">
			<?php if( IS_ADMIN ): ?>
				<a href="<?php echo Url::get('admin@logout') ?>" class="logout">Cerrar sesión</a>
			<?php endif; ?>
			<a href="<?php echo Url::get() ?>">Volver al inicio</a>
		</div>
	</footer>
</div>
	<script>
		window.adminAjaxUrl = <?php echo json_encode(Url::get('admin@edit', 'delete-answer') ); ?>;
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="<?php echo Url::asset('admin/js/script.js') ?>"></script>
</body>
</html>