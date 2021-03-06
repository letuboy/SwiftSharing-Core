<?php

class Controller_Ajax_Like extends Controller_Ajax {
	protected function _like_status() {
		$blab = Model_Blab::getById($_POST['thumbsup_id']);

		if (Model_Like::checkExists(Session::instance()->get('user_id'), $_POST['thumbsup_id'])) {
			return $this->json(array(
															'error' => 'You have already voted on this blab.',
															'likes' => $blab->likes
												 ));
		}

		if (!$blab) {
			return $this->json(array(
															'error' => 'That blab doesn\'t exist.',
															'likes' => 0
												 ));
		}

		$like = Model_Like::get_new();

		$like->mem_id = Session::instance()->get('user_id');
		$like->blab_id = $blab->id;
		$like->value = min(1, max(-1, (int)$_POST['thumbsup_rating']));

		if ($blab->type == "COMMENT") {
			$like->_type = "COMMENT";
			$like->_parent_id = $blab->id;
		}

		$like->save();
		$blab->likes += $like->value;
		$blab->save();

		$blab->deleteFromCache();

		return $this->json(array(
														'likes' => $blab->likes,
											 ));
	}

	protected function _like_album() {
		$collection = new Model_Collection($_POST['thumbsup_id']);

		if(!$collection) {
			return $this->json(array(
				                   'error' => "That collection doesn't exist.",
				                   'likes' => 0
			                   ));
		}

		$like = min(1, max(-1, (int)$_POST['thumbsup_rating']));

		$collection->likes += $like;
		$collection->save();

		return $this->json(array(
			                   'likes' => $collection->likes
		                   ));
	}

	public function action_index() {
		$this->_requireAuth();

		if (!isset($_POST['thumbsup_id']) || !isset($_POST['thumbsup_rating'])) {
			return false;
		}

		if ($_POST['thumbsup_type'] == "ALBUM") {
			return $this->_like_album();
		} else {
			return $this->_like_status();
		}
	}
}
