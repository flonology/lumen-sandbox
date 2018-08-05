<?php
namespace App\Http\Controllers;

class LoginController extends Controller
{
  public function login()
  {
    return response()->json('this is login', 201);
  }
}
