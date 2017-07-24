<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 7/22/17
 * Time: 11:55 PM
 */

namespace App\Repository;


use App\Model\Client;

class ClientRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new Client();

    }

    public function find($id){

        return $this->model->find($id);
    }

    public function create($name, $redirect, $repository){

        $client = $this->model->forceFill([
            'name' => $name,
            'secret' => str_random(40),
            'redirect' => $redirect,
            'key' => uniqid(),
            'repository' => $repository,
            'revoked' => false,
        ]);

        $client->save();

        return $client;

    }

    /**
     * Determine if the given client is revoked.
     *
     * @param  int  $id
     * @return bool
     */
    public function revoked($id)
    {
        $client = $this->find($id);

        return is_null($client) || $client->revoked;
    }

    public function update($id, $name, $redirect, $repository){

        $client = $this->model->find($id);

        $client->forceFill([
            'name' => $name, 'redirect' => $redirect, 'repository' => $repository
        ])->save();

        return $client;

    }

    public function delete($id){

        $this->model->forceFill(['revoked' => true])->save();

    }

    public function check($key, $secret){

        $a =  $this->model->where('key', '=', $key)->where("secret", '=', $secret)->first();

        return ($a) ? true : false;

    }

    public function getClientFromKeyAndScret($key, $secret){



        $client =  $this->model->where('key', '=', $key)->where("secret", '=', $secret)->first();

        return $client;

    }

    public function getRepositoryObject($key, $secret){

        $client = $this->getClientFromKeyAndScret($key, $secret);

        $class  = 'App\Repository\\'.$client->repository;

        return new $class();

    }

    public function fromKey($key){

        $this->model->where('key', '=', $key)->first();

    }

}