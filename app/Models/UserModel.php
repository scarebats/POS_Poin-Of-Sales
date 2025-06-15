<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LevelModel;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //Mendefinisikan primary key dari tabel
    protected $fillable = ['username','password','nama','level_id','createrd_at','updated_at'];
    protected $hidden = ['password']; // tidak ditampilkan saat select
    protected $casts = ['password' => 'hashed'];//casting password agar otomatis di gasg

    public function level(): BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
