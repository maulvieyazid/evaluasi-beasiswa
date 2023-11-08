<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class SyaratBeasiswa extends Model
{
    use HasFactory, Compoships;

    /*
    | Ini adalah Penanda untuk digunakan di AUTOCHECK
    */
    const IPS = 'IPS';
    const STSKULIAH = 'STSKULIAH';


    /*
    | Variable di bawah ini digunakan untuk auto centang Bagian Keuangan di tampilan detil.
    | Saat ada syarat beasiswa yang kode nya masuk ke sini, maka lakukan pengecekan sesuai dengan penanda nya.
    | Misal: untuk jenis_beasiswa 25, dengan kd_syarat 3, itu harus mengecek ke nilai IPS mahasiswa, maka penanda nya dikasih IPS.
    | Nanti di view akan dicek IPS nya, kalau IPS nya memenuhi nil_min, maka checkbox nya akan otomatis tercentang.
    |
    | NOTE : ini memang harus DIINPUTKAN SECARA MANUAL,
    | karena aplikasi gk bisa tau syarat mana yang harus ngebaca IPS, syarat mana yang harus baca Status Kuliah, dsb
    |
    | Struktur nya seperti ini
    | [
    |    'jenis_beasiswa' => [
    |        'kd_syarat' => 'Penanda / Nilai yang akan dicek dengan syarat'
    |    ],
    | ]
    */
    const AUTOCHECK = [
        25 => [
            3 => self::IPS,
            4 => self::STSKULIAH,
        ],
    ];

    protected $table = 'BOBBY21.V_BEASISWA_SYARAT';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'jenis_beasiswa',
        'kd_syarat',
        'nm_syarat',
        'nil_min',
        'bagian_validasi',
    ];


    /**
     * Perform a model insert operation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return bool
     */
    protected function performInsert(Eloquent\Builder $query)
    {
        if ($this->fireModelEvent('creating') === false) {
            return false;
        }

        $sql = <<<SQL

            BEGIN
                BOBBY21.INS_BEASISWA_SYARAT (
                    :jenis_beasiswa,
                    :kd_syarat,
                    :nm_syarat,
                    :nil_min,
                    :bagian_validasi
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('jenis_beasiswa', $this->jenis_beasiswa);
        $stmt->bindValue('kd_syarat', $this->kd_syarat);
        $stmt->bindValue('nm_syarat', $this->nm_syarat);
        $stmt->bindValue('nil_min', $this->nil_min);
        $stmt->bindValue('bagian_validasi', $this->bagian_validasi);
        $stmt->execute();


        // We will go ahead and set the exists property to true, so that it is set when
        // the created event is fired, just in case the developer tries to update it
        // during the event. This will allow them to do so and run an update here.
        $this->exists = true;

        $this->wasRecentlyCreated = true;

        $this->fireModelEvent('created', false);

        return true;
    }


    /**
     * Perform a model update operation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return bool
     */
    protected function performUpdate(Eloquent\Builder $query)
    {
        // If the updating event returns false, we will cancel the update operation so
        // developers can hook Validation systems into their models and cancel this
        // operation if the model does not pass validation. Otherwise, we update.
        if ($this->fireModelEvent('updating') === false) {
            return false;
        }

        $sql = <<<SQL

            BEGIN
                BOBBY21.UPD_BEASISWA_SYARAT (
                    :jenis_beasiswa,
                    :kd_syarat,
                    :nm_syarat,
                    :nil_min,
                    :bagian_validasi
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('jenis_beasiswa', $this->jenis_beasiswa);
        $stmt->bindValue('kd_syarat', $this->kd_syarat);
        $stmt->bindValue('nm_syarat', $this->nm_syarat);
        $stmt->bindValue('nil_min', $this->nil_min);
        $stmt->bindValue('bagian_validasi', $this->bagian_validasi);
        $stmt->execute();

        return true;
    }







    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function performDeleteOnModel()
    {
        $sql = <<<SQL
            BEGIN
                BOBBY21.DEL_BEASISWA_SYARAT (
                    :jenis_beasiswa,
                    :kd_syarat
                );

            END;
        SQL;

        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('jenis_beasiswa', $this->jenis_beasiswa);
        $stmt->bindValue('kd_syarat', $this->kd_syarat);
        $stmt->execute();

        $this->exists = false;
    }
}
