<?php

namespace App\SOLID\Interfaces;

use App\SOLID\Interfaces\BaseInterfaces\Create\Storable;
use App\SOLID\Interfaces\BaseInterfaces\Delete\Deletable;
use App\SOLID\Interfaces\BaseInterfaces\Read\Readable;
use App\SOLID\Interfaces\BaseInterfaces\Update\Updatable;

abstract class Users implements Readable
{
    public abstract function getAll(array $filter = []);

    public abstract function getDetail(int $id);
}
