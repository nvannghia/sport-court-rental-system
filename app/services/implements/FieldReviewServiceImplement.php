<?php

namespace App\Services\Implements;

use App\Repositories\FieldReviewRepositoryInterface;
use App\Services\FieldReviewServiceInterface;

class FieldReviewServiceImplement implements FieldReviewServiceInterface
{   
    private $fieldReviewRepositoryInterface;

    public function __construct(FieldReviewRepositoryInterface $fieldReviewRepositoryInterface)
    {
        $this->fieldReviewRepositoryInterface = $fieldReviewRepositoryInterface;
    }
    public function addFieldReview(array $data) 
    {
        return $this->fieldReviewRepositoryInterface->addFieldReview($data);
    }

    public function calculateStarCountsSportFieldByID($sportFieldID):array 
    {
        return $this->fieldReviewRepositoryInterface->calculateStarCountsSportFieldByID($sportFieldID);
    }
}
