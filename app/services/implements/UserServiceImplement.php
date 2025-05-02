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

    public function findByEmail($username){
        return $this->userRepositoryInterface->findByEmail($username);
    }

    public function updateAvatar($userID, $url)
    {
        return $this->userRepositoryInterface->updateAvatar($userID, $url);
    }

    public function changeProfileLink($userID, $typeLink, $valueLink)
    {
        return $this->userRepositoryInterface->changeProfileLink($userID, $typeLink, $valueLink);
    }
}
?>