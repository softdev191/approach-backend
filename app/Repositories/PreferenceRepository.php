<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\Preference;

class PreferenceRepository extends AbstractBaseRepository
{
  public function __construct(Preference $model)
  {
      parent::__construct($model);
  }

  public function updateOrCreate($user, $data)
  {
      $query = [];
      foreach ($data as $item) {
          $query[] = $this->model->updateOrCreate(
              ['user_uuid' => $user, 'attribute' => $item['attribute']],
              $item
          );
      }

      return $query;
  }

  public function getPreferences($user)
  {
      return $this->model->where('user_uuid', $user)->get();
  }
}
