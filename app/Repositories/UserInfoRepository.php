<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\Preference;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Log;

class UserInfoRepository extends AbstractBaseRepository
{
  public function __construct(UserInfo $model)
  {
      parent::__construct($model);
  }

  public function updateOrCreate($user, $data)
  {
        foreach ($data as $item) {
            $this->model->updateOrCreate(
                ['user_uuid' => $user, 'attribute' => $item['attribute']],
                $item
            );
        }
  }
}
