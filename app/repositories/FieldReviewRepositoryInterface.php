<?php

namespace App\Repositories;

interface FieldReviewRepositoryInterface
{
    public function addFieldReview(array $data);

    public function calculateStarCountsSportFieldByID($sportFieldID);
}
