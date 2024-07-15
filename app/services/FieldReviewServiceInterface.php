<?php

namespace App\Services;

interface FieldReviewServiceInterface
{
    public function addFieldReview(array $data);

    public function calculateStarCountsSportFieldByID($sportFieldID);
}
