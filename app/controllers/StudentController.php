<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {

	public function index() {
		$this->call->view('student_home');
	}

	public function profile() {
		$student = [
			 'student_id'  => '2025-00065',
    		 'name'        => 'Kennelyn Escollar',
   			 'course'      => 'BS Information Technology',
   			 'year'        => '3rd Year',
    		 'section'     => 'F2',
   			 'email'       => 'escollarkennelyn@gmail.com',
   			 'address'     => 'Binaybay Sta Rosa 2 Baco',
    		 'contact'     => '0936-502-4136',
    		 'skills'      => 'PHP, Git, GitHub, Web Deployment',
             'hobbies'     => 'Reading, Coding, Listening to Music',
   		     'description' => 'A passionate BSIT student who enjoys building web applications and learning new technologies.',
             'facebook'    => 'https://facebook.com/Kennelyn Manalo Escollar',
             'github'      => 'https://github.com/kennebels-bit'
		];

		$this->call->view('student_profile', $student);
	}
}
?>