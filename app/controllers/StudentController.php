<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller {

	public function index() {
		$this->call->view('student_home');
	}

	public function profile() {
		$student = [
			'student_id' => '2025-00065',
			'name'       => 'Kennelyn Escollar',
			'course'     => 'BSIT',
			'year'       => '3rd Year',
			'section'    => 'F2',
			'email'      => 'escollarkennelyn@gmail.com'
		];

		$this->call->view('student_profile', $student);
	}
}
?>