<?php


namespace App\Service;


use App\AbstractBases\AbstractBaseService;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;

class StoreService extends AbstractBaseService
{
    public function __construct(Request $request, StoreRepository $repository)
    {
        parent::__construct($request);

        $this->request = $request;
        $this->repository = $repository;
    }

    public function storeNearby()
    {
        $stores = $this->repository->storeNearby($this->request->all());

        if(count($stores) == 0){
            $this->response = $this->makeResponse(200, 'store.nearby.not_found');
            return $this->with([
                'stores' => []
            ])->response();
        }

        $this->response = $this->makeResponse(200, 'store.nearby.found');
        return $this->with([
            'stores' => $stores
        ])->response();
    }
}
