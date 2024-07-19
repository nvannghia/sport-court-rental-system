<?php

namespace App\Repositories\Implements;

use App\Models\FieldReview;
use App\Models\UserModel;
use App\Repositories\FieldReviewRepositoryInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use phpDocumentor\Reflection\Types\Boolean;

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


    public function updateLikeReview($action, $fieldReviewID, $userID): bool
    {
        try {
            Capsule::beginTransaction();
            //user liked review
            $user = UserModel::find($userID);

            //increase the number of likes
            if ($action == 'increase') {
                //sync data to pivot('liked') table
                $user->likedReviews()->syncWithoutDetaching($fieldReviewID);
            } else {
                //detach data from pivot('liked') table
                $user->likedReviews()->detach($fieldReviewID);
            }

            Capsule::commit();

            return true;
        } catch (\PDOException $e) {
            echo "Exception: " . $e->getMessage();
            Capsule::rollBack();

            return false;
        }
    }

    public function deleteFieldReview($fieldReviewID)
    {
        $fieldReview = FieldReview::find($fieldReviewID);
        if ($fieldReview)
            return $fieldReview->delete();
        else
            return false;
    }

    public function getFieldReviewByID($fieldReviewID): FieldReview
    {
        $fieldReview = FieldReview::find($fieldReviewID);
        if ($fieldReview)
            return $fieldReview;
        else
            return false;
    }

    public function updateFieldReview($fieldReviewID, array $data)
    {
        $fieldReview = FieldReview::find($fieldReviewID);
        if ($fieldReview) {
            $fieldReview->Rating = $data['rating'];
            $fieldReview->Content = $data['content'];
            $fieldReview->ImageReview = isset($data['imageReview']) ? $data['imageReview'] : $fieldReview->ImageReview;
            $fieldReview->save();
            return $fieldReview->fresh();
        }
        else
            return false;
    }
}
