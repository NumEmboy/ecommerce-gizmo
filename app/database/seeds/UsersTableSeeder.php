<?php

class UsersTableSeeder extends Seeder {

	public function run() {
		$user = new User;
		$user->firstname = 'Yodme';
		$user->lastname = 'Alvarado';
		$user->email = 'bigEm021712@gmail.com';
		$user->password = Hash::make('secret123');
		$user->telephone = '09068380300';
		$user->admin = 1;
		$user->save();
	}
}