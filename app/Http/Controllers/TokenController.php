<?php

namespace App\Http\Controllers;

use App\Model\Client;
use App\Reponse\JsonResponse;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class TokenController extends Controller
{
    //

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function __invoke(Request $request){

        $this->validate($request, [
            'key' => 'required|max:255',
            'secret' => 'required|url',
            "username" =>'required|max:255',
            "password" => 'required|max:255'
        ]);



    }
}
