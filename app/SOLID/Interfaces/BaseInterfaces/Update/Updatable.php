<?php

namespace App\SOLID\Interfaces\BaseInterfaces\Update;

interface Updatable
{
    public function update(int $id, array $data);
}
