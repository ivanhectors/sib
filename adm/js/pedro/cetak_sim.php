<?php

session_start();
include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../403');
} else {

    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y H:i:s', time());
    $kd_daftar = "1234-1234-567891";


    // get data pendaftaran

    $filename = "SIM_BARU_12341234567891.pdf";
    $content = '
	<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>' . $filename . '</title>
    <link rel="icon" href="../assets/img/brand/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
</head>
<style>
@page { sheet-size: A5; }

@page bigger { sheet-size: 420mm 370mm; }

@page toc { sheet-size: A4; }

h1.bigsection {
        page-break-before: always;
        page: bigger;
}

table, th, td {
    border: 1px solid black;
  }

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
    <table style="width:100%;border:2px;">
        <tbody>
            <tr>
                <td><img src="js/mpdf/polri.png" style="width:60px;"></img></td>

                <td>
                    <h1 style="color:#EA2027;">INDONESIA</h1>
                    <h4 style="color:#000;">SURAT IJIN MENGEMUDI</h4>
                    </td>
                <td style="text-align:right">
                    <h3 style="color:#EA2027;right: 50mm; top: 60mm; text-align:
center; padding: 2mm; padding-top: 4mm;text-align: right;">&nbsp; DRIVING LICENSE &nbsp;</h3>
                </td>
            </tr>
        </tbody>
    </table>

    <div width="100%">
        <div width="100%">
            <table style="width:100%;">
                <tbody>
                    <tr>
                        <td style="width:70%;">
                            <p><p>
                        </td>
                        <td rowspan="2" class="barcodecell" style="text-align:center">
                            <div style="float: right; width:50%;">
                                
                                <div style="right: 50px;font-size:16px;color:#EA2027;">
                                    <h1><b>A</b></h1>
                                </div>
                                
                            </div>
                            <div style="color:#000;" align="right">
                            
                                <h3>1234-1234-123456</h3>
                            </div>
                        </td>
                    </tr>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>

    </div>
	<br>

    <div style="width: 100%;">
    <div align="left" style="width: 80%; float: left;">
    <table style="float: left;font-size:14px;">
        <tbody>
        <tr>
                <td rowspan="7">
                <img src="https://i.pinimg.com/236x/c1/0f/e0/c10fe07b1eaa460f04895398a09f6624--no-makeup-makeup-looks.jpg" style="width:100px;"></img>
                <p><img src="https://img.favpng.com/10/9/6/file-signature-png-favpng-LbVPPBjhnku0p8hqc53kJxVYd.jpg" style="width:100px;"></img></p>
                </td>
                
            </tr>
            <tr>
                <td>
                    <p>1. </p>
                </td>
                <td>
                    <p><strong>PEDRO RAYMOND LAPEBESI</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                <p>2. </p>
            </td>
            <td>
                <p><strong>NTT, 05-05-2000</strong></p>
            </td>
            </tr>
            <tr>
                <td>
                <p>3. </p>
            </td>
            <td>
                <p class="uppercase"><strong>O - PRIA</strong></p>
            </td>
            </tr>
            <tr>
                <td>
                    <p>4. </p>
                </td>
                <td>
                    <p><strong>JL. DR. WAHIDIN NO.48 KOTA YOGYAKARTA</strong></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>5. </p>
                </td>
                <td>
                    <p class="uppercase"><strong>POLRI</strong></p>
                </td>
        </tr>
        <tr>
        <td>
            <p>6. </p>
        </td>
        <td>
            <p class="uppercase"><strong>METROJAYA</strong></p>
        </td>
        </tr>
        </tbody>
    </table>
    </div>




    </div>


    <div style="width: 100%;">
    <div align="right" style="width: 20%; float: right;">
    <table style="float: right;font-size:12px;">
        <tbody>

        <tr>
                <td rowspan="4">
                <img src="https://i.pinimg.com/236x/c1/0f/e0/c10fe07b1eaa460f04895398a09f6624--no-makeup-makeup-looks.jpg" style="width:50px;"></img>
                <p><strong>23-12-2020</strong></p>
                </td>
                
            </tr>
            <tr>
                <td>
                    <p> </p>
                </td>
                <td>
                    <p></p>
                </td>
            </tr>
            <tr>
                <td>
                <p></p>
            </td>
            <td>
                <p></p>
            </td>
            </tr>
            <tr>
                <td>
                <p></p>
            </td>
            <td>
            </td>
            </tr>
            
        </tbody>
    </table>
    </div>

    </div>
        



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
        'format' => 'A5'
    ]);

    $logo = '<img src="js/mpdf/polri.png" style="width:18px;"></img>';
    // $mpdf->setFooter('' . $logo . ' Korlantas Polri || Diunduh pada : ' . $currentTime . ' WIB');
    $mpdf->AddPage("L", "", "", "", "", "10", "10", "10", "10", "", "", "", "", "", "", "", "", "", "", "");
    $mpdf->WriteHTML($content);
    // $mpdf->WriteHTML($content2);
    // $mpdf->WriteHTML($content3);
    // $mpdf->WriteHTML($content4);
    // $mpdf->WriteHTML($content5);
    // $mpdf->WriteHTML($content6);
    // $mpdf->WriteHTML($content7);
    $filename = "SIM_BARU_1234123456.pdf";
    $mpdf->Output($filename, 'I');
}
