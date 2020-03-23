<?php

namespace App\Libraries;

class Common
{
    /**
     * konversi angka menjadi format rupiah
     * @param integer $angka
     * @return string $rupiah
     */
    public function rupiah($angka)
    {
        $rupiah = number_format($angka, 0, ',', '.');
        return $rupiah;
    }

    /**
     * konversi format angka menjadi terbilang
     * @param int $angka
     * @return string $terbilang;
     */
    public function terbilang($angka) {
        $angka = floatval($angka);
        $bilangan = ['','Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        if ($angka < 12) {
            return $bilangan[$angka];
        } else if ($angka < 20) {
            return $bilangan[$angka - 10] . ' Belas';
        } else if ($angka < 100) {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } else if ($angka < 200) { 
            return sprintf('Seratus %s', self::terbilang($angka - 100));
        } else if ($angka < 1000) { 
            $hasil_bagi = (int)($angka / 100);
            $hasil_mod = $angka % 100;
            return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], self::terbilang($hasil_mod)));
        } else if ($angka < 2000) {
            return trim(sprintf('Seribu %s', self::terbilang($angka - 1000)));
        } else if ($angka < 1000000) { 
            $hasil_bagi = intval($angka / 1000);
            $hasil_mod = $angka % 1000;
            return sprintf('%s Ribu %s', self::terbilang($hasil_bagi), self::terbilang($hasil_mod));
        } else if ($angka < 1000000000) {
            $hasil_bagi = intval($angka / 1000000);
            $hasil_mod = $angka % 1000000;
            return trim(sprintf('%s Juta %s', self::terbilang($hasil_bagi), self::terbilang($hasil_mod)));
        } else if ($angka < 1000000000000) { 
            $hasil_bagi = intval($angka / 1000000000);
            $hasil_mod = fmod($angka, 1000000000);
            return trim(sprintf('%s Milyar %s', self::terbilang($hasil_bagi), self::terbilang($hasil_mod)));
        } else if ($angka < 1000000000000000) {
            $hasil_bagi = $angka / 1000000000000;
            $hasil_mod = fmod($angka, 1000000000000);
            return trim(sprintf('%s Triliun %s', self::terbilang($hasil_bagi), self::terbilang($hasil_mod)));
        } else {
            return false;
        }
    }
    
    /**
     * ekstrak tahun dari parameter date
     * @param string $date
     * @return string $year
     */
    public function generate_year_from_date($date)
    {
        $year = explode('-', $date);
        return $year[0];
    }
    
    /**
     * menampilkan daftar bulan
     * @return array $month
     */
    public function generate_integer_month()
    {
        $month = [];
        $month['1'] = 'Januari';
        $month['2'] = 'Februari';
        $month['3'] = 'Maret';
        $month['4'] = 'April';
        $month['5'] = 'Mei';
        $month['6'] = 'Juni';
        $month['7'] = 'Juli';
        $month['8'] = 'Agustus';
        $month['9'] = 'September';
        $month['10'] = 'Oktober';
        $month['11'] = 'November';
        $month['12'] = 'Desember';

        return $month;
    }
    
    /**
     * menampilkan daftar tahun dimulai dari tahun sekarang hingga 5 tahun berikutnya
     * @return array $year
     */
    public function generate_year()
    {
        $current_year = date('Y');
        $year = [];
        for ($i = $current_year; $i <= $current_year + 5; $i++) {
            array_push($year, $i);
        }
        return $year;
    }
    
    /**
     * extract romance format from golongan
     * @param string $golongan
     * @return string $splitted_golongan
     */
    public function split_golongan($golongan)
    {
        $splitted_golongan = explode('/', $golongan);
        return $splitted_golongan[0];
    }

    /**
     * menggabungkan golongan dan sub golongan
     * @param string $golongan
     * @return string $joined_golongan
     */
    public function join_golongan($golongan)
    {
        if ($golongan != '') {
            $subgolongan = ['a','b','c','d'];
            $joined_golongan = [];
            foreach ($subgolongan as $v) {
                array_push($joined_golongan, $golongan . '/' . $v);
            }
            return $joined_golongan;
        } else {
            return $golongan;
        }
    }
    
    /**
     * convert romance format for eselon to mysql column format
     * @param string $golongan
     * @param string $eselon
     * @return string $callback
     */
    public function generate_eselon($golongan, $eselon)
    {
        $callback = '';
        if ($eselon != '') {
            switch ($eselon) {
                case 'II':
                    $callback = 'eselon_2';
                    break;
                case 'III':
                    $callback = 'eselon_3';
                    break;
                case 'IV':
                    $callback = 'eselon_4_gol_3_4';
                    break;
            }
        } else {
            switch ($golongan) {
                case 'IV':
                    $callback = 'eselon_4_gol_3_4';
                    break;
                case 'III':
                    $callback = 'eselon_4_gol_3_4';
                    break;
                case 'II':
                    $callback = 'gol_1_2';
                    break;
                case 'I':
                    $callback = 'gol_1_2';
                    break;
            }
        }
        return $callback;
    }
    
    /**
     * convert romance format for golongan to mysql column format
     * @param string $golongan
     * @return string
     */
    public function generate_golongan($golongan)
    {
        switch ($golongan) {
            case 'IV':
                return "gol_4";
                break;
            case 'III':
                return "gol_3";
                break;
            case 'II':
                return "gol_2";
                break;
            case 'I':
                return "gol_1";
                break;
        }
    }

    public function generate_golongan_list()
    {
        $golongan = [];
        $golongan['I'] = 'I';
        $golongan['II'] = 'II';
        $golongan['III'] = 'III';
        $golongan['IV'] = 'IV';

        return $golongan;
    }

    public function generate_eselon_list()
    {
        $eselon = [];
        $eselon['II'] = 'II';
        $eselon['III'] = 'II';
        $eselon['III'] = 'III';
        $eselon['IV'] = 'IV';

        return $eselon;
    }
}
