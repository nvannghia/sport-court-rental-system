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

    public function create(array $array){
        return $this->userRepositoryInterface->create($array);
    }

    public function getUserById($id){
        return $this->userRepositoryInterface->getUserById($id);
    }

    public function getAllUser()
    {
        return $this->userRepositoryInterface->getAllUser();
    }
}
?>