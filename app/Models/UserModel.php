<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table = 'm_user'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //Mendefinisikan primary key dari tabel
    protected $fillable = ['level_id','username','nama','password'];
    protected $hidden = ['password']; // tidak ditampilkan saat select
    protected $casts = ['password' => 'hashed'];//casting password agar otomatis di gasg
    public function level(): BelongsTo 
    {
        return $this->belongsTo(LevelModel::class, 'level_id','level_id');
    }
    
    public function getRoleName() : string {
        return $this->level->level_nama; // mendapatkan nama role
    }

    public function hasRole($role): bool {
        return $this->level && $this->level->level_kode === $role;
    }
    
    public function getRole(){
        return $this->level->level_kode; //mengecek apakah sebuah user memiliki role
    }
}