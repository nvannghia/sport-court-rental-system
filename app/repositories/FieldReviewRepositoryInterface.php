<?php

namespace App\Repositories;

interface FieldReviewRepositoryInterface
{
    public function addFieldReview(array $data);

    public function calculateStarCountsSportFieldByID($sportFieldID);

    public function updateLikeReview($action, $fieldReviewID, $userID);

    public function deleteFieldReview($fieldReviewID);

    public function getFieldReviewByID($fieldReviewID);

    public function updateFieldReview($fieldReviewID, array $data);
}
