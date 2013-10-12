<?php

class ApiController extends BaseController {

	public function getPoll()
	{
		$pollID = Input::get('id');
		$poll = Poll::findOrFail($pollID);

		$choices = $poll->choices;

		// For each choice, total the responses
		$responseCount = array();

		foreach($choices as $choice)
		{
			$responseCount[$choice->id] = Choice::find($choice->id)->answers->count();
		}

		$poll['responses'] = $responseCount;

		return $poll;
	}

	public function getRecentPolls()
	{
		$count = Input::has('count') ? Input::get('count') : 10;

		$polls = Poll::orderBy('created_at', 'DESC')->where('is_public', '=', 1)->limit($count)->get();

		return $polls;	
	}

	public function postPoll()
	{
		$poll = new Poll;

		$poll->prompt = Input::get('prompt');
		$poll->is_public = Input::get('is_public') == 'true' ? 1 : 0; 

		// Validate the poll
		$pollValidator = Validator::make(
			$poll->toArray(),
			array('prompt' => 'required', 'is_public' => 'between:0,1|integer')
		);

		if($pollValidator->fails()) return Response::json($pollValidator->messages(), 400);

		// Validate choices
		foreach(Input::get('choices') as $choice)
		{
			// Validate the choice
			$choiceValidator = Validator::make(
				$choice,
				array('name' => 'required|max:12')
			);

			if($choiceValidator->fails()) return Response::json($choiceValidator->messages(), 400);
		}

		// Everything's correct, insert it.

		// Create the poll
		$poll->save();

		// Create the choices
		foreach(Input::get('choices') as $choice)
		{
			$newChoice = new Choice;
			$newChoice->name = $choice['name'];

			$poll->choices()->save($newChoice);
		}

		return $poll->id;
	}

	public function postAnswer()
	{

		$poll = Poll::findOrFail(Input::get('poll_id'));
		$choice = Choice::findOrFail(Input::get('choice_id'));

		$answer = new Answer;
		$answer->choice_id = $choice->id;
		$answer->poll_id = $poll->id;
		$answer->save();

		return "Ok";
	}

	public function postPhoneResponse()
	{
		// Expected format is poll:choice
		$posted = explode(":", Input::get('Body'));
	
		$poll = Poll::find($posted[0]);
		$choice = $poll->choices()->find($posted[1]);

		// Catch invalid responses
		if(is_null($poll) || is_null($choice)) return View::make('phone.error');

		$answer = new Answer;
		$answer->choice_id = $choice->id;
		$answer->poll_id = $poll->id;
		$answer->save();

		// Let them know all is good
		return View::make('phone.success')
			->with('answer', $answer);
	}

}
