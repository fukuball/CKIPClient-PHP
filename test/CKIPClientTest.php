<?php

// change to yours
define("CKIP_SERVER", "000.000.000.000");
define("CKIP_PORT", 0000);
define("CKIP_USERNAME", "xxxxxx");
define("CKIP_PASSWORD", "xxxxxxxxx");

class CKIPClientTest extends PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {

        $ckip_client_obj = new CKIPClient(
            CKIP_SERVER,
            CKIP_PORT,
            CKIP_USERNAME,
            CKIP_PASSWORD
        );

        $this->assertInstanceOf('CKIPClient', $ckip_client_obj);

    }

    public function testDestruct()
    {

        $ckip_client_obj = new CKIPClient(
            CKIP_SERVER,
            CKIP_PORT,
            CKIP_USERNAME,
            CKIP_PASSWORD
        );

        unset($ckip_client_obj);

        $ckip_client_obj = '';

        $this->assertEquals(false, is_a($ckip_client_obj, 'CKIPClient'));

    }

    public function testSend()
    {

        $this->assertEquals(true, true);

    }

    public function testGetSentence()
    {

        $this->assertEquals(true, true);

    }

    public function testGetTerm()
    {

        $this->assertEquals(true, true);

    }


}
?>