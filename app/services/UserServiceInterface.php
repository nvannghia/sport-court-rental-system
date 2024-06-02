<?php
namespace App\Services;

interface UserServiceInterface
{
    public function create(array $array);

    public function getUserById($id);

    public function getAllUser();
    
}
