<?php

namespace App\Repositories;

interface FieldOwnerRepositoryInterface
{

    public function createBusiness(array $array);

    public function isOwnerRegistered($id);
    
}
