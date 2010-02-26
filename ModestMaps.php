<?php

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
        }
    }

?>