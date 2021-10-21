<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\BlockedUsers;


class BlockedUserRepository extends AbstractBaseRepository
{
    public function __construct(BlockedUsers $model)
    {
        parent::__construct($model);
    }

}
