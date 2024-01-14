<?php

namespace controllers;
use lib\Pages;
class ErrorController{
    /**
     * Muestra la vista de error
     * @return void
     */
    public static function showErrorView(){
        $pages=new Pages();
        $pages->render('error/errorView');
    }
}