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
        'validate_by',
        'assign_date',
        'assign_at',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Boot method for the Collector model.
     *
     * This method is called when the model is booted. It sets up an event listener
     * for the deleting event. When a Collector instance is being deleted, this
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

    /**
     * Get the short version of the location attribute.
     *
     * This method returns a shortened version of the location attribute.
     * If the location contains more than 4 words, it will return the first
     * 8 words followed by ' ...'. Otherwise, it returns the full location.
     *
     * @return string The shortened location.
     */
    public function getShortLocationAttribute()
    {
        $words = explode(' ', $this->location);
        if (count($words) > 4) {
            return implode(' ', array_slice($words, 0, 8)) . ' ...';
        }
        return $this->location;
    }

    /**
     * Get the short title attribute.
     *
     * This accessor method returns a shortened version of the title attribute.
     * If the title contains more than three words, it returns the first three words.
     * Otherwise, it returns the full title.
     *
     * @return string The shortened title or the full title if it contains three or fewer words.
     */
    public function getShortTitleAttribute()
    {
        $words = explode(' ', $this->title);
        if (count($words) > 3) {
            return implode(' ', array_slice($words, 0, 3)) . '';
        }
        return $this->title;
    }

    /**
     * Get the photos collected by the collector.
     *
     * This function defines a one-to-many relationship between the Collector model
     * and the PhotoCollect model. It returns all the PhotoCollect instances that
     * are associated with the current Collector instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photoCollectRelasi()
    {
        return $this->hasMany(PhotoCollect::class, 'id_collect');
    }

    /**
     * Define a relationship between the Collector model and the Pegawai model.
     *
     * This method establishes a "belongs to" relationship, indicating that each
     * instance of the Collector model is associated with a single instance of the
     * Pegawai model. The foreign key 'kode_pegawai' in the Collector model is used
     * to reference the primary key 'kode_pegawai' in the Pegawai model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pegawaiRelasi()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'kode_pegawai');
    }

    /**
     * Define a relationship between the Collector model and the CollectTask model.
     *
     * This function establishes a "belongs to" relationship, indicating that each
     * instance of the Collector model is associated with a single instance of the
     * CollectTask model. The relationship is based on the 'no_sr' field in both models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collectTaskRelasi()
    {
        return $this->belongsTo(CollectTask::class, 'no_sr', 'no_sr');
    }

    public function collectTaskPpnRelasi()
    {
        return $this->belongsTo(CollectTaskPpn::class, 'no_sr', 'tax_invoice');
    }

    /**
     * Define a relationship between the Collector model and the User model.
     *
     * This method establishes a "belongs to" relationship, indicating that each
     * instance of the Collector model is associated with a single instance of the
     * User model. The relationship is based on the 'kode_pegawai' foreign key in
     * the Collector model and the 'kode_pegawai' primary key in the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'kode_pegawai', 'kode_pegawai');
    }
}
