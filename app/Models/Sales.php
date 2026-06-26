<?php

/** Goal: Represent sales report data in DB, Caller: ValidateSales, Deps: PhotoCollect, Pegawai, User */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Sales extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_sales';

    protected $fillable = [
        'kode_pegawai',
        'title',
        'customer_name',
        'customer_telp',
        'lokasi',
        'keterangan',
        'longitude',
        'latitude',
        'status',
        'notes',
        'validate_by',
        'id_session',
        'customer_make_order',
        'gives_phone_number',
        'order_notes',
        'proof_picture',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($sales) {
            foreach ($sales->photoCollectRelasi as $photo) {
                $path = str_replace('/storage/', 'public/', $photo->photourl);
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }

            $sales->photoCollectRelasi()->delete();
        });
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
        return $this->hasMany(PhotoCollect::class, 'id_sales');
    }

    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }

    public function validateBy()
    {
        return $this->belongsTo(User::class, 'validate_by', 'id');
    }

    public function scopeNeedApprove($query)
    {
        return $query->where('status', 0);
    }
}
