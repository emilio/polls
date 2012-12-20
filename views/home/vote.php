<?php
	global $poll, $answers;

	$poll->total_votes = intval($poll->total_votes, 10);

	if( $poll->various_answers == '1' ) {
		$input_type = "checkbox";
	} else {
		$input_type = "radio";
	}

?><?php if( Param::get('vote_error') ): ?>
<div class="message message--error">¿Has rellenado todos los campos?</div>
<?php endif; ?>

<div class="poll poll--single poll--vote poll-<?= $poll->id ?>" id="poll-<?= $poll->id ?>">
	<form action="<?= Url::get('vote') ?>" method="POST">
		<h2 class="poll__title"><?= $poll->question ?></h2>
		<?php if( $poll->description ): ?>
			<p class="poll__description"><?= $poll->description ?></p>
		<?php endif; ?>
		<ul>
		<?php foreach ($answers as $answer): ?>
			<li class="answer answer-<?= $answer->id ?> poll-<?= $poll->id ?>-answer-<?= $answer->poll_id ?>">
				<input type="<?= $input_type ?>" value="<?= $answer->id ?>" name="answers[]" id="answer-<?= $answer->id ?>"><label for="answer-<?= $answer->id ?>"><?= $answer->text ?></label>
			</li>
		<?php endforeach; ?>
		</ul>
	<p class="poll__votes">Votantes totales: <?= $poll->total_votes ?></p>
	<p class="vote">
		<a class="view" href="<?= Url::get('view', $poll->slug) ?>">Ver los resultados</a>
		<input type="submit" class="button button--vote" value="Enviar el voto">
		<input type="hidden" name="id" value="<?= $poll->id ?>">
	</p>
	</form>

	<?php if( IS_ADMIN ): ?>
		<a class="edit" href="<?= Url::get('admin@edit', $poll->id); ?>">Editar la encuesta</a>
	<?php endif; ?>

</div>