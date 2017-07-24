<?php

namespace App\Http\Controllers;

use App\Reponse\JsonResponse;
use App\Repository\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ClientController extends Controller
{

    protected $clients;


    protected $validation;


    public function __construct(ClientRepository $clients)
    {
        $this->clients = $clients;
    }



    public function store(Request $request)
    {


        try{
            $this->validate($request, [
                'name' => 'required|max:255',
                'redirect' => 'required|url',
                'repository' => 'required|max:255'
            ]);

            DB::beginTransaction();

            $client  = $this->clients->create(
                $request->name, $request->redirect, $request->repository
            );

            DB::commit();

            return JsonResponse::success($client);
        }
        catch (ValidationException $errorValidation){
            DB::rollback();

            return JsonResponse::validatitonError($errorValidation->validator);
        }
        catch (\Exception $e){

            DB::rollback();

            return JsonResponse::error(500, $e->getMessage());

        }

    }
}
