<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 7/24/17
 * Time: 1:16 PM
 */

namespace app\Repository;


class UserAbstract
{

    public $model;

    public function __construct($model)
    {

        $this->model = $model;

    }

    public function find($id){

        return $this->model->find($id);
    }

    public function create($data){

        $user = $this->model->forceFill($data);
        $user->save();

        return $user;

    }

    public function update($id, $data){

        $user = $this->find($id);
        $user->forceFill($data);
        $user->save();

        return $user;

    }

    public function delete($id){



    }

    public function fromEmail($email){

        return $this->model->where('email', '=', $email)->first();
    }
}