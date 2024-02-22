<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBeasiswaPmb extends Model
{
    use HasFactory, Compoships;

    const KULIAH_0_RUPIAH = 25;

    protected $table = 'BOBBY21.V_JNS_BEAPMB';

    public $timestamps = false;

    public $incrementing = false;


    // ACCESSOR
    /*
     | Accessor ini untuk mengecek apakah beasiswa ini adalah beasiswa saudara
    */
    public function getIsBeasiswaSaudaraAktifAttribute()
    {
        // Ubah keterangan menjadi uppercase
        $teks = strtoupper($this->keterangan);

        // Kata-kata yang ingin diperiksa keberadaannya
        $kata_kunci = array("SAUDARA", "MAHASISWA AKTIF");

        // Penanda jika semua kata kunci ditemukan di dalam teks
        $semua_kata_ditemukan = true;

        // Periksa keberadaan setiap kata kunci dalam teks
        foreach ($kata_kunci as $kata) {
            if (stripos($teks, $kata) === false) {
                $semua_kata_ditemukan = false;
                break;
            }
        }

        return $semua_kata_ditemukan;
    }

    /*
     | Accessor ini untuk mengambil teks tahun pada keterangan beasiswa
    */
    public function getTahunBeasiswaSaudaraAktifAttribute()
    {
        // Cari pola tahun dalam format empat digit, jika ditemukan maka masukkan ke variabel matches
        preg_match('/\b\d{4}\b/', $this->keterangan, $matches);

        // matches bernilai array, kalo matches nya tidak kosong, maka ambil index 0
        $tahun = !empty($matches) ? $matches[0] : null;

        return $tahun;
    }

    // RELATIONSHIP
    public function jns_bea_aak()
    {
        return $this->hasOne(JenisBeasiswaAak::class, 'jns_beasiswa_penmaru', 'kd_jenis');
    }

    public function syarat()
    {
        return $this->hasMany(SyaratBeasiswa::class, 'jenis_beasiswa', 'kd_jenis');
    }


    /*
     | WARNING : Fungsi ini dibuat karena ada permintaan / kondisi khusus dari PENMARU yaitu,
     | Jika mahasiswa mendapatkan Beasiswa Saudara Mahasiswa Aktif (mendapatkan beasiswa karena ada saudaranya yang sudah menjadi mahasiswa duluan),
     | maka pada saat proses evaluasi beasiswa perlu dicek dulu apakah saudara nya mahasiswa tersebut masih aktif atau mungkin sudah lulus
     | kalau saudaranya sudah lulus / tidak aktif, maka beasiswa nya harus diganti menjadi Beasiswa Alumni.
    */
    public static function getKodeJenisBeasiswa($nim, $kd_jns_bea_pmb)
    {
        // Select data beasiswa nya
        $beasiswa = JenisBeasiswaPmb::where('kd_jenis', $kd_jns_bea_pmb)->first();

        // Kalau beasiswa nya BUKAN beasiswa saudara aktif, maka return kode jenis nya langsung
        if (!$beasiswa->is_beasiswa_saudara_aktif) return $beasiswa->kd_jenis;

        // Kalau beasiswa nya beasiswa saudara aktif, maka
        // Ambil tahun dari beasiswa saudara aktif
        $tahun = $beasiswa->tahun_beasiswa_saudara_aktif;

        // Ambil nim saudaranya mahasiswa
        $nim_saudara = Mahasiswa::getNimSaudara($nim);

        // Kalo nim saudaranya null, maka return kode jenis nya langsung
        if (!$nim_saudara) return $beasiswa->kd_jenis;

        // Kalo nim suadaranya ENGGAK null, maka cek apakah saudaranya masih aktif
        $is_mhs_masih_aktif = HisMf::isMhsMasihAktif($nim_saudara);

        // Kalo saudaranya masih aktif, berarti mhs ini masih mendapatkan beasiswa saudara aktif
        // maka return kode jenis nya langsung
        if ($is_mhs_masih_aktif) return $beasiswa->kd_jenis;

        // Kalo saudaranya sudah tidak aktif / sudah lulus, maka ganti kode jenis beasiswa nya dengan beasiswa alumni
        // Ambil data beasiswa alumni yang mengandung tahun yang sama dengan beasiswa saudara aktif
        $bea_alumni = JenisBeasiswaPmb::query()
            ->whereRaw("UPPER(keterangan) LIKE '%SAUDARA%'")
            ->whereRaw("UPPER(keterangan) LIKE '%ALUMNI%'")
            ->whereRaw("UPPER(keterangan) LIKE '%$tahun%'")
            ->orderBy('kd_jenis', 'desc')
            ->first();

        // Kalau data beasiswa alumni nya null, maka return kode jenis beasiswa saudara aktif yg sebelumnya saja
        if (!$bea_alumni) return $beasiswa->kd_jenis;

        // Kalau ada, maka return kode jenis beasiswa alumni
        return $bea_alumni->kd_jenis;
    }
}
