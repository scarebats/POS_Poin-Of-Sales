<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 't_stok';
     protected $primaryKey = 'stok_id';
     protected $fillable = ['barang_id', 'user_id', 'stok_jumlah','supplier_id','stok_tanggal'];
 
     public function barang() {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }

    public function supplier() {
        return $this->belongsTo(SupplierModel::class, 'supplier_id');
    }
}