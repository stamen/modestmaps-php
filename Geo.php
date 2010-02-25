<?php

    class Location
    {
        var $lat;
        var $lon;
        
        function Point($lat, $lon)
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

?>