<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
	public function handle(Closure $next)
	{
		// Simple access condition for this laboratory activity
		$_SESSION['student_access'] = true;

		if (!isset($_SESSION['student_access']) || $_SESSION['student_access'] !== true) {
			redirect('student');
		}

		return $next();
	}
}
?>