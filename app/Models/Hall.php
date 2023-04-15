<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    public function makeUpdate(mixed $typerequest, string $type): void
    {
        $values = explode('-', $typerequest);
        foreach ($values as $value) {
            $idArr = explode('=', $value);
            $id = $idArr[0];
            $str = $idArr[1];
            $hall = $this->find($id);
            $hall->$type = $str;
            $hall->update();
        }
    }
}
