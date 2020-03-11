<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeUser extends Model
{
    const USER_ADMIN ='USER_ADMIN';
    const USER_REGULAR ='USER_REGULAR';

    public function isAdmin()
    {
        return $this->admin == User::USER_ADMIN;
    }
}
