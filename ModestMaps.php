<?php

    require_once 'Geo.php';
    require_once 'Core.php';

    class Modest_Map
    {
        var $provider;
        var $dimensions;
        var $coordinate;
        var $offset;
        
        function Modest_Map($provider, $dimensions, $coordinate, $offset)
        {
            $this->provider = $provider;
            $this->dimensions = $dimensions;
            $this->coordinate = $coordinate;
            $this->offset = $offset;
        }
        
        function locationPoint($location)
        {
            $point = $this->offset->copy();
            $coord = $this->provider->locationCoordinate($location)->zoomTo($this->coordinate->zoom);
            
            // distance from the known coordinate offset
            $point->x += $this->provider->tile_width * ($coord->column - $this->coordinate->column);
            $point->y += $this->provider->tile_height * ($coord->row - $this->coordinate->row);
            
            // because of the center/corner business
            $point->x += $this->dimensions->x / 2;
            $point->y += $this->dimensions->y / 2;
            
            return $point;
        }
        
        function pointLocation($point)
        {
            $hizoomCoord = $this->coordinate->zoomTo(MMaps_Coordinate_Max_Zoom);
            
            // because of the center/corner business
            $point = new MMaps_Point($point->x - $this->dimensions->x/2,
                                     $point->y - $this->dimensions->y/2);

            // distance in tile widths from reference tile to point
            $xTiles = ($point->x - $this->offset->x) / $this->provider->tile_width;
            $yTiles = ($point->y - $this->offset->y) / $this->provider->tile_height;
            
            // distance in rows & columns at maximum zoom
            $xDistance = $xTiles * pow(2, (MMaps_Coordinate_Max_Zoom - $this->coordinate->zoom));
            $yDistance = $yTiles * pow(2, (MMaps_Coordinate_Max_Zoom - $this->coordinate->zoom));
            
            // new point coordinate reflecting that distance
            $coord = new MMaps_Coordinate(round($hizoomCoord->row + $yDistance),
                                          round($hizoomCoord->column + $xDistance),
                                          $hizoomCoord->zoom);

            $coord = $coord->zoomTo($this->coordinate->zoom);
            $location = $this->provider->coordinateLocation($coord);
            
            return $location;
        }
    }

    function MMaps_calculateMapCenter($provider, $centerCoord)
    {
        // initial tile coordinate
        $initTileCoord = $centerCoord->container();
        
        // initial tile position, assuming centered tile well in grid
        $initX = ($initTileCoord->column - $centerCoord->column) * $provider->tile_width;
        $initY = ($initTileCoord->row - $centerCoord->row) * $provider->tile_height;
        $initPoint = new MMaps_Point(round($initX), round($initY));
        
        return array($initTileCoord, $initPoint);
    }
    
    function MMaps_mapByCenterZoom($provider, $center, $zoom, $dimensions)
    {
        $centerCoord = $provider->locationCoordinate($center)->zoomTo($zoom);
        list($mapCoord, $mapOffset) = MMaps_calculateMapCenter($provider, $centerCoord);
        
        return new Modest_Map($provider, $dimensions, $mapCoord, $mapOffset);
    }

?>