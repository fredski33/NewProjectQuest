<?php

namespace AppBundle\Twig;


class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('duration', array( $this, 'durationFilter' )),
        );
    }

    public function durationFilter(int $seconds)
    {
        $units = array(
            'h' => 3600,
            "'" => 60,
            "''" => 1,
        );
        $str = '';
        foreach ($units as $unitName => $unit) {
            $nbUnit = intdiv($seconds, $unit);
            $seconds = $seconds % $unit;
            $str .= "$nbUnit $unitName ";
        }

        return trim($str);
    }
}