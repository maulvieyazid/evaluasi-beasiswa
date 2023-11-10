<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class LogKesimpulan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mhs_nim',
        'jns_beasiswa',
        'smt',
        'nm_user',
        'sts_old',
        'sts_new',
        'ket_old',
        'ket_new',
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
                BOBBY21.INS_BEASISWA_LOGSIMPULAN (
                    :mhs_nim,
                    :jns_beasiswa,
                    :smt,
                    TO_DATE(:tgl_log, 'YYYY-MM-DD HH24:MI:SS'),
                    :nm_user,
                    :sts_old,
                    :sts_new,
                    :ket_old,
                    :ket_new
                );

            END;
        SQL;


        $stmt = DB::getPdo()->prepare($sql);
        $stmt->bindValue('mhs_nim', $this->mhs_nim);
        $stmt->bindValue('jns_beasiswa', $this->jns_beasiswa);
        $stmt->bindValue('smt', $this->smt);
        $stmt->bindValue('tgl_log', now()->format('Y-m-d H:i:s'));
        $stmt->bindValue('nm_user', $this->nm_user);
        $stmt->bindValue('sts_old', $this->sts_old);
        $stmt->bindValue('sts_new', $this->sts_new);
        $stmt->bindValue('ket_old', $this->ket_old);
        $stmt->bindValue('ket_new', $this->ket_new);
        $stmt->execute();


        // We will go ahead and set the exists property to true, so that it is set when
        // the created event is fired, just in case the developer tries to update it
        // during the event. This will allow them to do so and run an update here.
        $this->exists = true;

        $this->wasRecentlyCreated = true;

        $this->fireModelEvent('created', false);

        return true;
    }
}
