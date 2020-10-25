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
   SELECT pendaftaran.*
     , user_mhs.nim

   FROM pendaftaran
   JOIN user_mhs where pendaftaran.id_mhs = user_mhs.id_mhs
) temp
EOT;

// Table's primary key
$primaryKey = 'kd_daftar';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'kd_daftar', 'dt' => 0),
    array('db' => 'nim', 'dt' => 1),
    array('db' => 'kd_bsw',  'dt' => 2),
    array('db' => 'tgl_daftar',   'dt' => 3),
    array('db' => 'thn_ajaran',   'dt' => 4),  
    array('db' => 'semester',     'dt' => 5),
    array('db' => 'status',     'dt' => 6),
    array('db' => 'nominal_pengajuan',     'dt' => 7),

);

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'db_sib',
    'host' => 'localhost'
);

// $editor->where('status', 'diterima');
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
