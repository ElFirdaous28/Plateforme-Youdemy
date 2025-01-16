<?php
class AdminController extends BaseController
{

    public function __construct()
    {
    }
    public function dashboard(){
        $this->render('/admin/dashboard');
    }
}
