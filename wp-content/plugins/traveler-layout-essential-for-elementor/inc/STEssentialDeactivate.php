<?php
/**
 * @package Traveler layout essential for elementor
 */
namespace Inc;

class STEssentialDeactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}
