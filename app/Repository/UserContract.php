<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 7/18/17
 * Time: 12:08 AM
 */

namespace App\Repository;


interface UserContract
{

    public function find($id);

    public function create($data);

    public function update($id, $data);

    public function delete($id);

    public function fromEmail($email);

}