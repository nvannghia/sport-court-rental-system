<?php

namespace App\Repositories\Implements;

use App\Models\FieldReview;
use App\Models\UserModel;
use App\Repositories\FieldReviewRepositoryInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use phpDocumentor\Reflection\Types\Boolean;

class FieldReviewRepositoryImplement implements FieldReviewRepositoryInterface
{
    const ITEM_PER_PAGE = 2;
    public function addFieldReview(array $data): FieldReview
    {
        return FieldReview::create($data);
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

    public function getFieldReviewByID($fieldReviewID)
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
        } else
            return false;
    }

    public function getReviewPagination($offset, $sportFieldID, $orderBy)
    {
        // get review with pagination
        $reviews = FieldReview::from('fieldreview AS FR')
            ->leftJoin('liked AS LK', 'LK.FieldReviewID', '=', 'FR.ID')
            ->leftJoin('users AS AUTHOR', 'AUTHOR.ID', '=', 'FR.UserID')
            ->leftJoin('users AS USER_LIKED_REIVEW', 'USER_LIKED_REIVEW.ID', '=', 'LK.UserID')
            ->select(
                'FR.ID AS fieldreview_id',
                'FR.Content AS review_content',
                'FR.ImageReview',
                'FR.updated_at',
                'FR.Rating',
                Capsule::raw('DATE_FORMAT(FR.updated_at, "%d-%m-%Y") as date_cmt'),
                'AUTHOR.ID AS author_id',
                'AUTHOR.FullName AS author_name',
                'AUTHOR.Avatar AS author_avatar',
                Capsule::raw('GROUP_CONCAT(USER_LIKED_REIVEW.ID) AS user_liked_review_ids'),
                Capsule::raw('COUNT(USER_LIKED_REIVEW.ID) AS number_liked')
            )
            ->where('FR.SportFieldID', '=', $sportFieldID)
            ->groupBy('FR.ID')
            ->offset($offset)
            ->limit(self::ITEM_PER_PAGE);
            if (!empty($orderBy)) 
                $reviews->orderBy('FR.Rating', $orderBy);
            else 
                $reviews->orderBy('FR.ID', "desc");

            $reviews = $reviews->get();

        // get total records
        $totalRecords = FieldReview::from('fieldreview AS FR')
            ->where('FR.SportFieldID', '=', $sportFieldID)
            ->groupBy('FR.ID')
            ->get()
            ->count();
        $totalPages   = ceil($totalRecords / self::ITEM_PER_PAGE);
        return [
            'items'      => $reviews->toArray(),
            'totalPages' => $totalPages
        ];
    }
}
