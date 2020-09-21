<?php

session_start();
include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../403');
} else {
    
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y H:i:s', time());
    $kd_daftar = $_GET['kd_daftar'];
    $query = "SELECT
            user_mhs.username
            , user_mhs.nama_mhs
            , user_mhs.email
            , user_mhs.no_telp
            , pendaftaran.kd_daftar
            , ref_fakultas.kd_fakultas as KD_REF_FAKULTAS
            , ref_fakultas.nama_fakultas
            , ref_prodi.kd_prodi as KD_REF_PRODI
            , ref_prodi.nama_prodi
            FROM user_mhs
            JOIN pendaftaran, ref_fakultas, ref_prodi 
            WHERE pendaftaran.kd_daftar = ? AND pendaftaran.nim = user_mhs.username AND user_mhs.kd_fakultas = ref_fakultas.kd_fakultas AND user_mhs.kd_prodi = ref_prodi.kd_prodi";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $kd_daftar);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // get data pendaftaran

    $querydaftar = "SELECT pendaftaran.*
    , beasiswa.id_bsw
    , beasiswa.kd_bsw AS KODE_BSW
    , beasiswa.nama_bsw
    FROM pendaftaran
    JOIN beasiswa
    WHERE pendaftaran.kd_daftar = ? AND pendaftaran.kd_bsw = beasiswa.id_bsw LIMIT 1";
    $stmtdaftar = $con->prepare($querydaftar);
    $stmtdaftar->bind_param("s", $kd_daftar);
    $stmtdaftar->execute();
    $result = $stmtdaftar->get_result();
    $daftar = $result->fetch_assoc();
    $filename = $daftar['kd_daftar']."_".$row['username']."_".$row['nama_mhs']."_".$daftar['thn_ajaran']."_".$daftar['semester'].".pdf";
    $content = '
	<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>'.$filename.'</title>
    <link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
</head>
<style>
p.uppercase {
  text-transform: uppercase;
}

p.lowercase {
  text-transform: lowercase;
}

p.capitalize {
  text-transform: capitalize;
}
</style>
<body>
    <table style="width:100%;">
        <tbody>
            <tr>
                <td><img src="js/mpdf/logo-ukdw.png" style="width:60px;"></img></td>
                <td>
                    <p> </p>
                </td>
                <td>
                    <p style="font-size:12px;">BIRO KEMAHASISWAAN, ALUMNI DAN PENGEMBANGAN KARIR</p>
                    <h3 style="color:#5e72e4;">UNIVERSITAS KRISTEN DUTA WACANA</h3>
                    <p style="font-size:10px;">Gedung Hagios Lantai 1, Jln. Dr. Wahidin 5-25 Yogyakarta 55224</p>
                    <p style="font-size:10px;">Telp : 0274-563929 (hunting) ext.103 | Fax : 0274-513235</p>
                    <p style="font-size:10px;">Email : biro3@staff.ukdw.ac.id</p>
                    </td>
                <td style="text-align:right">
                    <h3 style="right: 50mm; top: 60mm; border: 0.5mm solid #000000; text-align:
center; padding: 2mm; padding-top: 4mm;text-align: right;">&nbsp; ' . $daftar['KODE_BSW'] . ' &nbsp;</h3>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <div width="100%">
        <div width="100%">
            <table style="width:100%;">
                <tbody>
                    <tr>
                        <td>
                            <p class="uppercase" >FORMULIR PENGAJUAN <span style="color:#5e72e4;"><strong> ' . $daftar['nama_bsw'] . '
                                    </strong></span></p>
                        </td>
                        <td rowspan="2" class="barcodecell" style="text-align:right">
                            <div style="float: right; width:50%;">
                                <barcode code="'. $daftar['kd_daftar'].'" type="C128B" class="barcode"
                                    style="text-align: right; width:258px;" size="0.8" />
                                <div style="font-family: ocrb; font-size:12px;">
                                    <center>KD DAFTAR: ' . $daftar['kd_daftar'] . '</center>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="uppercase">SEMESTER <strong> <span style="color:#5e72e4;">' . $daftar['semester'] . '</span> </strong> TAHUN AKADEMIK
                                <span style="color:#5e72e4;"><strong>' . $daftar['thn_ajaran'] . '</strong></span></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
	<br>
    <br>
    <div style="width: 100%;">
    <div align="left" style="width: 50%; float: left;">
    <table style="float: left;font-size:12px;">
        <tbody>
            <tr>
                <td>
                    <p>NAMA </p>
                </td>
                <td>
                    <p class="uppercase">: <strong>' . $row['nama_mhs'] . '</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>NIM </p>
                </td>
                <td>
                    <p>: <strong>' . $row['username'] . '</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>FAKULTAS </p>
                </td>
                <td>
                    <p class="uppercase">: <strong>' . $row['nama_fakultas'] . '</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>PROGRAM STUDI </p>
                </td>
                <td>
                    <p class="uppercase">: <strong>' . $row['nama_prodi'] . '</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>EMAIL MAHASISWA </p>
                </td>
                <td>
                    <p>: <strong>' . $row['email'] . '</strong></p>
                </td>
            </tr>
            <tr>
            <td>
                <p>TELP MAHASISWA </p>
            </td>
            <td>
                <p>: <strong>' . $row['no_telp'] . '</strong></p>
            </td>
        </tr>
        </tbody>
    </table>
    </div>

    <div align="left" style="width: 50%; float: left;">
    <table style="font-size:12px;">
        <tbody>
            <tr>
                <td>
                    <p>IPK </p>
                </td>
                <td>
                    <p>: <strong>' . $daftar['ipk'] . '</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                <p>TELP ORANG TUA </p>
            </td>
            <td>
                <p>: <strong>' . $daftar['no_telp_ortu'] . '</strong></p>
            </td>
            </tr>
            <tr>
                <td>
                <p> PEKERJAAN ORANG TUA </p>
            </td>
            <td>
                <p class="uppercase">: <strong>' . $daftar['pekerjaan_ortu'] . '</strong></p>
            </td>
            </tr>
            <tr>
                <td>
                    <p>INVOICE REGISTRASI </p>
                </td>
                <td>
                    <p>: <strong>Rp. ' . number_format($daftar['nominal_pengajuan'], 0, ',', '.') . '</strong></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>


    </div>';

    $content2 = '
    <br>
    
        <p style="color:#5e72e4;"> <strong>PERSYARATAN YANG DIPENUHI :</strong> </p>
        <table >
            <tbody>
    ';
        $kd_daftar = $_GET['kd_daftar'];
        $sql_syarat = "SELECT
        syarat_daftar.isi_syarat As isi_syarat
        , pendaftaran.kd_daftar AS kd_daftar
        , syarat_bsw.kd_syarat_bsw
        , ref_syarat.nama_syarat
        FROM pendaftaran, syarat_bsw, ref_syarat
        JOIN syarat_daftar WHERE pendaftaran.kd_daftar = syarat_daftar.kd_daftar AND
        syarat_daftar.kd_daftar =? AND syarat_bsw.kd_syarat_bsw = syarat_daftar.kd_syarat_bsw AND syarat_bsw.kd_syarat = ref_syarat.kd_syarat";
        $stmtdoc = $con->prepare($sql_syarat);
        $stmtdoc->bind_param("s", $kd_daftar);
        $stmtdoc->execute();
        $resultdocument = $stmtdoc->get_result();
        if ($resultdocument->num_rows > 0) {
            while ($rowdocument = $resultdocument->fetch_assoc()) {
                $content3 .= '
                <tr>
                    <td><span style="font-family: fontawesome">&#xf058;</span></td>
                    <td>
                        <p>'.$rowdocument['nama_syarat'].'</p><span style="font-size:11px;">('.$rowdocument['isi_syarat'].')</span>
                    </td>
                </tr>
                ';
    
            }
            
        } else {
            $content3 = '<tr>
            <td><span style="font-family: fontawesome">&#xf057;</span></td>
            <td>
                <p class="uppercase"> Berkas Digital tidak tersedia. </p>
            </td>
        </tr>';
        }
        $content4 = ' 
            </tbody>
        </table>
    
        ';

    
    $content5 = '<br>
    <p style="color:#5e72e4;"> <strong>DISELEKSI OLEH :</strong> </p>
    <table >
        <tbody>';
    
        $kd_daftar = $_GET['kd_daftar'];
        $sql_acc = "SELECT 
        sts_daftar.acc_tanggal
        , user_acc.nama_acc
        , ref_role.nama_role
        FROM sts_daftar
        JOIN user_acc, ref_role
        WHERE sts_daftar.kd_daftar=? AND sts_daftar.acc_username = user_acc.username AND sts_daftar.acc_role = ref_role.kd_role ORDER BY sts_daftar.acc_role DESC
        ";
        $stmtacc = $con->prepare($sql_acc);
        $stmtacc->bind_param("s", $kd_daftar);
        $stmtacc->execute();
        $resultacc = $stmtacc->get_result();
        if ($resultacc->num_rows > 0) {
            while ($rowacc = $resultacc->fetch_assoc()) {
                $content6 .= '
                <tr>
                <td><span style="font-family: fontawesome">&#xf2bd;</span></td>
                <td>
                    <p>'.$rowacc['nama_role']. ',<span><b> ' .$rowacc['nama_acc'].'</b></span> pada <span><b>'. date('d/m/Y H:i', strtotime($rowacc['acc_tanggal'])).' WIB</b></span></p>
                </td>
            </tr>';
            }
            
        } else {
            $content6 = '<tr>
            <td><span style="font-family: fontawesome">&#xf2bd;</span></td>
            <td>
                <p class="uppercase">Data tidak tersedia</p>
            </td>
        </tr>';
        }

$content7 = '
        </tbody>
    </table>
</body>
</html>
    ';



    require_once "js/mpdf/vendor/autoload.php";
    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/custom/font/directory',
        ]),
        'fontdata' => $fontData + [
            'fontawesome' => [
                'R' => 'fontawesome.ttf'
            ]
        ],
        'default_font' => 'calibri',
        'format' => 'A4'
    ]);

    $logo = '<img src="js/mpdf/logo-sib.png" style="width:35px;"></img>';
    $mpdf->setFooter('' . $logo . ' Sistem Informasi Beasiswa UKDW || Diunduh pada : ' . $currentTime . ' WIB');
    $mpdf->AddPage("P", "", "", "", "", "15", "15", "15", "15", "", "", "", "", "", "", "", "", "", "", "", "A4");
    $mpdf->WriteHTML($content);
    $mpdf->WriteHTML($content2);
    $mpdf->WriteHTML($content3);
    $mpdf->WriteHTML($content4);
    $mpdf->WriteHTML($content5);
    $mpdf->WriteHTML($content6);
    $mpdf->WriteHTML($content7);
    $filename = $daftar['kd_daftar']."_".$row['username']."_".$row['nama_mhs']."_".$daftar['thn_ajaran']."_".$daftar['semester'].".pdf";
    $mpdf->Output($filename,'I');
}
