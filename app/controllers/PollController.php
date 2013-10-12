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
		$poll->public = Input::get('public'); 

		// Validate the poll
		$pollValidator = Validator::make(
			$poll->toArray(),
			array('prompt' => 'required', 'public' => 'between:0,1')
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
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('polls.show');
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

	/**
	 * Return a sample json poll
	 *
	 * @return Response
	 */
	public function sample()
	{
		$poll = Poll::find(1);

		return Response::json($poll);
	}

}
