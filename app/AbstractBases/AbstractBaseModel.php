<?php

namespace App\AbstractBases;



use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbstractBaseModel extends Model
{
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public static function paginate(Builder $query, $perPage, $page = 1)
    {
        $offset = ($page - 1) * $perPage;
//        $count = $query->get()->count();
        $count = $query->getQuery()->getCountForPagination();

        // IF EMPTY PAGE //
        if($page == 1 && $count == 0) {
            return (object)[
                "list" => [],
                "max_page" => 1,
                "prev_page" => 0,
                "next_page" => 0,
                "status" => 200
            ];
        }

        $max_page = ceil($count / $perPage);

        if( $page > $max_page ) {
            return (object)[
                "list" => [],
                "status" => 404,
                "max_page" => 0,
                "prev_page" => 0,
                "next_page" => 0
            ];
        }

        return (object)[
            "status" => 200,
            "list" => $query->limit($perPage)->offset($offset)->get(),
            "max_page" => $max_page,
            "prev_page" => $page == 1 ? 0 : $page - 1,
            "next_page" => $page == $max_page ? 0 : $page + 1
        ];
    }
}
