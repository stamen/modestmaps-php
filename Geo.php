<?php

    require_once 'Core.php';

    class Location
    {
        var $lat;
        var $lon;
        
        function Location($lat, $lon)
        {
            $this->lat = $lat;
            $this->lon = $lon;
        }
        
        function toString()
        {
            return sprintf('(%.3f, %.3f)', $this->lat, $this->lon);
        }
    }
    
    class Transformation
    {
        var $ax;
        var $bx;
        var $cx;
        var $ay;
        var $by;
        var $cy;
        
        function Transformation($ax, $bx, $cx, $ay, $by, $cy)
        {
            $this->ax = $ax;
            $this->bx = $bx;
            $this->cx = $cx;
            $this->ay = $ay;
            $this->by = $by;
            $this->cy = $cy;
        }
        
        function transform($point)
        {
            return new Point($this->ax * $point->x + $this->bx * $point->y + $this->cx,
                             $this->ay * $point->x + $this->by * $point->y + $this->cy);
        }
        
        function untransform($point)
        {
            return new Point(($point->x * $this->by - $point->y * $this->bx - $this->cx * $this->by + $this->cy * $this->bx) / ($this->ax * $this->by - $this->ay * $this->bx),
                             ($point->x * $this->ay - $point->y * $this->ax - $this->cx * $this->ay + $this->cy * $this->ax) / ($this->bx * $this->ay - $this->by * $this->ax));
        }
    }

    class Linear_Projection
    {
        var $zoom;
        var $transformation;
        
        function Linear_Projection($zoom, $transformation=null)
        {
            $this->zoom = $zoom;
            $this->transformation = is_null($transformation) ? new Transformation(1, 0, 0, 0, 1, 0) : $transformation;
        }
        
        function rawProject($point)
        {
            return $point->copy();
        }
        
        function rawUnproject($point)
        {
            return $point->copy();
        }
        
        function project($point)
        {
            $point = $this->rawProject($point);
            $point = $this->transformation->transform($point);
            return $point;
        }
        
        function unproject($point)
        {
            $point = $this->transformation->untransform($point);
            $point = $this->rawUnproject($point);
            return $point;
        }
        
        function locationCoordinate($location)
        {
            $point = new Point(M_PI * $location->lon / 180, M_PI * $location->lat / 180);
            $point = $this->project($point);
            $coordinate = new Coordinate($point->y, $point->x, $this->zoom);
            return $coordinate;
        }
        
        function coordinateLocation($coordinate)
        {
            $coordinate = $coordinate->zoomTo($this->zoom);
            $point = new Point($coordinate->column, $coordinate->row);
            $point = $this->unproject($point);
            $location = new Location(180 * $point->y / M_PI, 180 * $point->x / M_PI);
            return $location;
        }
    }

    class Mercator_Projection extends Linear_Projection
    {
        function rawProject($point)
        {
            return new Point($point->x, log(tan(0.25 * M_PI + 0.5 * $point->y)));
        }
        
        function rawUnproject($point)
        {
            return new Point($point->x, 2 * atan(pow(M_E, $point->y)) - 0.5 * M_PI);
        }
    }

?>