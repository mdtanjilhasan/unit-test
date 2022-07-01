<?php

namespace App\SOLID\Interfaces\BaseInterfaces\Read;

interface Readable
{
    public function getAll(array $filter = []);

    public function getDetail(int $id);
}
