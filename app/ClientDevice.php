<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientDevice extends Model
{
    public static function rules ($id=0, $merge=[]) {
        return array_merge(
            [
                'fingerprint'  => 'required|unique|max:255'. ($id ? ",id,$id" : ''),
            ], 
            $merge);
    }
}
