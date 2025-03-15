<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Driver extends Model
{
    use SoftDeletes;
    protected $table = 'tb_drivers';
    protected $fillable = [
        'kode_pegawai',
        'title',
        'lokasi',
        'keterangan',
        'longitude',
        'latitude',
        'status',
        'notes',
        'validate_by',
        'total_revision',
        'revised_by'
    ];
    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($driver) {
            foreach ($driver->photoCollect as $photo) {
                $path = str_replace('/storage/', 'public/', $photo->photourl);
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }

            $driver->photoCollect()->delete();
        });
    }

    public function getShortTitleAttribute()
    {
        $words = explode(' ', $this->title);
        if (count($words) > 3) {
            return implode(' ', array_slice($words, 0, 3)) . '';
        }
        return $this->title;
    }

    public function photoCollect()
    {
        return $this->hasMany(PhotoCollect::class, 'id_driver');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }
}
