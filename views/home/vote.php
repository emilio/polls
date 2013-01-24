<?php
	$poll->total_votes = intval($poll->total_votes, 10);

	if( $poll->various_answers == '1' ) {
		$input_type = "checkbox";
	} else {
		$input_type = "radio";
	}

?><?php if( Param::get('vote_error') ): ?>
<div class="message message--error">¿Has rellenado todos los campos?</div>
<?php endif; ?>

<div class="poll poll--single poll--vote poll-<?php echo $poll->id ?>" id="poll-<?php echo $poll->id ?>">
	<form action="<?php echo Url::get('vote') ?>" method="POST">
		<h2 class="poll__title"><?php echo $poll->question ?></h2>
		<?php if( $poll->description ): ?>
			<p class="poll__description"><?php echo $poll->description ?></p>
		<?php endif; ?>
		<ul>
		<?php foreach ($answers as $answer): ?>
			<li class="answer answer-<?php echo $answer->id ?> poll-<?php echo $poll->id ?>-answer-<?php echo $answer->poll_id ?>">
				<input type="<?php echo $input_type ?>" value="<?php echo $answer->id ?>" name="answers[]" id="answer-<?php echo $answer->id ?>"><label for="answer-<?php echo $answer->id ?>"><?php echo $answer->text ?></label>
			</li>
		<?php endforeach; ?>
		</ul>
	<p class="poll__votes">Votantes totales: <?php echo $poll->total_votes ?></p>
	<p class="vote">
		<a class="view" href="<?php echo Url::get('view', $poll->slug) ?>">Ver los resultados</a>
		<input type="submit" class="button button--vote" value="Enviar el voto">
		<input type="hidden" name="id" value="<?php echo $poll->id ?>">
	</p>
	</form>

	<?php if( IS_ADMIN ): ?>
		<a class="edit" href="<?php echo Url::get('admin@edit', $poll->id); ?>">Editar la encuesta</a>
	<?php endif; ?>

</div>