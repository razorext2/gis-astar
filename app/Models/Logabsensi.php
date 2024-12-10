<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logabsensi extends Model
{
    use HasFactory;

    protected $table = 'tbllog';
    protected $fillable = ['nik', 'kodejari', 'waktu', 'lokasifoto', 'upl', 'upl68', 'uplm68', 'upljam', 'jenis', 'waktuori', 'KodeBarcode', 'status'];
}
