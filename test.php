<?php

    ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__).'/../lib'.PATH_SEPARATOR.'/usr/share/pear');
    require_once 'Core.php';
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
    }
        
    class Core_TestCase extends PHPUnit_TestCase
    {
        function setUp()
        {
        }
        
        function test_points()
        {
            $p = new Point(0, 1);

            $this->assertEquals(0, $p->x, 'Point X');
            $this->assertEquals(1, $p->y, 'Point Y');
            $this->assertEquals('(0.000, 1.000)', $p->toString(), 'Point to string');
        }

        function test_coordinates()
        {
            $c = new Coordinate(0, 1, 2);

            $this->assertEquals(0, $c->row, 'Coordinate Row');
            $this->assertEquals(1, $c->column, 'Coordinate Column');
            $this->assertEquals(2, $c->zoom, 'Coordinate Zoom');
            $this->assertEquals('(0.000, 1.000 @2.000)', $c->toString(), 'Coordinate to string');

            $this->assertEquals('(0.000, 2.000 @3.000)', $c->zoomTo(3)->toString(), 'Coordinate zoomed to a destination');
            $this->assertEquals('(0.000, 0.500 @1.000)', $c->zoomTo(1)->toString(), 'Coordinate zoomed to a destination');

            $this->assertEquals('(-1.000, 1.000 @2.000)', $c->up()->toString(), 'Coordinate panned');
            $this->assertEquals('(0.000, 2.000 @2.000)', $c->right()->toString(), 'Coordinate panned');
            $this->assertEquals('(1.000, 1.000 @2.000)', $c->down()->toString(), 'Coordinate panned');
            $this->assertEquals('(0.000, 0.000 @2.000)', $c->left()->toString(), 'Coordinate panned');
        }
    }
    
    foreach(array('Tiles', 'Core') as $prefix)
    {
        $suite  = new PHPUnit_TestSuite("{$prefix}_TestCase");
        $result = PHPUnit::run($suite);
        echo $result->toString();
    }

?>