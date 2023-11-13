<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class BeasiswaPenmaru extends Model
{
    use HasFactory;

    protected $table = 'BOBBY21.V_BEASISWA';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'mhs_nim',
        'semester',
        'jns_beasiswa',
        'prosentase',
    ];

    protected $appends = ['kode_jns_bea_aak'];



    // NOTE : Kenapa developer menambahkan atribut "kode_jns_bea_aak", padahal isinya adalah "jns_beasiswa"?
    // Agar kedepannya tidak lupa dan bingung, karena ada 2 model Jenis Beasiswa yaitu model JenisBeasiswaAak dan JenisBeasiswaPmb
    // disini yang digunakan adalah kode dari model JenisBeasiswaAak

    // ACCESSOR
    public function getKodeJnsBeaAakAttribute()
    {
        return $this->jns_beasiswa;
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
                BOBBY21.INS_BEA_PENMARU (
                    :mhs_nim,
                    :semester,
                    :kode_jns_bea_aak,
                    :prosentase
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('mhs_nim', $this->mhs_nim);
        $stmt->bindValue('semester', $this->semester);
        $stmt->bindValue('kode_jns_bea_aak', $this->kode_jns_bea_aak);
        $stmt->bindValue('prosentase', $this->prosentase);
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
                BOBBY21.UPD_BEA_PENMARU (
                    :mhs_nim,
                    :semester,
                    :kode_jns_bea_aak,
                    :prosentase
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('mhs_nim', $this->mhs_nim);
        $stmt->bindValue('semester', $this->semester);
        $stmt->bindValue('kode_jns_bea_aak', $this->kode_jns_bea_aak);
        $stmt->bindValue('prosentase', $this->prosentase);
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
                BOBBY21.DEL_BEA_PENMARU (
                    :mhs_nim,
                    :semester,
                    :kode_jns_bea_aak
                );

            END;
        SQL;

        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('mhs_nim', $this->mhs_nim);
        $stmt->bindValue('semester', $this->semester);
        $stmt->bindValue('kode_jns_bea_aak', $this->kode_jns_bea_aak);
        $stmt->execute();

        $this->exists = false;
    }
}
