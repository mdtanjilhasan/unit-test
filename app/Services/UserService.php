<?php

namespace App\Services;

use App\Models\User;
use App\SOLID\Interfaces\BaseInterfaces\Read\Readable;
use Illuminate\Database\Eloquent\Model;

class UserService implements Readable
{
    public function getAll($model, $where, $callable)
    {
        // TODO: Implement getAll() method.
        return $model->when($where,function ($q) use($where){
            $q->where($where);
        })->where($callable);
    }

    public function getDetail(int $id)
    {
        // TODO: Implement getDetail() method.
        return User::findOrFail($id);
    }
}
