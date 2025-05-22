<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ftp_server = "ftp.styxnatur.at";
$ftp_user = "mediaftp@styxnatur.at";
$ftp_pass = "5qogN!-J6ZX9G4-_";

// pripojenie
$conn_id = ftp_connect($ftp_server, 21, 10);

if (!$conn_id) {
	die("❌ Nepodarilo sa pripojiť na FTP server.");
}

// login
$login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);

if (!$login_result) {
	die("❌ Login zlyhal – nesprávny používateľ alebo heslo.");
}

echo "✅ Pripojenie úspešné!<br>";

// výpis súborov v root adresári
$files = ftp_nlist($conn_id, ".");
if ($files === false) {
	echo "⚠️ Nepodarilo sa načítať zoznam súborov.";
} else {
	echo "<pre>";
	print_r($files);
	echo "</pre>";
}

ftp_close($conn_id);

