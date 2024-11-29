<?php

date_default_timezone_set('Asia/Jakarta'); // Mengatur timezone ke WIB
date_default_timezone_get(); // Tidak perlu jika tidak digunakan lebih lanjut
$data = date('Y-m-d H:i:s');

echo $data;