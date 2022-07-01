<?php

namespace App\SOLID\Interfaces\BaseInterfaces\Delete;

interface ForceDeleteable
{
    public function forceDelete(int $id);

    public function bulkForceDelete(array $ids);
}
