<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\GenderMeta;

class GenderMetaRepository extends AbstractBaseRepository
{
  public function __construct(GenderMeta $model)
  {
      parent::__construct($model);
  }

}
