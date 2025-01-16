<?php
class StudentController extends BaseController
{

    public function __construct()
    {
    }
    public function dashboard(){
        $this->render('/student/dashboard');
    }
}
