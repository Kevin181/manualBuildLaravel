<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Container\Container;

class WelcomeController
{
    public function index() {
        $student = Student::first();
        $data = $student->getAttributes();
        $app = Container::getInstance();
        $factory = $app->make('view');
        // return sprintf('student id=%s; stdent name=%s;student age=%s.',
        //     $data['id'],
        //     $data['name'],
        //     $data['age']
        // );
        return $factory->make('welcome')->with('data', $data);
    }
}