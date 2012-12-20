<?php
	global $poll, $answers;
	$poll->total_votes = intval($poll->total_votes, 10);
	$voted_answer = Cookie::get('p_' . $poll->id . '_v');
	if( ! $voted_answer ) {
		$vote = Vote::where('voter_ip', '=', CURRENT_USER_IP)->and_where('poll_id', '=', (int) $poll->id)->first();
		if( $vote ) {
			$voted_answer = $vote->answer_id;
		}
		unset($vote);
	}
?>
<?php if( Param::get('poll_already_voted') == 'true' ) : ?>
	<div class="message message--error">
		Ya has votado esta encuesta en otra ocasión
	</div>
<?php endif; ?>
<?php if( Param::get('vote_error') == 'true' ) : ?>
	<div class="message message--error">
		Ha habido un error con tu voto: ¿Seguro que has escogido alguna respuesta?
	</div>
<?php endif; ?>
<?php if( Param::get('voted') == 'true' ) : ?>
	<div class="message message--success">
		Hey! Tu voto ha sido registrado correctamente.
	</div>
<?php endif; ?>

<div class="poll poll--single poll--view poll-<?= $poll->id ?>" id="poll-<?= $poll->id ?>">
	<h2 class="poll__title"><?= $poll->question ?></h2>
	<?php if( $poll->description ): ?>
		<p class="poll__description"><?= $poll->description ?></p>
	<?php endif; ?>
	<ul>
	<?php foreach ($answers as $answer): 
		if(  $poll->total_votes !== 0) {
			$percentage = intval($answer->votes, 10) / $poll->total_votes  * 100;
		} else {
			$percentage = 0;
		}

		$is_voted = $voted_answer == $answer->id;
	?>
	<li class="poll__answer poll__answer--view answer-<?= $answer->id ?>">
		<p><?= $answer->text ?> <span class="poll__answer__votes"><?= $answer->votes ?> votos</span></p>
		<div class="poll__answer__bar<?php if($is_voted) echo " poll__answer__bar--voted";?>" data-percent="<?php echo $percentage ?>" style="width: <?php echo $percentage ?>%"></div>
	</li>
	<?php endforeach; ?>
	<p class="poll__votes">Votos totales: <?= $poll->total_votes ?></p>
	<a class="button button--vote" href="<?= Url::get('vote', $poll->id) ?>" title="Votar">Votar</a>

	<a href="<?php echo Url::get() ?>">Volver al inicio</a>
	<?php if( IS_ADMIN ): ?>
		<a class="edit" href="<?= Url::get('admin@edit', $poll->id); ?>">Editar la encuesta</a>
	<?php endif; ?>
</div>