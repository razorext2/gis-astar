<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Sales extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tb_sales";
    protected $fillable = [
        "kode_pegawai",
        "title",
        "customer_name",
        "customer_telp",
        "lokasi",
        "keterangan",
        "longitude",
        "latitude",
        "status",
        "notes",
        "validate_by",
        "id_session",
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Boot method for the Sales model.
     *
     * This method is called when the model is booted. It sets up an event listener
     * for the deleting event. When a Sales instance is being deleted, this
     * listener will:
     * - Iterate through each related photo in the photoCollectRelasi relationship.
     * - Convert the photo URL from a storage path to a public path.
     * - Check if the file exists in storage and delete it if it does.
     * - Delete the related photo records from the database.
     *
     * @return void
     */
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
            return implode(' ', array_slice($words, 0, 3)) . '';
        }
        return $this->title;
    }

    /**
     * Get the photoCollectRelasi record associated with the Sales.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photoCollectRelasi()
    {
        return $this->hasMany(PhotoCollect::class, 'id_sales');
    }

    /**
     * Get the pegawaiRelasi record associated with the Sales.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    /**
     * Get the userRelasi record associated with the Sales.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    public function questionnaire()
    {
        return $this->hasMany(QuestionAnswer::class, 'id_session', 'id_session');
    }
}
