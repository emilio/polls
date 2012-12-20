<?php
	class Admin_Controller {
		public function action_index() {
			if( ! IS_ADMIN ) {
				Redirect::to(Url::get('admin@login', null, 'redirect-to=' . urlencode(Url::current())));
			}
			View::make('admin');
		}
		public function action_login() {
			if( IS_ADMIN ) {
				if( Param::request('redirect-to') ) {
					Redirect::to(Param::request('redirect-to'));
				}
				Redirect::to(Url::get('admin'));
			}

			$login_error = false;
			if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				if( Param::post('admin_user') === Config::get('admin.user') && Hash::check(Param::post('admin_password'), Config::get('admin.password')) ) {
					$_SESSION['admin_permissions'] = true;
					
					if( Param::request('redirect-to') ) {
						Redirect::to(Param::request('redirect-to'));
					}
					Redirect::to(Url::get('admin'));
				} else {
					$login_error = true;
				}
			}
			View::make('admin.login');
		}
		public function action_logout() {
			$_SESSION = array();
			session_destroy();
			Redirect::to(Url::get('admin@login', null, 'loggedout=true'));
		}

		public function action_password() {
			View::make('admin.password');
		}

		public function action_new($id = null) {
			if( $id ) {
					return Response::error(404);
			}
			if( $_SERVER['REQUEST_METHOD'] === 'POST' && Param::post('question')) {
				$pregunta = Param::post('question');
				$description = Param::post('description');
				$various_answers = Param::post('various_answers');
				$slug = Param::post('slug');
				$answers = Param::post('new_answers');

				if( empty($pregunta) || empty($description) || empty($slug) || count($answers) < 2) {
					Redirect::to(Url::get('admin', null, 'poll_creation_error=true'));
				}

				$poll_id = Poll::create(array(
					'question' => $pregunta,
					'description' => $description,
					'slug' => $slug,
					'various_answers' => $various_answers
				));

				foreach ($answers as $answer) {
					Answer::create(array(
						'poll_id' => $poll_id,
						'text' => $answer
					));
				}

				Redirect::to(Url::get('admin', null, 'success=' . $poll_id . '&created=true'));
			}
			View::make('admin.new');
		}
		public function action_edit($id = null) {
			if( ! IS_ADMIN ) {
				Redirect::to(Url::get('admin@login', null, 'redirect-to=' . urlencode(Url::current()) ));
			}

			if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				if( $id === 'delete-answer') {
					if( ( $answer_id = Param::post('answer_id') ) && is_numeric($answer_id)) {
						$answer = Answer::get( (int) $answer_id);
						Answer::find((int) $answer_id)->delete();
						$votes = Vote::where('answer_id', '=', $answer_id)->count();
						if( $votes ) {
							Poll::find($answer->poll_id)->set(array(
								'nofilter:total_votes' => "`total_votes` - $votes"
							));
						}
						return Response::json(array(
							'status' => 200,
							'deleted' => true							
						));
					} else {
						return Response::json(array(
							'status' => 0,
							'deleted' => false
						));
					}
				} elseif( $id ) {
					return Response::error(404);
				} else {
					$id = Param::post('id');
					if( $answer_id = Param::post('remove_answer') ) {
						Answer::find((int) $answer_id)->and_where('poll_id', '=', $id)->delete();
						$votes = Vote::where('answer_id', '=', $answer_id)->count();
						if( $votes ) {
							Poll::find($id)->set(array(
								'nofilter:total_votes' => "`total_votes` - $votes"
							));
						}
						Redirect::to(Url::get('admin@edit', $id, 'answer_deleted=true'));
					}

					if( Param::post('remove_poll') ) {
						Poll::find($id)->delete();
						Redirect::to(Url::get('admin', null, 'poll_deleted=true'));
					}

					if( is_numeric($id) && $poll = Poll::get((int) $id) ){
						foreach ($_POST as $key => $value) {
							if( isset($poll->{$key}) && (! empty($_POST[$key]) || $_POST[$key] === "0")) {
								$poll->{$key} = is_numeric($_POST[$key]) ? intval($_POST[$key], 10) : $_POST[$key];
							} elseif( false !== strpos($key, 'answer-') ) {
								$answer_id = explode('-', $key);
								$answer_id = $answer_id[1];
								if( is_numeric($answer_id) ) {
									Answer::find((int) $answer_id)->set(array(
										'text' => $value
									));
								}
							} elseif( $key === 'new_answers' ) {
								foreach ($value as $new_answer) {
									if( ! empty($new_answer) ) {
										Answer::create(array(
											'poll_id' => (int) $poll->id,
											'text' => $new_answer
										));
									}
								}
							}
						}
						Poll::save($poll);
						Redirect::to(Url::get('admin', null, 'success=' . $_POST['id'] . '&updated=true'));
					} else {
						return Response::error(500);
					}
				}
			}
			if( ! $id || ! is_numeric($id) || ! $poll = $GLOBALS['poll'] = Poll::get((int) $id)) {
				return Response::error(404);
			} else {
				$GLOBALS['answers'] = Answer::where('poll_id', '=', $poll->id)->get();
				View::make('admin.edit');
			}
		}
	}