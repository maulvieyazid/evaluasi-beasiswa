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

    protected $appends = [
        'inisial',
        'is_keuangan',
        'is_kabag_keuangan',
        'is_kmhs',
        'is_kabag_kmhs',
        'is_penmaru',
        'is_kabag_penmaru',
    ];


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

    public function getIsKeuanganAttribute()
    {
        return $this->bagian == Departemen::KEUANGAN ? 1 : 0;
    }

    public function getIsKabagKeuanganAttribute()
    {
        $manager_id = $this->departemen->manager_id ?? null;

        return ($manager_id == $this->nik && $this->is_keuangan) ? 1 : 0;
    }

    public function getIsKmhsAttribute()
    {
        return $this->bagian == Departemen::KMHS ? 1 : 0;
    }

    public function getIsKabagKmhsAttribute()
    {
        $manager_id = $this->departemen->manager_id ?? null;

        return ($manager_id == $this->nik && $this->is_kmhs) ? 1 : 0;
    }

    public function getIsPenmaruAttribute()
    {
        return $this->bagian == Departemen::PENMARU ? 1 : 0;
    }

    public function getIsKabagPenmaruAttribute()
    {
        $manager_id = $this->departemen->manager_id ?? null;

        return ($manager_id == $this->nik && $this->is_penmaru) ? 1 : 0;
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

        // WITH departemen
        static::addGlobalScope('with_departemen', function (Builder $builder) {
            $builder->with('departemen:kode,nick,nama,manager_id');
        });
    }


    // Relationship
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'bagian', 'kode');
    }


    // SCOPES
    public function scopeAktif($query)
    {
        return $query->where('status', 'A');
    }
}
