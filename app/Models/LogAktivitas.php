<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'tb_log_aktivitas';
    protected $primaryKey = 'id_log';
    public $timestamps = false; 

    protected $fillable = [
        'id_user',
        'aktivitas',
        'waktu_aktivitas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public static function catat($pesan)
    {
        if (Auth::check()) {
            self::create([
                'id_user' => Auth::user()->id_user, 
                'aktivitas' => $pesan, 
                'waktu_aktivitas' => \Carbon\Carbon::now()
            ]);
        }
    }
}