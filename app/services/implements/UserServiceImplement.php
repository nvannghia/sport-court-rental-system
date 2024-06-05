<?php 
namespace App\Services\Implements;
use App\Services\UserServiceInterface as UserServiceInterface;
use App\Repositories\UserRepositoryInterface as UserRepositoryInterface;

class UserServiceImplement implements UserServiceInterface {

    protected $userRepositoryInterface;
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }

    public function create(array $arrayCheck, array $arrayInsert){
        return $this->userRepositoryInterface->create($arrayCheck, $arrayInsert);
    }

    public function findByUsername($username){
        return $this->userRepositoryInterface->findByUsername($username);
    }

    public function login($username, $password)
    {
        return $this->userRepositoryInterface->login($username, $password);
    }

    public function getPasswordByUsername($username)
    {
        return $this->userRepositoryInterface->getPasswordByUsername($username);
    }
}
?>