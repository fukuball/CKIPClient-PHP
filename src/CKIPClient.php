<?php
/**
 * CKIPClient.php
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

class CKIPClient
{

   private $server_ip;
   private $server_port;
   private $username;
   private $password;

   public  $raw_text;
   public  $return_text;
   public  $sentence = array();
   public  $term = array();

   /**
    * Method __construct initialize instance
    *
    * @return void
    */
   public function __construct($server_ip, $server_port, $username, $password)
   {

      $this->server_ip = $server_ip;
      $this->server_port = $server_port;
      $this->username = $username;
      $this->password = $password;

   }// end function __construct

   /**
    * Method send
    *
    * @param string $raw_text
    *
    * @return string $return_text
    */
   public function send($raw_text)
   {

      if (!empty($raw_text)) {

         $this->raw_text = $raw_text;

         $xw = new xmlWriter();
         $xw->openMemory();

         $xw->startDocument('1.0');

         $xw->startElement('wordsegmentation');
         $xw->writeAttribute('version', '0.1');
         $xw->startElement('option');
         $xw->writeAttribute('showcategory', '1');
         $xw->endElement();

         $xw->startElement('authentication');
         $xw->writeAttribute('username', $this->username);
         $xw->writeAttribute('password', $this->password);
         $xw->endElement();

         $xw->startElement('text');
         $xw->writeRaw($this->raw_text);
         $xw->endElement();

         $xw->endElement();

         $message = iconv("utf-8", "big5", $xw->outputMemory(true));

         //send message to CKIP server
         set_time_limit(60);

         $protocol = getprotobyname("tcp");
         $socket = socket_create(AF_INET, SOCK_STREAM, $protocol);
         socket_connect($socket, $this->server_ip, $this->server_port);
         socket_write($socket, $message);
         $this->return_text = iconv("big5", "utf-8", socket_read($socket, strlen($message)*3));

         socket_shutdown($socket);
         socket_close($socket);

      }

      return $this->return_text;

   }// end function send

   /**
    * Method getSentence
    *
    * @return array $return_sentence
    */
   public function getSentence()
   {

      // empty the array
      $this->sentence = array();

      if($parse_return_text = simplexml_load_string($this->return_text)) {

         $sentence_array = $parse_return_text->result->sentence;

         foreach ($sentence_array as $key => $sentence) {

            $sentence_value = (string) $sentence;
            // remove invisible characters
            $check_sentence = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $sentence_value);

            if (!empty($check_sentence)) {
               array_push($this->sentence, $sentence_value);
            }

         }

      }

      return $this->sentence;

   }// end function getSentence

   /**
    * Method getTerm
    *
    * @return array $return_term
    */
   public function getTerm() {

      // empty the array
      $this->term = array();

      $this->getSentence();

      foreach ($this->sentence as $t) {

         foreach (explode("　", $t) as $s) {

            if ($s!="") {
               preg_match("/(\S*)\((\S*)\)/", $s, $m);

               $this_term_array = array("term"=>$m[1], "tag"=>$m[2]);
               array_push($this->term, $this_term_array);

            }

         }

      }

      return $this->term;

   }// end function getTerm

   /**
    * Method __destruct unset instance value
    *
    * @return void
    */
   public function __destruct()
   {

      $class_property_array = get_object_vars($this);

      foreach ($class_property_array as $property_key => $property_value) {

         unset($this->$property_key);

      }// end foreach

   }// end function __destruct

}
?>