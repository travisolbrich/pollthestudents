<?php

class Poll extends Eloquent {

	public function choices()
	{
		return $this->hasMany('Choice');
	}

	public function answers()
	{
		return $this->hasMany('Answer');
	}
}
