<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */ 
 
// DB table to use
$table = <<<EOT
(
   SELECT pembayaran.*
     , pendaftaran.nominal_disetujui

   FROM pembayaran
   JOIN pendaftaran where pembayaran.kd_daftar = pendaftaran.kd_daftar order by pembayaran.tgl_bayar DESC
) temp
EOT;

 
// Table's primary key
$primaryKey = 'kd_bayar';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'kd_bayar', 'dt' => 0 ),
    array( 'db' => 'kd_daftar', 'dt' => 1 ),
    array( 'db' => 'tgl_bayar',  'dt' => 2 ),
    array( 'db' => 'nominal_disetujui',   'dt' => 3 ),
    array( 'db' => 'sts_bayar',     'dt' => 4 )
  
); 
 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'db_sib',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);