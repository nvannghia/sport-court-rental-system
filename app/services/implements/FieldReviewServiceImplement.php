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
    
    public function updateLikeReview($action, $fieldReviewID, $userID) 
    {
        return $this->fieldReviewRepositoryInterface->updateLikeReview($action, $fieldReviewID, $userID);
    }

    public function deleteFieldReview($fieldReviewID)
    {
        return $this->fieldReviewRepositoryInterface->deleteFieldReview($fieldReviewID);
    }

    public function getFieldReviewByID($fieldReviewID)
    {
        return $this->fieldReviewRepositoryInterface->getFieldReviewByID($fieldReviewID);
    }

    public function updateFieldReview($fieldReviewID, array $data)
    {
        return $this->fieldReviewRepositoryInterface->updateFieldReview($fieldReviewID, $data);
    }

    public function getReviewPagination($offset, $sportFieldID, $orderBy)
    {
        return $this->fieldReviewRepositoryInterface->getReviewPagination($offset, $sportFieldID, $orderBy);
    }
}
