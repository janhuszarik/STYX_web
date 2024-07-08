<?php
$upload_path = __DIR__ . '/uploads/sliders/';

if (!is_dir($upload_path)) {
	if (!mkdir($upload_path, 0777, true)) {
		die('Failed to create directory: ' . $upload_path);
	}
}

if (!is_writable($upload_path)) {
	die('Upload path is not writable: ' . $upload_path);
}

$test_file = $upload_path . 'test.txt';
if (file_put_contents($test_file, 'test') === false) {
	die('Unable to write test file in upload path: ' . $upload_path);
} else {
	echo 'Test file created successfully in upload path: ' . $upload_path;
	unlink($test_file); // Remove the test file
}
?>
