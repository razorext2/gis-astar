<?php

namespace App\Models\Spk;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpkMain extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'tb_spk';

    protected $fillable = [
        'nomor_order',
        'nomor_dokumen_penawaran',
        'tipe_tagihan',
        'status_nomor_tagihan',
        'nomor_tagihan',
        'nomor_purchasing_request',
        'nomor_purchasing_request_json',
        'tipe_bayar',
        'tgl_cetak',
        'tgl_kirim',
        'keterangan',
        'customer',
        'tipe_timbangan',
        'products',
        'informasi_pengiriman',
        'documentations',
        'status',
        'added_by',
        'assign_to',
        'update_by',
        'pengiriman_updated_by',
        'no_tagihan_updated_by',
        'purchasing_list_updated_by',
        'status_approval',
        'catatan_approval',
        'approved_by',
        'approved_at',
        'on_delay',
        'on_delay_at',
        'on_delay_notes',
        'on_delay_by',
        'production_has_download_spk_pdf',
        'production_has_download_spk_pdf_at',
        'is_booked',
        'booked_at',
        'booked_by',
        'revision_count',
        'latest_revision_request_by',
        'latest_revision_request_detail',
        'is_cancelled',
        'cancel_request_by',
        'cancel_request_at',
        'cancel_request_reason',
        'cancel_request_validated_by',
        'cancel_request_validated_at',
        'is_using_old_stock',
        'is_using_company_driver',
        'is_picked_up_by_customer',
        'is_revision',
    ];

    protected $casts = [
        'customer' => 'array',
        'products' => 'array',
        'nomor_purchasing_request_json' => 'array',
        'informasi_pengiriman' => 'array',
        'documentations' => 'array',
        'on_delay' => 'boolean',
        'production_has_download_spk_pdf' => 'boolean',
        'is_picked_up_by_customer' => 'boolean',
        'is_revision' => 'boolean',
        'is_booked' => 'boolean',
        'is_using_old_stock' => 'boolean',
        'is_using_company_driver' => 'boolean',
    ];

    protected $appends = [
        'status_description',
        'status_nomor_tagihan_description',
        'status_approval_description',
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function updateBy()
    {
        return $this->belongsTo(User::class, 'update_by', 'id');
    }

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function onDelayBy()
    {
        return $this->belongsTo(User::class, 'on_delay_by', 'id');
    }

    public function pengirimanUpdatedBy()
    {
        return $this->belongsTo(User::class, 'pengiriman_updated_by', 'id');
    }

    public function noTagihanUpdatedBy()
    {
        return $this->belongsTo(User::class, 'no_tagihan_updated_by', 'id');
    }

    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by', 'id');
    }

    public function latesRevisionRequestBy()
    {
        return $this->belongsTo(User::class, 'latest_revision_request_by', 'id');
    }

    public function cancelRequestBy()
    {
        return $this->belongsTo(User::class, 'cancel_request_by', 'id');
    }

    public function cancelRequestValidatedBy()
    {
        return $this->belongsTo(User::class, 'cancel_request_validated_by', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(\App\Models\Invoice::class, 'nomor_tagihan', 'no_faktur_pajak');
    }

    public function purchasingRequests()
    {
        return $this->hasMany(\App\Models\Spk\PurchasingRequest::class, 'id_spk', 'id');
    }

    public function spkHistories()
    {
        return $this->hasMany(\App\Models\Spk\SpkHistory::class, 'spk_id', 'id');
    }

    public function laporanFondasi()
    {
        return $this->hasMany(\App\Models\Spk\LaporanFondasi::class, 'id_spk', 'id');
    }

    public function project()
    {
        return $this->hasOne(\App\Models\Spk\Project::class, 'spk_id', 'id');
    }

    public function production()
    {
        return $this->hasOne(\App\Models\Spk\Production::class, 'id_spk', 'id');
    }

    public function deliveries()
    {
        return $this->hasMany(\App\Models\Spk\SpkDelivery::class, 'id_spk', 'id');
    }

    public function latestDelivery()
    {
        return $this->hasOne(SpkDelivery::class, 'id_spk')
            ->latestOfMany(); // Laravel 9+
    }

    public function receivableHistories()
    {
        return $this->hasMany(ReceivableHistory::class, 'spk_id', 'id');
    }

    public function getStatusNomorTagihanDescriptionAttribute(): string
    {
        $status = (bool) ($this->attributes['status_nomor_tagihan'] ?? false);

        return match ($status) {
            true => 'Nomor tagihan sudah diassign.',
            false => 'Nomor tagihan belum diassign.',
        };
    }

    public function getStatusDescriptionAttribute(): string
    {
        $status = (int) ($this->attributes['status'] ?? 0);

        return match ($status) {
            0 => 'SPK telah dibuat',
            1 => 'Menunggu Gudang Assign PR',
            2 => 'Dalam proses produksi',
            3 => 'Sedang diproses Purchasing untuk pengiriman',
            4 => 'Dalam proses penagihan',
            5 => 'Dalam proses pemasangan',
            6 => 'Finished',
            default => 'Status SPK tidak diketahui',
        };
    }

    public function getStatusApprovalDescriptionAttribute(): string
    {
        $status = (int) ($this->attributes['status_approval'] ?? null);

        return match ($status) {
            0 => 'Menunggu Validasi',
            1 => 'Sudah Disetujui',
            2 => 'Ditolak',
            3 => 'Butuh Revisi',
            4 => 'Dibatalkan',
            default => 'Status Approval tidak diketahui',
        };
    }
}
