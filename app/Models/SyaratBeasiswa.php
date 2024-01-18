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
    | Ini adalah isi dari kolom 'baca_nilai' yang digunakan untuk Auto Centang / Autocheck Evaluasi
    */
    const IPS = 'IPS';
    const STSKULIAH = 'STSKULIAH';


    protected $table = 'BOBBY21.V_BEASISWA_SYARAT';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'jenis_beasiswa',
        'kd_syarat',
        'nm_syarat',
        'nil_min',
        'bagian_validasi',
        'baca_nilai',
    ];


    // RELATIONSHIP
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'bagian_validasi', 'kode');
    }

    public function syarat_peserta()
    {
        return $this->belongsTo(SyaratPesertaBeasiswa::class, 'kd_syarat', 'kd_syarat');
    }





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
                    :bagian_validasi,
                    :baca_nilai
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('jenis_beasiswa', $this->jenis_beasiswa);
        $stmt->bindValue('kd_syarat', $this->kd_syarat);
        $stmt->bindValue('nm_syarat', $this->nm_syarat);
        $stmt->bindValue('nil_min', $this->nil_min);
        $stmt->bindValue('bagian_validasi', $this->bagian_validasi);
        $stmt->bindValue('baca_nilai', $this->baca_nilai);
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
                    :bagian_validasi,
                    :baca_nilai
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('jenis_beasiswa', $this->jenis_beasiswa);
        $stmt->bindValue('kd_syarat', $this->kd_syarat);
        $stmt->bindValue('nm_syarat', $this->nm_syarat);
        $stmt->bindValue('nil_min', $this->nil_min);
        $stmt->bindValue('bagian_validasi', $this->bagian_validasi);
        $stmt->bindValue('baca_nilai', $this->baca_nilai);
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
