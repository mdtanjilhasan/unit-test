<?php

namespace App\SOLID\Interfaces\BaseInterfaces\Delete;

interface Restorable
{
    public function restore(int $id);

    public function bulkRestore(array $ids);
}
