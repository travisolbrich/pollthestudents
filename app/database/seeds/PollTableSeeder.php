<?php

class PollTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('polls')->truncate();

		$poll = array(
			'prompt'=>'Who\'s got the coolest project?',
			'public'=>true
		);

		// Uncomment the below to run the seeder
		 DB::table('polls')->insert($poll);
	}

}
