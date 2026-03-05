<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return Cache::remember('setting.' . $key, 3600, function () use ($key, $default) {
            $row = static::query()->find($key);
            return $row ? $row->value : $default;
        });
    }

    public static function setValue(string $key, ?string $value): void
    {
        static::query()->updateOrInsert(
            ['key' => $key],
            ['value' => $value]
        );
        Cache::forget('setting.' . $key);
    }
}
