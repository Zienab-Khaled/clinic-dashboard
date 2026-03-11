<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'key',
        'title',
        'subtitle',
        'icon',
        'route_name',
        'route_params',
        'card_class',
        'sort_order',
        'active',
        'has_waiting_display',
    ];

    protected $casts = [
        'route_params' => 'array',
        'sort_order' => 'integer',
        'active' => 'boolean',
        'has_waiting_display' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Service::class, 'parent_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (Service $service) {
            foreach ($service->children()->get() as $child) {
                $child->delete();
            }
        });

        static::saving(function (Service $service) {
            if ($service->parent_id === $service->id) {
                $service->parent_id = null;
            }
            if (! empty($service->key)) {
                if (strtolower($service->key) === 'clinics') {
                    $service->route_name = 'staff';
                    $service->route_params = [];
                } else {
                    $service->route_name = 'department.staff';
                    $service->route_params = ['type' => $service->key];
                }
            }
        });
    }

    public function getUrlAttribute(): string
    {
        if (empty($this->route_name)) {
            return route('home');
        }

        $params = $this->route_params ?? [];

        return route($this->route_name, $params);
    }
}

