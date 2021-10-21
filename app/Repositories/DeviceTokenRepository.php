<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\DeviceTokens;

class DeviceTokenRepository extends AbstractBaseRepository
{
    public function __construct(DeviceTokens $model)
    {
        parent::__construct($model);
    }

    public function getDeviceToken($platform, $token)
    {
        return $this->model->where("platform", $platform)
            ->where("device_token", $token)
            ->where("user_uuid", authUser()->user->uuid)
            ->orderBy('id', 'desc')->first();
    }

    public function firstOrCreateDeviceToken($data)
    {
        return $this->model->firstOrCreate($data,$data);
    }

    public function getUserDevices($user)
    {
        return $this->model->where('user_uuid', $user)
                           ->orderBy('id', 'desc')
                           ->get();
    }
}
