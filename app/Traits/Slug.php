<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Slug {
    protected static function bootSlug() {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name, '-');
        });
    }
}