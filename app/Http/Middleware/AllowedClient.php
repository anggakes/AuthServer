<?php

namespace App\Http\Middleware;

use App\Model\Client;
use App\Repository\ClientRepository;
use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AllowedClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $clientRepo = new ClientRepository();

        if(!$request->header('key') OR !$request->header('secret')) throw new UnauthorizedHttpException('', "key or secret not set");

        $client = $clientRepo->check($request->header('key'), $request->header('secret'));

        if(!$client) throw new UnauthorizedHttpException('', "key and secret not match");

        return $next($request);
    }
}
