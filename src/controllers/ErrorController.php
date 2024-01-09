<?php

namespace controllers;
use lib\Pages;
class ErrorController{
    public static function showErrorView(){
        $pages=new Pages();
        $pages->render('error/errorView');
    }
}