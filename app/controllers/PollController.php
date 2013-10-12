<?php

class PollController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('polls.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('polls.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$poll = new Poll;

		$poll->prompt = Input::get('prompt');
		$poll->is_public = Input::get('is_public'); 

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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $poll = Poll::findOrFail($id);

        return View::make('polls.show')
        	->with('poll', $poll);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('polls.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}
