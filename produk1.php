<?php
header('Content-Type: application/json; charset=utf8');

// Cross Origin Request
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost","root","","assestment3");

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Menampilkan Semua Data TO DO: Buat lebih spesifik (Untuk POSTMAN)
    $sql = "SELECT * FROM pemesanan";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data, JSON_PRETTY_PRINT);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // [POST] Menambahkan data + Use Body, x-www-form-urlencoded in Postman
    $ID_Homestay = $_POST['ID_Homestay']; // All Required since it's a new data
    $Tanggal_Checkin = $_POST['Tanggal_Checkin'];
    $Tanggal_Checkout = $_POST['Tanggal_Checkout'];
    $Nama_Tamu = $_POST['Nama_Tamu'];
    $Email_Tamu = $_POST['Email_Tamu'];
    $sql = "INSERT INTO Pemesanan (ID_Homestay, Tanggal_Checkin, Tanggal_Checkout, Nama_Tamu, Email_Tamu) VALUES ('$ID_Homestay', '$Tanggal_Checkin', '$Tanggal_Checkout', '$Nama_Tamu', '$Email_Tamu')";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "bisa ini"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "tidak bisa"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // [DELETE] Id only + Use Param in Postman
    $ID_Homestay= $_GET['ID_Homestay'];
    $sql = "DELETE FROM pemesanan WHERE ID_Homestay='$ID_Homestay'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "bisa ini"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "tidak bisa"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // [PUT] Use All + Use Params in Postman
    parse_str(file_get_contents("php://input"), $_PUT);
    $ID_Homestay = $_PUT['ID_Homestay_update'];
    $new_ID_Homestay = $_PUT['new_ID_Homestay'];

    // Check if a new ID was provided and use it if available
    if (isset($_PUT['new_ID_Homestay']) && !empty($_PUT['new_ID_Homestay'])) {
        // Update the ID in the database
        $sql_update_ID_Homestay = "UPDATE pemesanan SET ID_Homestay='$new_ID_Homestay' WHERE ID_Homestay='$ID_Homestay'";
        $cek_update_ID_Homestay = mysqli_query($koneksi, $sql_update_ID_Homestay);

        // Update the ID variable if the update was successful
        if ($cek_update_ID_Homestay) {
            $ID_Homestay = $new_ID_Homestay;
        }
    }

    $Nama_Tamu = $_PUT['Nama_Tamu_update'];
    $Email_Tamu = $_PUT['Email_Tamu_update'];
    $ID_Homestay = $_PUT['ID_Homestay_update'];

    $sql = "UPDATE pemesanan SET Nama_Tamu='$Nama_Tamu', Email_Tamu='$Email_Tamu', ID_Homestay='$ID_Homestay' WHERE ID_Homestay='$ID_Homestay'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "bisa ini"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "tidak bisa"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
}
?>