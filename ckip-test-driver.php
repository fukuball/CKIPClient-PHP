<?php
/**
 * ckip-test-driver.php
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

$raw_text = "獨立音樂需要大家一起來推廣，\n".
            "歡迎加入我們的行列！。\n";

$return_text = $ckip_client_obj->send($raw_text);
echo $return_text;

$return_sentence = $ckip_client_obj->getSentence();
print_r($return_sentence);

$return_term = $ckip_client_obj->getTerm();
print_r($return_term);

?>