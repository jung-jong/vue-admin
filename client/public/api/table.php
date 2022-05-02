<?php

// DB table to use
$table = 'tb_table';
 
// Table's primary key
$primaryKey = 'SEQ_ID';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case object
// parameter names
$columns = array(
    array( 'db' => 'SEQ_ID', 'dt' => '0' ),
    array( 'db' => 'USER_ID', 'dt' => '1' ),
    array( 'db' => 'TITLE', 'dt' => '2' ),
    array( 'db' => 'SCALE_CD', 'dt' => '3' ),
    array( 'db' => 'WIDTH', 'dt' => '4' ),
    array( 'db' => 'HEIGHT', 'dt' => '5' ),
    array( 'db' => 'SHARE_URL', 'dt' => '6' ),
//     array(
//       'db'        => 'A_DATE',
//       'dt'        => 'A_DATE',
//       'formatter' => function( $d, $row ) { 
//           return substr($d, 0,6);
//       }
//     ),
//     array(
//       'db'        => 'U_DATE',
//       'dt'        => 'U_DATE',
//       'formatter' => function( $d, $row ) {
//           return substr($d, 0,6);
//       }
//   ),
);
// SQL server connection information
$sql_details = array(
    'user' => 'localhost:3307',
    'pass' => 'root',
    'db'   => '0000',
    'host' => 'admin'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require("ssp.class.php");
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>