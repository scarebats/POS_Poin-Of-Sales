<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang'; // Nama tabel di database
    protected $primaryKey = 'barang_id'; // Primary key tabel

    protected $fillable = ['barang_id','kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'stok'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    public function stok(): BelongsTo
    {
        return $this->belongsTo(StokModel::class, 'stok_id', 'stok_id');
    }

}