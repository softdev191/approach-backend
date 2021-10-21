<?php


namespace App\Repositories;


use App\AbstractBases\AbstractBaseRepository;
use App\Models\Message;

class MessageRepository extends AbstractBaseRepository
{
  public function __construct(Message $model)
  {
      parent::__construct($model);
  }

  public function send($data)
  {
      return $this->model->create($data);
  }

  public function getMessages($page, $user)
  {
      $currentUser = authUser()->user->uuid;
      $query =  $this->model->whereRaw("
                            (receiver = '{$user}'  AND sender = '{$currentUser}') OR (receiver = '{$currentUser}'  AND sender = '{$user}')
                            ")
                ->selectRaw("content, attachment, sender, receiver, IF(sender = '{$currentUser}', true, false) as is_from_current_sender, created_at")
                ->orderBy('created_at', 'desc');
      return $this->model::paginate($query, 10, $page);
  }

}
