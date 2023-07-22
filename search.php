<?php
include_once('system/system.php');
$term = $_GET['term'];
$query = $kpanel->query('SELECT * FROM Kullanicilar
WHERE username LIKE "' . $term . '%" limit 10', PDO::FETCH_ASSOC);

if ( $query->rowCount() ){

    $data = array();

    foreach ( $query as $row ){
        $data[] = array(
            'value' => $row['username'],
			'username' => $row['username']
        );
    }

    echo json_encode($data);

}
?>