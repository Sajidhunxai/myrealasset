<?php
/**
 * @package Traveler layout essential for elementor
 */
namespace Inc;

class STEssentialActivate
{
    public static function activate()
    {
        flush_rewrite_rules();
    }
}