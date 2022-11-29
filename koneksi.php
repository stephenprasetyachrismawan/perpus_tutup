<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_yahob";

$koneksi = mysqli_connect($host, $user, $password, $database);

date_default_timezone_set("Asia/Jakarta");
$query = "select * from peminjaman";
$sql = mysqli_query($koneksi, $query);

while ($row = mysqli_fetch_array($sql)) {
    $id_book = $row['id'];
    // $cektahun = 0;
    // $cekbulan = 0;
    // $cekhari = 0;
    // $cekjam = 0;
    // $cekmenit = 0;
    // $cekdetik = 0;
    $kemarin = date_create($row['tanggal_pinjam']);
    $waktusekarang = date("Y-m-d h:i:sa");
    $waktusekarang2 = date_create(date("Y-m-d h:i:sa"));

    $waktu00 = date_format(date_create("2022-01-01 12:00:00am"), "Y-m-d h:i:sa");
    $selisihjam = $kemarin->diff(new DateTime($waktusekarang), true);
    $cektahun = $selisihjam->y;
    $cekbulan = $selisihjam->m;
    $cekhari = $selisihjam->d;
    $cekjam = $selisihjam->h;
    $cekmenit = $selisihjam->i;
    $cekdetik = $selisihjam->s;
    $selisih00 = $kemarin->diff(new DateTime($waktu00), true);
    $sjam00 = $selisih00->h;
    $selisih001 = $waktusekarang2->diff(new DateTime($waktu00), true);
    $sjam001 = $selisih001->h + 86400;
    // function fy($cektahun)
    // {
    //     return $cektahun * 31536000;
    // }

    // function fm($cekbulan)
    // {
    //     return $cekbulan * 2628000;
    // }
    // function fd($cekhari)
    // {
    //     return $cekhari * 86400;
    // }
    // function fh($cekjam)
    // {
    //     return $cekjam * 3600;
    // }
    // function fi($cekmenit)
    // {
    //     return $cekmenit * 60;
    // }







    if ($cektahun > 0) {
        $query  = "DELETE from peminjaman where id = $id_book";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {

            header("location: $_SERVER[PHP_SELF]");
        }
    } else {
        if ($cekbulan > 0) {
            $query  = "DELETE from peminjaman where id = $id_book";
            $sql = mysqli_query($koneksi, $query);
            if ($sql) {

                header("location: $_SERVER[PHP_SELF]");
            }
        } else {
            if ($cekhari > 0) {
                if ($cekhari == 1) {

                    if ($sjam001 - $sjam00 < 86400) {
                        break;
                    } else {

                        $query  = "DELETE from peminjaman where id = $id_book";
                        $sql = mysqli_query($koneksi, $query);
                        if ($sql) {

                            header("location: $_SERVER[PHP_SELF]");
                        }
                    }
                } else {
                    $query  = "DELETE from peminjaman where id = $id_book";
                    $sql = mysqli_query($koneksi, $query);
                    if ($sql) {

                        header("location: $_SERVER[PHP_SELF]");
                    }
                }
            } else {
                if ($cekjam == 23 && $cekmenit == 59 && $cekdetik == 59) {
                    $query  = "DELETE from peminjaman where id = $id_book";
                    $sql = mysqli_query($koneksi, $query);
                    if ($sql) {

                        header("location: $_SERVER[PHP_SELF]");
                    }
                }
            }
        }
    }
}
