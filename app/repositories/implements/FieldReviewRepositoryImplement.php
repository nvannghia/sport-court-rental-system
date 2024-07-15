<?php

namespace App\Repositories\Implements;

use App\Models\FieldReview;
use App\Repositories\FieldReviewRepositoryInterface;

class FieldReviewRepositoryImplement implements FieldReviewRepositoryInterface
{
    public function addFieldReview(array $data): FieldReview
    {
        return FieldReview::create($data);
    }

    public function calculateStarCountsSportFieldByID($sportFieldID): array
    {

        $stars = [];
        for ($i = 1; $i <= 5; $i++) {
            $query = FieldReview::query();
            
            $count = $query->where('SportFieldID', $sportFieldID)
                ->where('Rating', $i)
                ->count();

            $stars[] = $count;
        }

        return $stars;
    }
}
