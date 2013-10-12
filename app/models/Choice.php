<?php

class Choice extends Eloquent {

	public function poll()
	{
		return $this->hasOne('Poll');
	}

}
