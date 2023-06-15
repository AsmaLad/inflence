<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'progress', 'status', 'user_id', 'event_uuid'];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        self::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}