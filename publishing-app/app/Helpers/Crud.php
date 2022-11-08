<?php 

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class Crud {

    public static function findOne(Model $model, $col = 'id',  $val)
    {
        if($col == 'id') {
            return $model->findOrFail($val);
        }
        return $model->where($col, $val)->firstOrFail();
    }

    public static function save(Model $model, Array $arr)
    {
        return $model->create($arr);
    }

    public static function update(Model $model, $arr,$col = 'id', $val, $connection = false)
    {
        $find = $model->where($col, $val)->firstOrFail();
        foreach($arr as $index => $fill) {
            $find[$index] = $arr[$index];
        }
        $find->save();
        return $model->where($col, $val)->firstOrFail();
    }

    public static function deleteOne(Model $model, $col = 'id', $val)
    {
        return $model->where($col, $val)->firstOrFail()->delete();
    }

}