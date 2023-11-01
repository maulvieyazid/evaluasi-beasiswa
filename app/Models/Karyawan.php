<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Authenticatable
{
    use HasFactory;

    protected $table = 'BOBBY21.V_KARYAWAN';

    /*
    | Agar login menggunakan model custom tidak bermasalah
    | maka 2 atribut di bawah ini harus selalu di set,
    | yaitu $primaryKey dan $keyType
    */
    protected $primaryKey = 'nik';

    protected $keyType = 'string';

    public $timestamps = false;

    public $incrementing = false;

    protected $appends = ['inisial'];


    // ACCESSOR
    public function getInisialAttribute()
    {
        // Melakukan explode per spasi, lalu menggunakan array_map untuk mengambil huruf pertama dan menjadikan uppercase
        // setelah itu digabung dengan menggunakan implode
        $initials = implode('', array_map(function ($word) {
            return strtoupper(substr($word, 0, 1));
        }, explode(" ", $this->nama)));

        // Mengambil 2 karakter di depan
        $initials = substr($initials, 0, 2);

        return $initials;
    }


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Custom Select
        static::addGlobalScope('custom_select', function (Builder $builder) {
            $builder->select('NIK', 'NAMA', 'BAGIAN', 'STATUS');
        });

        // IS_KEUANGAN
        static::addGlobalScope('is_keuangan', function (Builder $builder) {
            $builder->selectRaw("(CASE WHEN BAGIAN = 28 THEN 1 ELSE NULL END) AS IS_KEUANGAN");
        });

        // IS_KABAG_KEUANGAN
        static::addGlobalScope('is_kabag_keuangan', function (Builder $builder) {
            $departemen = Departemen::make()->getTable();
            $builder->selectRaw("(CASE WHEN EXISTS(SELECT 1 FROM {$departemen} WHERE KODE = 28 AND MANAGER_ID = NIK) THEN 1 ELSE NULL END) AS IS_KABAG_KEUANGAN");
        });

        // IS_KMHS
        static::addGlobalScope('is_kmhs', function (Builder $builder) {
            $builder->selectRaw("(CASE WHEN BAGIAN = 9 THEN 1 ELSE NULL END) AS IS_KMHS");
        });

        // IS_KABAG_KMHS
        static::addGlobalScope('is_kabag_kmhs', function (Builder $builder) {
            $departemen = Departemen::make()->getTable();
            $builder->selectRaw("(CASE WHEN EXISTS(SELECT 1 FROM {$departemen} WHERE KODE = 9 AND MANAGER_ID = NIK) THEN 1 ELSE NULL END) AS IS_KABAG_KMHS");
        });
    }


    // SCOPES
    public function scopeAktif($query)
    {
        return $query->where('status', 'A');
    }
}
