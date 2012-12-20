<?php
$error = $new_pass = $user = null;
if( $user = Param::post('user') ) {
	if( $user === Config::get('admin.user') ) {
		if( Param::post('password') ) {
			if( Param::post('password') === Param::post('password_verification') ) {
				$new_pass = Hash::make(Param::post('password'));
			} else {
				$error = 'Las contraseñas no coinciden';
			}
		}
	} else {
		$error = sprintf('El usuario <strong>%s</strong> no existe en el sistema', $user);
	}
}?>
<div class="row">
	<div class="span4 offset4">
		<?php if( $new_pass ): ?>
			<div class="success new-password">
				<?php echo $new_pass ?>
			</div>
		<?php else: ?>
			<?php if( $error ): ?>
				<div class="alert alert-error"><?php echo $error ?></div>
			<?php endif; ?>
			<form action="<?php Url::get('admin@password'); ?>" method="post">
				<?php if( $user && ! $error ): ?>
					<p>
						<label for="password">Nueva contraseña</label>
						<input type="password" name="password" id="password">
					</p>
					<p>
						<label for="password_verification">Repítela</label>
						<input type="password" name="password_verification" id="password_verification">
					</p>
					<p class="submit">
						<input type="submit" value="Obtener">
						<input type="hidden" name="user" value="<?php echo $user ?>">
					</p>
				<?php else: ?>
					<p><label for="user">Introduce tu usuario</label>
						<input type="text" name="user" id="user">
					</p>
					<p class="submit">
						<input type="submit" value="Cambiar la contraseña">
					</p>
				<?php endif;?>
			</form>
		<?php endif;?>
	</div>
</div>