<?php

namespace App\Services;

interface FieldOwnerServiceInterface
{
    function createBusiness(array $array);

    public function isOwnerRegistered($id);
}
