<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent;

class SimpulBagian extends Model
{
    use HasFactory, Compoships;

    const LOLOS = 'Y';
    const TIDAK_LOLOS = 'T';

    protected $table = 'BOBBY21.V_BEASISWA_SIMPULBAGIAN';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'bagian',
        'tgl',
        'mhs_nim',
        'jns_beasiswa',
        'smt',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tgl' => 'datetime',
    ];


    // RELATIONSHIP
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'bagian', 'kode');
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
                BOBBY21.INS_BEASISWA_SIMPULBAGIAN (
                    :bagian,
                    SYSDATE,
                    :mhs_nim,
                    :jns_beasiswa,
                    :smt,
                    :status,
                    :keterangan
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('bagian', $this->bagian);
        $stmt->bindValue('mhs_nim', $this->mhs_nim);
        $stmt->bindValue('jns_beasiswa', $this->jns_beasiswa);
        $stmt->bindValue('smt', $this->smt);
        $stmt->bindValue('status', $this->status);
        $stmt->bindValue('keterangan', $this->keterangan);
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
                BOBBY21.UPD_BEASISWA_SIMPULBAGIAN (
                    :bagian,
                    TO_DATE(:tgl, 'YYYY-MM-DD HH24:MI:SS'),
                    :mhs_nim,
                    :jns_beasiswa,
                    :smt,
                    :status,
                    :keterangan
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('bagian', $this->bagian);
        $stmt->bindValue('tgl', $this->tgl->format('Y-m-d H:i:s'));
        $stmt->bindValue('mhs_nim', $this->mhs_nim);
        $stmt->bindValue('jns_beasiswa', $this->jns_beasiswa);
        $stmt->bindValue('smt', $this->smt);
        $stmt->bindValue('status', $this->status);
        $stmt->bindValue('keterangan', $this->keterangan);
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
                BOBBY21.DEL_BEASISWA_SIMPULBAGIAN (
                    :bagian,
                    TO_DATE(:tgl, 'YYYY-MM-DD HH24:MI:SS'),
                    :mhs_nim,
                    :jns_beasiswa,
                    :smt
                );

            END;
        SQL;

        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('bagian', $this->bagian);
        $stmt->bindValue('tgl', $this->tgl->format('Y-m-d H:i:s'));
        $stmt->bindValue('mhs_nim', $this->mhs_nim);
        $stmt->bindValue('jns_beasiswa', $this->jns_beasiswa);
        $stmt->bindValue('smt', $this->smt);
        $stmt->execute();

        $this->exists = false;
    }
}
