<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): void
    {
        $this->render('homePage', [
            'title' => 'Home - Athletic Trainer'
        ]);
    }

    public function about(): void
    {
        $this->render('aboutUs', [
            'title' => 'About Us - Athletic Trainer'
        ]);
    }
}
