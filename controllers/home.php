<?php
class Home_Controller {
	public function action_index() {
		$GLOBALS['polls'] = Poll::all();
		View::make('home.index');
	}

	public function action_view($slug = null){
		if( ! $slug ) {
			return Redirect::to(Url::get(), 301);
		}
		
		if( ! $poll = $GLOBALS['poll'] = Poll::where('slug', '=', $slug)->first() ) {
			return Response::error(404);
		}
		$GLOBALS['answers'] = Answer::where('poll_id', '=', $poll->id)->get();

		View::make('home.view');
	}

	public function action_vote($id = null){
		if( ! $id ) {
			if( $_SERVER['REQUEST_METHOD'] !== 'POST') {
				return View::make('error.404');
			} else {
				$id = (int) Param::post('id');
				$answers = Param::post('answers');
				$poll = Poll::get($id);
				$poll->various_answers = '0' != $poll->various_answers;

				$cookiename = 'p_' . $poll->id . '_v';

				// Si no hay respuestas o hay más de una respuesta
				if( count($answers) === 0 || ( ! $poll->various_answers && count($answers) > 1)) {
					Redirect::to(Url::get('vote', $id, 'vote_error=true'));
				}
				if( Vote::where('voter_ip', '=', CURRENT_USER_IP)->and_where('poll_id' , '=', $id)->first() || Cookie::get($cookiename)) {
					Cookie::set($cookiename, ! $poll->various_answers ? (string) $answers[0]: 'true', 360);
					Redirect::to(Url::get('view', $poll->slug, 'poll_already_voted=true'));
				}
				Cookie::set($cookiename, ! $poll->various_answers ? (string) $answers[0]: 'true', 360);
				Vote::create(array(
					'voter_ip' => CURRENT_USER_IP,
					'poll_id' => $id,
					'answer_id' => ! $poll->various_answers ? $answers[0] : 0
				));

				foreach ($answers as $answer_id) {
					Answer::find($answer_id)->set(array(
						'nofilter:votes' => '`votes` + 1'
					));
				}
				Poll::find($id)->set(array(
					'nofilter:total_votes' => '`total_votes` + 1'
				));

				Redirect::to(Url::get('view', $poll->slug, 'voted=true'));
			}
		} elseif ( ! is_numeric($id) ) {
			return View::make('error.404');
		}

		$id = intval($id, 10);

		if( ! $poll = $GLOBALS['poll'] = Poll::get($id) ) {
			return Response::error(404);
		}
		$GLOBALS['answers'] = Answer::where('poll_id', '=', $poll->id)->get();

		View::make('vote');
	}
}