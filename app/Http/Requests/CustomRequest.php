<?php

namespace App\Http\Requests;

use Psr\Http\Message\ServerRequestInterface as Request;

interface CustomRequest
{
    public function validate(Request $request);
    public function authorize();
}