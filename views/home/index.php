<section role="main" class="main-content">
	<h2>Todas las encuestas</h2>
	<ul>
		<?php foreach ($polls as $poll): ?>
			<li class="poll poll-<?= $poll->id ?>" id="poll-<?= $poll->id ?>">
				<a href="<?= Url::get('vote', $poll->id) ?>" title="<?= $poll->question ?>"><?= $poll->question ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>

<aside class="main-sidebar">
	<div class="aside-module most-module">
		<h2 class="aside-module-title">Encuestas con más respuestas</h2>
		<ul>
		<?php $mas_respondidas = Poll::query()->order_by('total_votes', 'DESC')->limit(5)->get(); ?>
		<?php foreach ($mas_respondidas as $poll): ?>
			<li class="poll poll-<?= $poll->id ?>" id="poll-<?= $poll->id ?>">
				<a href="<?= Url::get('vote', $poll->id) ?>" title="<?= $poll->question ?>"><?= $poll->question ?></a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<div class="aside-module author-module">
		<h2 class="aside-module-title">¿Quién hizo esto?</h2>
		<div class="module-content" itemscope itemtype="http://schema.org/Person">
			<img itemprop="image" src="//gravatar.com/avatar/87488b8b39dcff7dc6f34b062dbfce37/?s=100" alt="Emilio Cobos Álvarez" title="Emilio Cobos Álvarez">
			<p>Hola! Soy <a href="//emiliocobos.net" itemprop="name url" title="Emilio Cobos-CMC">Emilio Cobos</a>, un estudiante de Salamanca apasionado por el desarrollo y el diseño web.</p>
		</div>
	</div>
	<div class="aside-module how-module">
		<h2 class="aside-module-title">¿Cómo funciona?</h2>
		<div class="module-content">
			<p>Puedes ver la explicación <a href="http://emiliocobos.net/encuestas-php-mysq/" title="Crear encuestas con PHP y MySQL">aquí</a>. Es fácilmente customizable, y el código es perfectamente entendible.</p>
		</div>
	</div>
</aside>