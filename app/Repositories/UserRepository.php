<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository extends AbstractBaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function verifyAuthUser($data)
    {
        return $this->model->where('email', $data['user'])
                        ->orWhere('mobile', $data['user'])
                        ->first();
    }

    public function usersNearby($data, $distance = 5, $preferences = [])
    {
        $user = authUser()->user->uuid;
        $userInfo = User::where('uuid', $user)->first();
        $query = $this->model;

        if($preferences){
            $age = explode('-', $preferences['age_range'][0]);
            $height = explode('-', trim($preferences['height'][0]));

            $query = $query->whereIn('gender', $preferences['gender'])
                           ->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, NOW()) between {$age[0]} and {$age[1]}")
                           ->whereRaw("height between {$height[0]} and {$height[1]}");
        }

        $query = $query->where('uuid', '!=', $user)
                    ->where('visibility', 1)
                    ->whereNotIn('uuid', function($query) use ($user){
                        $query->select('blocked_user_uuid')
                            ->where('blocked_by', $user)
                            ->from('blocked_users');
                    })
                    ->whereHas('preferences' , function($query2) use ($userInfo) {
                        $query2->whereRaw("
                                (attribute = 'gender' and (value like '%\"".$userInfo->gender."\"%')
                                    or (attribute = 'age_range' and (" . $userInfo->age . " between  SUBSTRING_INDEX(SUBSTRING_INDEX(value, '-', 1), '[\"', -1) and SUBSTRING_INDEX(SUBSTRING_INDEX(value, '-', -1), '\"]', 1)))
                                     or (attribute = 'height' and (" . $userInfo->height . "  between  SUBSTRING_INDEX(SUBSTRING_INDEX(value, '-', 1), '[\"', -1) and SUBSTRING_INDEX(SUBSTRING_INDEX(value, '-', -1), '\"]', 1))))
                                ");
                        } ,'>=', 3)
//                    ->with(['preferences' => function($query2) use ($userInfo) {
//                        $query2->whereRaw("
//                                        (attribute = 'gender' and (value like '%".$userInfo->gender.",%' OR value like '%,".$userInfo->gender."%')
//                                            or (attribute = 'age_range' and ('".$userInfo->age."' between  SUBSTRING_INDEX(SUBSTRING_INDEX(value, '-', 1), '[\"', -1) and SUBSTRING_INDEX(SUBSTRING_INDEX(value, '-', -1), '\"]', 1)))
//                                             or (attribute = 'height' and ('".$userInfo->height."'  between  SUBSTRING_INDEX(SUBSTRING_INDEX(value, '-', 1), '[\"', -1) and SUBSTRING_INDEX(SUBSTRING_INDEX(value, '-', -1), '\"]', 1))))
//                                ");
//                    }])
                    ->selectRaw("users.*, ( 3959 * acos( cos( radians({$data['lat']}) )
                    * cos( radians( `lat` ) ) * cos( radians( `lng` ) - radians({$data['lng']}) ) + sin( radians({$data['lat']}) )
                    * sin(radians(lat)) ) ) AS distance")
                    ->havingRaw('distance <= ?', [$distance]);

        return $query->get();
    }

    public function userEmailMobileExist($request)
    {
        if($request['mobile']){
            return $this->model->where('mobile', $request['mobile'])->first();
        }

        return $this->model->where('email', $request['email'])->first();

    }
}
