(function($){
	'use strict';
	$('[name="remove_answer"]').each(function(){
		$('label[for="' + this.id + '"]').remove();

		$(this).replaceWith($('<a>', {
			"href": "#",
			"class": "delete-answer btn btn-danger",
			"data-answer-id": this.value,
			"text": "Eliminar"
		}));
	});

	$('.delete-answer').on('click', function(e){
		var el = $(this);
		if( ! confirm('¿Estás seguro de querer eliminar esta respuesta?') ) {
			return;
		}
		e.preventDefault();
		$.ajax({
			url: window.adminAjaxUrl,
			type: "POST",
			data: {
				"answer_id": this.getAttribute('data-answer-id')
			},
			success: function() {
				el.parent().remove()
			}
		});
		el.parent().fadeOut(600)
	});

	$('.delete-new-answer').live('click', function(e){
		$(this).parent().remove()
		e.preventDefault();
	})

	$('.add-answer').on('click', function(e) {
		var el = $('<li>');
		el.append($('<input>', {
			type: "text",
			name: "new_answers[]"
		}))
		el.append($('<a>', {
			"class": "delete-new-answer btn-danger btn",
			"href": "#",
			"text": "Eliminar"

		}));
		$('.answers-list').append(el);
		e.preventDefault();
	})

	$('[name="remove_poll"]').on('click', function(e) {
		if( ! confirm('¿Estás seguro de querer eliminar esta respuesta?') ) {
			e.preventDefault();
			return;
		}
	})
})(window.jQuery);