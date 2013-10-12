<?php

class Answer extends Eloquent {

	public function poll()
	{
		return $this->belongsTo('Poll');
	}

	public function choice()
	{
		return $this->belongsTo('choice');
	}

}
