<?php

namespace App\Traits\Base;


trait Uuidable
{
    use UuidTrait;

    public static function bootUuidable()
    {
        static::saving(function ($model) {
            $model->uuid = $model->generateUuid();
        });
    }
}
