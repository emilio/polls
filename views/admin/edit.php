<?php global $poll, $answers; ?>
<div class="row">
	<div class="span8 offset2">
<h2>Editar la encuesta: "<?=$poll->question?>"</h2>
<?php if( Param::get('answer_deleted') === 'true' ): ?>
	<div class="alert alert-success">La respuesta ha sido eliminada correctamente</div>
<?php endif; ?>
<form action="<?php echo Url::get('admin@edit'); ?>" method="POST">
	<p>
		<label for="question">Pregunta:</label>
		<input type="text" name="question" id="question" value="<?php echo $poll->question ?>" placeholder="¿Te gusta Justin Bieber?">
	</p>
	<p>
		<label for="slug">Slug (utilizado en la url):</label>
		<input type="text" name="slug" id="slug" value="<?php echo $poll->slug ?>" placeholder="NO-te-gusta-justin-bieber">
	</p>
	<p>
		<label for="various_answers">¿Se pueden responder varias preguntas?</label>
		<select name="various_answers">
			<option value="0">No</option>
			<option<?php if( $poll->various_answers == 1 ) echo " selected"; ?> value="1">Sí</option>
		</select>
	</p>
	<p>
		<label for="description">Descripción</label>
		<textarea name="description" id="description"><?php echo $poll->description ?></textarea>
	</p>
	<div class="answers">
		<h3>Respuestas</h3>
		<ol class="answers-list">
			<?php foreach ($answers as $answer): ?>
				<li>
					<input type="text" name="answer-<?php echo $answer->id?>" id="answer-<?php echo $answer->id?>" value="<?php echo $answer->text ?>">
					<input type="submit" name="remove_answer" value="<?php echo $answer->id ?>" id="remove-answer-<?php echo $answer->id ?>"><label class="btn btn-danger" for="remove-answer-<?php echo $answer->id ?>">Eliminar</label>
				</li>
			<?php endforeach; ?>
			<!-- Prueba -->
				<li>
					<input type="text" name="new_answers[]" placeholder="Texto de la respuesta">
					<a class="btn btn-danger delete-new-answer" href="#">Eliminar</a>
				</li>
		</ol>
		<p>
			<a class="btn btn-success add-answer" href="#">Añadir una pregunta</a>
		</p>
	</div>
	<p class="submit">
		<input class="btn btn-primary" type="submit" value="Actualizar">
		<input type="submit" class="btn btn-warning" name="remove_poll" value="Borrar encuesta">
		<input type="hidden" name="id" value="<?php echo $poll->id ?>">
	</p>
</form>
</div>
</div>