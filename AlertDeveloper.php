<?php

$subject = str_replace('percentage', '%', $_GET["content"]);

if ($subject == "") {
    exit();
}

$test = explode("aod", $subject);
$ttt = "";  // Initialize the variable

if (count($test) > 0) {
    for ($i = 0; $i < count($test); $i++) {
        $ttt .= $test[$i] . "\n";
    }
} else {
    exit();
}

$ttt = urlencode($ttt);

$chOne = curl_init();
curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");

// Uncomment and set these lines if you need a proxy
// $proxy = 'your_proxy_address:port';
// $proxyauth = 'username:password';
// curl_setopt($chOne, CURLOPT_PROXY, $proxy);     
// curl_setopt($chOne, CURLOPT_PROXYUSERPWD, $proxyauth); 

// SSL USE
curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
// POST
curl_setopt($chOne, CURLOPT_POST, 1);
// Message
curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$ttt");
//ถ้าต้องการใส่รูป ให้ใส่ 2 parameter imageThumbnail และ imageFullsize
// curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=hi&imageThumbnail=http://www.wisadev.com/wp-content/uploads/2016/08/cropped-wisadevLogo.png&imageFullsize=http://www.wisadev.com/wp-content/uploads/2016/08/cropped-wisadevLogo.png");
// follow redirects
curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
// ADD header array
$headers = array(
    'Content-type: application/x-www-form-urlencoded',
    'Authorization: Bearer TOKEN_LINE',
);
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
// RETURN
curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($chOne);
// Check error
if (curl_error($chOne)) {
    echo 'error:' . curl_error($chOne);
} else {
    $result_ = json_decode($result, true);
    echo "status : " . $result_['status'];
    echo "message : " . $result_['message'];
}
// Close connect
curl_close($chOne);
