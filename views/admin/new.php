<div class="row">
	<div class="span8 offset2">
<h2>Nueva encuesta</h2>
<form action="<?php echo Url::get('admin@new'); ?>" method="POST">
	<p>
		<label for="question">Pregunta:</label>
		<input type="text" name="question" id="question" placeholder="¿Te gusta Justin Bieber?">
	</p>
	<p>
		<label for="slug">Slug (utilizado en la url):</label>
		<input type="text" name="slug" id="slug" placeholder="la-pregunta-es-una-broma">
	</p>
	<p>
		<label for="various_answers">¿Se pueden responder varias preguntas?</label>
		<select name="various_answers">
			<option value="0">No</option>
			<option value="1">Sí</option>
		</select>
	</p>
	<p>
		<label for="description">Descripción</label>
		<textarea name="description" id="description" placeholder="Encuesta sobre..."></textarea>
	</p>
	<div class="answers">
		<h3>Respuestas</h3>
		<ol class="answers-list">
			<!-- Prueba -->
			<li>
				<input type="text" name="new_answers[]" placeholder="Texto de la respuesta">
				<a class="btn btn-danger delete-new-answer" href="#">Eliminar</a>
			</li>
		</ol>
		<p>
			<a class="btn btn-success add-answer" href="#">Añadir una respuesta</a>
		</p>
	</div>
	<p class="submit">
		<input class="btn btn-primary" type="submit" value="Actualizar">
	</p>
</form>
</div>
</div>