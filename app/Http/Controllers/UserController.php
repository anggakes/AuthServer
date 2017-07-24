<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AllowedClient;
use App\Reponse\JsonResponse;
use App\Repository\ClientRepository;
use App\Repository\UserContract;
use Illuminate\Http\Request;
use Lcobucci\JWT\Builder;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\OAuth2\Server\CryptKey;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserController extends Controller
{
    //

    private $client;

    public function __construct(ClientRepository $client)
    {
        $this->middleware(AllowedClient::class);

        $this->client = $client;
    }

    public function register(Request $request){

        /** @var UserContract $repository */
        $repository = $this->client->getRepositoryObject($request->header('key'), $request->header('secret'));

        $this->validate($request,[
            'email' => 'required|email|max:255',
            'name' => 'required|max:255',
            'password' => 'required|max:255'
        ]);

        $data = $request->all();

        $data['password'] = bcrypt($data['password']);

        $user = $repository->create($data);

        return JsonResponse::success($user);


    }

    public function token(Request $request, HasherContract $hasher){

        /** @var UserContract $repository */
        $repository = $this->client->getRepositoryObject($request->header('key'), $request->header('secret'));

        // verification user
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ]);

        $user = $repository->fromEmail($request->email);

        if(!$hasher->check($request->password, $user->password)){
           return JsonResponse::badRequest("Kombinasi Username dan Password Salah");
        }

        // build JWT
        $token = (new Builder())
            ->setIssuer(config('app.name'))
            ->set('user', json_encode($user))
            ->sign(new Sha256(), new Key('file://'.storage_path('oauth-private.key')))
            ->getToken();


        return JsonResponse::success(['token' => (string) $token, 'user' => $user]);



    }

    public function refreshToken(Request $request){

    }

    public function update(Request $request){

    }

    public function revoked(Request $request){

    }


    /**
     * Generate a JWT from the access token
     *
     * @param CryptKey $privateKey
     *
     * @return string
     */
//    public function convertToJWT(CryptKey $privateKey)
//    {
//        return (new Builder())
//            ->setAudience($this->getClient()->getIdentifier())
//            ->setId($this->getIdentifier(), true)
//            ->setIssuedAt(time())
//            ->setNotBefore(time())
//            ->setExpiration($this->getExpiryDateTime()->getTimestamp())
//            ->setSubject($this->getUserIdentifier())
//            ->set('scopes', $this->getScopes())
//            ->sign(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase()))
//            ->getToken();
//    }


}
