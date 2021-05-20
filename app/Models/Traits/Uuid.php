<?php

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid as RamseyUuid;

trait Uuid
{
    //é executado toda vez que o model é executado
    //usado para gatilho/evento
    //ex: antes do objeto ser salvo no banco de dados, é gerado um id
    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            $obj->id = RamseyUuid::uuid4()->toString();
        });
    }
}
