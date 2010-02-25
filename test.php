<?php

    ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__).'/../lib'.PATH_SEPARATOR.'/usr/share/pear');
    require_once 'Tiles.php';
    require_once 'PHPUnit.php';
    
    class Tiles_TestCase extends PHPUnit_TestCase
    {
        function setUp()
        {
        }
        
        function test_binary_strings()
        {
            $this->assertEquals('1', MMaps_Tiles_toBinaryString(1), 'To binary string');
            $this->assertEquals('10', MMaps_Tiles_toBinaryString(2), 'To binary string');
            $this->assertEquals('11', MMaps_Tiles_toBinaryString(3), 'To binary string');
            $this->assertEquals('100', MMaps_Tiles_toBinaryString(4), 'To binary string');

            $this->assertEquals(1, MMaps_Tiles_fromBinaryString('1'), 'From binary string');
            $this->assertEquals(3, MMaps_Tiles_fromBinaryString('11'), 'From binary string');
            $this->assertEquals(5, MMaps_Tiles_fromBinaryString('101'), 'From binary string');
            $this->assertEquals(9, MMaps_Tiles_fromBinaryString('1001'), 'From binary string');
        }
        
        function test_yahoo_strings()
        {
            $this->assertEquals('[0,0,1]', json_encode(MMaps_Tiles_fromYahooRoad(0, 0, 17)), 'fromYahooRoad');
            $this->assertEquals('[10507,25322,16]', json_encode(MMaps_Tiles_fromYahooRoad(10507, 7445, 2)), 'fromYahooRoad');
            $this->assertEquals('[10482,25333,16]', json_encode(MMaps_Tiles_fromYahooRoad(10482, 7434, 2)), 'fromYahooRoad');

            $this->assertEquals('[0,0,17]', json_encode(MMaps_Tiles_toYahooRoad(0, 0, 1)), 'toYahooRoad');
            $this->assertEquals('[10507,7445,2]', json_encode(MMaps_Tiles_toYahooRoad(10507, 25322, 16)), 'toYahooRoad');
            $this->assertEquals('[10482,7434,2]', json_encode(MMaps_Tiles_toYahooRoad(10482, 25333, 16)), 'toYahooRoad');

            $this->assertEquals('[0,0,1]', json_encode(MMaps_Tiles_fromYahooAerial(0, 0, 17)), 'fromYahooAerial');
            $this->assertEquals('[10507,25322,16]', json_encode(MMaps_Tiles_fromYahooAerial(10507, 7445, 2)), 'fromYahooAerial');
            $this->assertEquals('[10482,25333,16]', json_encode(MMaps_Tiles_fromYahooAerial(10482, 7434, 2)), 'fromYahooAerial');

            $this->assertEquals('[0,0,17]', json_encode(MMaps_Tiles_toYahooAerial(0, 0, 1)), 'toYahooAerial');
            $this->assertEquals('[10507,7445,2]', json_encode(MMaps_Tiles_toYahooAerial(10507, 25322, 16)), 'toYahooAerial');
            $this->assertEquals('[10482,7434,2]', json_encode(MMaps_Tiles_toYahooAerial(10482, 25333, 16)), 'toYahooAerial');
        }
        
        function test_microsoft_strings()
        {
            $this->assertEquals('[0,0,1]', json_encode(MMaps_Tiles_fromMicrosoftRoad('0')), 'fromMicrosoftRoad');
            $this->assertEquals('[10507,25322,16]', json_encode(MMaps_Tiles_fromMicrosoftRoad('0230102122203031')), 'fromMicrosoftRoad');
            $this->assertEquals('[10482,25333,16]', json_encode(MMaps_Tiles_fromMicrosoftRoad('0230102033330212')), 'fromMicrosoftRoad');

            $this->assertEquals('0', MMaps_Tiles_toMicrosoftRoad(0, 0, 1), 'toMicrosoftRoad');
            $this->assertEquals('0230102122203031', MMaps_Tiles_toMicrosoftRoad(10507, 25322, 16), 'toMicrosoftRoad');
            $this->assertEquals('0230102033330212', MMaps_Tiles_toMicrosoftRoad(10482, 25333, 16), 'toMicrosoftRoad');

            $this->assertEquals('[0,0,1]', json_encode(MMaps_Tiles_fromMicrosoftAerial('0')), 'fromMicrosoftAerial');
            $this->assertEquals('[10507,25322,16]', json_encode(MMaps_Tiles_fromMicrosoftAerial('0230102122203031')), 'fromMicrosoftAerial');
            $this->assertEquals('[10482,25333,16]', json_encode(MMaps_Tiles_fromMicrosoftAerial('0230102033330212')), 'fromMicrosoftAerial');

            $this->assertEquals('0', MMaps_Tiles_toMicrosoftAerial(0, 0, 1), 'toMicrosoftAerial');
            $this->assertEquals('0230102122203031', MMaps_Tiles_toMicrosoftAerial(10507, 25322, 16), 'toMicrosoftAerial');
            $this->assertEquals('0230102033330212', MMaps_Tiles_toMicrosoftAerial(10482, 25333, 16), 'toMicrosoftAerial');
        }
        
        function tearDown()
        {
        }
    }

    $suite  = new PHPUnit_TestSuite('Tiles_TestCase');
    $result = PHPUnit::run($suite);
    echo $result->toString();

?>