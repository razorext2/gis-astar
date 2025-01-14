<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Collector extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tb_collect';
    protected $fillable = [
        'no_sr',
        'kode_pegawai',
        'title',
        'keterangan',
        'location',
        'longitude',
        'latitude',
        'status',
        'notes',
        'have_paid',
        'payment_type',
        'payment_amount',
        'validate_by',
        'assign_date',
        'assign_at',
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($collector) {
            // hapus semua file terkait yang berelasi dengan tb_photo_collect
            foreach ($collector->photoCollectRelasi as $photo) {
                $path = str_replace('/storage/', 'public/', $photo->photourl);
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }

            $collector->photoCollectRelasi()->delete();
        });
    }

    public function getShortLocationAttribute()
    {
        $words = explode(' ', $this->location);
        if (count($words) > 4) {
            return implode(' ', array_slice($words, 0, 8)) . ' ...';
        }
        return $this->location;
    }

    // membuat versi pendek title
    public function getShortTitleAttribute()
    {
        $words = explode(' ', $this->title);
        if (count($words) > 3) {
            return implode(' ', array_slice($words, 0, 3)) . '';
        }
        return $this->title;
    }

    // buat relasi hasMany, karena tiap data collect dapat memiliki banyak data photocollect
    public function photoCollectRelasi()
    {
        return $this->hasMany(PhotoCollect::class, 'id_collect');
    }

    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function collectTaskRelasi()
    {
        return $this->belongsTo(CollectTask::class, 'no_sr', 'no_sr');
    }

    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }
}
