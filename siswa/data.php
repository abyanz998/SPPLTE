<?php
session_start();

namespace Midtrans;

require_once(dirname(__FILE__) . '/vendor/autoload.php');

// error_reporting(0);
include "config/koneksi.php";

//Set Your server key
Config::$serverKey = "SB-Mid-server-PrwY2nxLwTUV7kyfMZVadJDl";

// Uncomment for production environment
Config::$isProduction = false;

// Enable sanitization
Config::$isSanitized = true;

// Enable 3D-Secure
Config::$is3ds = true;


if (isset($_SESSION['idSiswa']) && isset($_POST['items']) && isset($_POST['pay']) && isset($_POST['pay']) ) {
$val = $_POST['items'];
$id = $_POST['pay'];
$tot = $_POST['tot'];
$n = count($val);
$ad = $id[0];

for ($i=0; $i <$n; $i++) { 
  $da[] = [$id[$i]=>$val[$i]];
}

  $fi = mysqli_query($koneksi, "SELECT * FROM tagihan_bulanan
                                    INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan    
                                    INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa                                     
                                    WHERE idTagihanBulanan='$ad'");
    $ta = mysqli_fetch_array($fi);
    
    $date = date("YmdHis");
    $inv = 'MP'.$date;
    $no = rand();


    // Required
    $transaction_details = array(
        'order_id' => $inv,
        'gross_amount' => 94000, // no decimal allowed for creditcard
    );

    // Optional
    $item1_details = array(
        'id' => $no,
        'price' => $tot,
        'quantity' => 1,
        'name' => 'multiple'
    );


    // Optional
    $item_details = array($item1_details);

    // Optional
    $billing_address = array(
        'first_name'    => $ta['nmSiswa'],
        'address'       => $ta['alamatSiswa'],
        'phone'         => $ta['noHpOrtu'],
    );

    // Optional
    $shipping_address = array(
        'first_name'    => "Obet",
        'last_name'     => "Supriadi",
        'address'       => "Manggis 90",
        'city'          => "Jakarta",
        'postal_code'   => "16601",
        'phone'         => "08113366345",
        'country_code'  => 'IDN'
    );

    // Optional
    $customer_details = array(
        'first_name'    => $ta['nmSiswa'],
        'last_name'     => null,
        'email'         => $ta['nmSiswa'] . '@email.com',
        'phone'         => $ta['noHpOrtu'],
        // 'billing_address'  => $billing_address,
        // 'shipping_address' => $shipping_address
    );

    // Fill transaction details
    $transaction = array(
        // 'enabled_payments' => $enable_payments,
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details,
    );
    
    // $up = mysqli_query($koneksi, "UPDATE tagihan_bulanan SET inv='$inv' WHERE idTagihanBulanan='$da'");

    $snapToken = Snap::getSnapToken($transaction);
    echo $snapToken;
}



?>