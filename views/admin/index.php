<div class="row">
	<div class="span8 offset2">
		<?php if( $id = Param::get('success') ):
			$message = "La encuesta ha sido %s. <a href=\"%s\">Verla</a>"; ?>
			<div class="alert alert-success"><?php printf($message, Param::get('updated') == 'true' ? 'actualizada' : 'creada', Url::get('vote', $id)); ?></div>
		<?php endif; unset($id); unset($message) ?>
		<section class="span5 pull-left">
			<h2>Selecciona una encuesta</h2>
			<ul>
				<?php foreach (Poll::all() as $poll): ?>
					<li class="poll poll-<?php echo $poll->id ?>">
						<a href="<?php echo Url::get('admin@edit', $poll->id); ?>" title="<?php echo $poll->question ?>"><?php echo $poll->question ?></a></li>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	</div>
</div>