<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 7/18/17
 * Time: 12:06 AM
 */

namespace App\Repository;


class Therapist extends UserAbstract  implements UserContract
{


    public function __construct()
    {
        $model = new \App\Model\Therapist();
        parent::__construct($model);
    }
}