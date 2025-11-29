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
        'bill_type',
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
        'no_giro',
        'validate_by',
        'validated_at',
        'assign_date',
        'assign_at',
        'total_revision',
        'revised_by',
        'revised_at',
        'filled_by',
        'filled_at',
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($collector) {
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
            return implode(' ', array_slice($words, 0, 8)).' ...';
        }

        return $this->location;
    }

    public function getShortTitleAttribute()
    {
        $words = explode(' ', $this->title);
        if (count($words) > 3) {
            return implode(' ', array_slice($words, 0, 3)).'';
        }

        return $this->title;
    }

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

    public function collectTaskPpnRelasi()
    {
        return $this->belongsTo(CollectTaskPpn::class, 'no_sr', 'tax_invoice');
    }

    public function collectIdyPpnRelasi()
    {
        return $this->belongsTo(CollectIdyPpn::class, 'no_sr', 'tax_invoice');
    }

    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function scopeNeedApprove($query)
    {
        return $query->where('status', 2);
    }

    public function filledBy()
    {
        return $this->belongsTo(User::class, 'filled_by', 'id');
    }

    public function revisedBy()
    {
        return $this->belongsTo(User::class, 'revised_by', 'id');
    }

    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'validate_by', 'id');
    }
}
