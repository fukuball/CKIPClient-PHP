<?php
/**
 * ckip-test-driver-schedule.php
 *
 * PHP version 5
 *
 * @category PHP
 * @package  /
 * @author   Fukuball Lin <fukuball@gmail.com>
 * @license  No Licence
 * @version  Release: <1.0>
 * @link     http://fukuball@github.com
 */

require_once "src/CKIPClient.php";

// change to yours
define("CKIP_SERVER", "000.000.000.000");
define("CKIP_PORT", 0000);
define("CKIP_USERNAME", "xxxxxx");
define("CKIP_PASSWORD", "xxxxxxxxx");

$ckip_client_obj = new CKIPClient(
   CKIP_SERVER,
   CKIP_PORT,
   CKIP_USERNAME,
   CKIP_PASSWORD
);

$raw_text = "獨立音樂需要大家一起來推廣，歡迎加入我們的行列。";

$raw_text = str_replace("，", "\n", $raw_text);
$raw_text = str_replace("。", "\n", $raw_text);
$raw_text = str_replace(",", "\n", $raw_text);
$raw_text = str_replace(".", "\n", $raw_text);

$raw_text_array = explode("\n", $raw_text);
$raw_text_array = array_filter($raw_text_array);

foreach ($raw_text_array as $raw_sentence) {

   $return_text = $ckip_client_obj->send($raw_sentence);
   echo $return_text;

   $return_term = $ckip_client_obj->getTerm();
   print_r($return_term);

   sleep(5);

}


?>