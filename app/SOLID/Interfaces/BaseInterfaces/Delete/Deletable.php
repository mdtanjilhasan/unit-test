<?php

namespace App\SOLID\Interfaces\BaseInterfaces\Delete;

interface Deletable
{
    public function delete(int $id);

    public function bulkDelete(array $ids);
}
