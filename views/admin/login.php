<div class="row">
	<div class="span4 offset4">
		<?php if( Param::get('loggedout') ): ?>
			<div class="alert alert-success">
				Has cerrado sesión
			</div>
		<?php endif; ?>
		<form action="<?php echo Url::get('admin@login') ?>" method="POST">
				<p><label for="admin_user">Usuario</label><input id="admin_user" name="admin_user" type="text"></p>
				<p><label for="admin_password">Contraseña</label><input id="admin_password" name="admin_password" type="password"></p>
				<p class="submit"><input type="submit" class="submit btn" name="submit" value="Entrar"></p>
				<?php if( Param::request('redirect-to') ): ?>
					<input type="hidden" name="redirect-to" value="<?php echo Param::request('redirect-to'); ?>">
				<?php endif; ?>
			<p class="password-lost"><a href="<?php echo Url::get('admin@password'); ?>">¿Has perdido la contraseña?</a></p>
		</form>
	</div>
</div>
