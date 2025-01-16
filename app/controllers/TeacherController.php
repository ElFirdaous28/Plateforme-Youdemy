<?php
class TeacherController extends BaseController
{

    public function __construct()
    {
    }
    public function dashboard(){
        $this->render('/teacher/dashboard');
    }
}
