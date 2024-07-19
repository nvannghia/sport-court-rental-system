<?php

namespace App\Repositories\Implements;

use App\Models\SportField;
use App\Repositories\SportFieldRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SportFieldRepositoryImplement implements SportFieldRepositoryInterface
{
    public function create(array $arrayCheck, array $arrayInsert): sportField
    {
        return SportField::firstOrCreate($arrayCheck, $arrayInsert);
    }

    public function getSportFieldByOwnerID($owerID): Collection
    {
        return SportField::where('OwnerID', $owerID)
            ->with(['sportType']) // fetching relationship: eager loading
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getSportFieldByID($sportFieldID)
    {
        return SportField::find($sportFieldID);
    }

    public function getSportFieldByIDWithReviews($sportFieldID)
    {
        return SportField::with(['fieldReviews.user', 'fieldReviews.usersLikedReview' ])->find($sportFieldID);
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


    public function filterSportFieldsByConditions($sportType = null,  $fieldName = null, $zoneName = null)
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
            
            // Lấy kết quả cuối cùng
            $sportFields = $query->get();

            // Trả về kết quả
            return $sportFields;
        }
    }
}
