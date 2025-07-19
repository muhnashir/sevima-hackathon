<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid as Generator;

trait WithUuid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Generator::uuid4()->toString();
        });
    }

}
