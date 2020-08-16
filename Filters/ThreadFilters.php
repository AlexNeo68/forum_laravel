<?php


namespace App\Filters;


use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];

    protected function by(string $userName){
        $user = User::whereName($userName)->firstOrFail();
        return $this->builder->whereUserId($user->id);
    }
}
