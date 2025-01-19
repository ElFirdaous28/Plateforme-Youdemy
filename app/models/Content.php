<?php
require_once(__DIR__ . '/../config/db.php');

abstract class Content extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    abstract public function addContent($contentData);
    abstract public function getContent($contentId);
}