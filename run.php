<?php  
error_reporting(1);


echo "project info : grivy tools  \n";
echo "created by xdrsyah \n";

echo "[1] extrap & get direct link \n";
echo "[2] cek code \n";
	echo "opsi : ";
$opsi = trim(fgets(STDIN));

if ($opsi == 1) {

echo "[+] code : ";
$code = trim(fgets(STDIN));
echo "[+] jumlah : ";
$jmlh = trim(fgets(STDIN));
for ($i = 0; $i < $jmlh ; $i++) {
	$code_satu = "$code".angka(1);
	$id = randStr(8);
	$url = "https://grivy.co/$code_satu/?id=$id";
	$ex = explode("?", $url);
$id = trim($ex[1]);
$req = curl($url);
if (preg_match("/https:\/\/grivy/", $req)) {
	echo "link tidak tersedia \n";
}else {
	$ex = explode("Set-Cookie: ", $req);
	$uri = get_between($ex[1], 'Location: ', $id);
	$location = "$uri".$id;
	$req = curl($location);
$get_uri = get_between($req, 'data":{"url":"', '?utm_medium=');
$req2 = curl($get_uri);
$uri = get_between($req2, 'Location: ', 'Content-Length: 0');
$link = explode(" ", $uri);
fwrite(fopen("grivy.txt", "a"), $link[0]);
print_r($link[0]);
}
}

}





if ($opsi == 2) {
	echo "file : ";
	$file = file(trim(fgets(STDIN)));
	
	foreach ($file as $akon) {
		$url = trim($akon);
		$curl = curl($url);
$validasi = get_between($curl, '<span class="bold">', '</span>');
$tgl = get_between($curl, "<p align=\"center\" style=\"font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;\">Expired since", '</p>');
$title = get_between($curl, '<div class="coupontitle">', '</div>');
if ($validasi == "EXPIRED") {
	echo "\e[31m$url\e[0m \e[34m[$title]\e[0m \e[33m[exp :$tgl]\e[0m \n";
}else {
	echo "\e[32m$url\e[0m \e[34m[$title]\e[0m \e[33m[exp :$tgl]\e[0m \n";
	fwrite(fopen("grivy-live.txt", "a"), "$url [exp :$tgl] \n");
}
	}
	
}






function curl($url, $params = null, $header = true, $httpheaders = null, $request = 'GET'){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
	curl_setopt($ch, CURLOPT_HEADER, $header);
	@curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; rv:52.0) Gecko/20100101 Firefox/52.0");
	$response = curl_exec($ch);
	return $response;
	curl_close($ch);
}

function get_between($string, $start, $end)
    {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    } 

function angka($w){
	$abc = "1234567890";
	$word = "";
	for ($i = 0; $i < $w ; $i++) {
		$word .=$abc{rand(0,strlen($abc)-1)};
	}
	return $word;
}
function randStr($q){
	$abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$word = "";
	for ($i = 0; $i < $q ; $i++) {
		$word .=$abc{rand(0,strlen($abc)-1)};
	}
	return $word;
}


?>