<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\Store;

class StoreRepository extends AbstractBaseRepository
{
  public function __construct(Store $model)
  {
      parent::__construct($model);
  }

    public function storeNearby($data, $distance = 5)
    {
        return $this->model->where('uuid', '!=', authUser()->user->uuid)
            ->selectRaw("stores.*, ( 3959 * acos( cos( radians({$data['lat']}) ) 
                    * cos( radians( `lat` ) ) * cos( radians( `lng` ) - radians({$data['lng']}) ) + sin( radians({$data['lat']}) ) 
                    * sin(radians(lat)) ) ) AS distance")
            ->havingRaw('distance <= ?', [$distance])
            ->get();
    }
}
