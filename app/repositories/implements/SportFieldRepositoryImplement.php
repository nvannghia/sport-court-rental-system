<?php

namespace App\Repositories\Implements;

use App\Models\SportField;
use App\Repositories\SportFieldRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Capsule\Manager as DB;

class SportFieldRepositoryImplement implements SportFieldRepositoryInterface
{
    private const ITEM_PER_PAGE = 6;

    private const ITEM_PER_PAGE_OWNER = 4;

    private const ITEM_REVIEW_PER_PAGE = 2;

    public function create(array $arrayCheck, array $arrayInsert): sportField
    {
        return SportField::firstOrCreate($arrayCheck, $arrayInsert);
    }

    public function getSportFieldByOwnerID($offset, $owerID)
    {
        //for none-paigation
        if ($offset == 'none') {
            return SportField::where('OwnerID', $owerID)
                ->with(['sportType']) // fetching relationship: eager loading
                ->orderBy('created_at', 'desc')
                ->get();
        }

        //query for pagination
        $query =  SportField::where('OwnerID', $owerID)
            ->with(['sportType']) // fetching relationship: eager loading
            ->orderBy('created_at', 'desc');

        //for paginate
        $totalRecords =  $query->count();
        $totalPages = ceil($totalRecords / self::ITEM_PER_PAGE_OWNER);

        $sportFields = $query->offset($offset)
            ->limit(self::ITEM_PER_PAGE_OWNER)
            ->get();

        return [
            'sportFields' => $sportFields,
            'totalPages' => $totalPages,
        ];
    }

    public function getSportFieldByOwnerIDWithFilter($ownerID, $filter)
    {
        if ($filter === "UNPAID") {
            $results = SportField::select(
                'sportfield.*',
                DB::raw('COUNT(CASE WHEN bookings.PaymentStatus = "UNPAID" THEN 1 END) as countUnpaidBookings')
            )
                ->join('booking as bookings', 'bookings.SportFieldID', '=', 'sportfield.ID')
                ->where('sportfield.OwnerID', $ownerID)
                ->with(['sportType'])
                ->groupBy('sportfield.ID')
                ->havingRaw('COUNT(CASE WHEN bookings.PaymentStatus = "UNPAID" THEN 1 END) > 0')
                ->get();
        } else {
            $results = SportField::select(
                'sportfield.*',
                DB::raw('COUNT(CASE WHEN bookings.PaymentStatus = "PAID" THEN 1 END) as countPaidBookings')
            )
                ->join('booking as bookings', 'bookings.SportFieldID', '=', 'sportfield.ID')
                ->where('sportfield.OwnerID', $ownerID)
                ->with(['sportType'])
                ->groupBy('sportfield.ID')
                ->havingRaw('COUNT(CASE WHEN bookings.PaymentStatus = "UNPAID" THEN 1 END) = 0')
                ->get();
        }

        return $results;
    }

    public function getSportFieldByID($sportFieldID)
    {
        return SportField::find($sportFieldID);
    }

    public function getTotalReviewsOfSportField($sportFieldID)
    {
        $totalRecords = SportField::find($sportFieldID)
            ->fieldReviews()
            ->count();
        return $totalRecords;
    }

    public function getSportFieldByIDWithReviews($offset, $orderBy = null, $sportFieldID)
    {
        if (!$orderBy) {
            
            $sportField = SportField::with(
                [
                    'fieldReviews' => function ($query) use ($offset) {
                        $query->skip($offset)->take(self::ITEM_REVIEW_PER_PAGE);
                    },
                    'fieldReviews.user',
                    'fieldReviews.usersLikedReview'
                ]
            )->find($sportFieldID);

        } else {
            $orderByArray = [];

            if ($orderBy == 'created_at') {
                $orderByArray[0] = $orderBy;
                $orderByArray[1] = 'DESC';
            } else {
                $orderByArray = explode('_', $orderBy);
            }

            $sportField = SportField::with(
                [
                    'fieldReviews' => function ($query) use ($orderByArray, $offset) {
                        $query->orderBy($orderByArray[0], $orderByArray[1])
                            ->skip($offset)
                            ->take(self::ITEM_REVIEW_PER_PAGE);
                    },
                    'fieldReviews.user',
                    'fieldReviews.usersLikedReview'
                ]
            )
                ->find($sportFieldID);
        }
        //for pagination
        $totalRecordsReview = $this->getTotalReviewsOfSportField($sportFieldID);
        $totalPages = ceil($totalRecordsReview / self::ITEM_REVIEW_PER_PAGE);

        return [
            'sportField' => $sportField,
            'totalPages' => $totalPages,
        ];
    }

    public function update($sportFieldID, array $attributes)
    {
        $sportField = $this->getSportFieldByID($sportFieldID);

        if ($sportField) {

            $sportField->fill($attributes);

            $isUpdated = $sportField->save();

            if ($isUpdated)
                return $sportField;

            return null;
        }

        return null;
    }

    public function destroy($sportFieldID)
    {
        return SportField::destroy($sportFieldID);
    }


    public function filterSportFieldsByConditions($offset, $sportType = null,  $fieldName = null, $zoneName = null)
    {
        if (isset($sportType) || isset($sportType) || isset($zoneName)) {
            // Sử dụng Query Builder của Eloquent để tạo câu SQL
            $query = SportField::query();

            // Thêm các điều kiện vào câu truy vấn
            if (isset($sportType)) {
                $query->where('SportTypeID', $sportType);
            }

            if (isset($fieldName)) {
                $query->where('FieldName', 'LIKE', '%' . $fieldName . '%');
            }

            if (isset($zoneName)) {
                $query->where('Address', 'LIKE', '%' . $zoneName . '%');
            }

            // Lấy số lượng kết quả
            $totalRecords = $query->count();
            // Tính tổng page sẽ có 
            $totalPages = ceil($totalRecords / self::ITEM_PER_PAGE);
            // Lấy kết quả cuối cùng
            $sportFields = $query->offset($offset)->limit(self::ITEM_PER_PAGE)->get();

            // Trả về kết quả
            return [
                'totalPages' => $totalPages,
                'sportFields' => $sportFields,
            ];
        }
    }
}
