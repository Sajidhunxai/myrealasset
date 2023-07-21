<?php

namespace Inc\Admin;

use Inc\API\SettingsApi;
use Inc\API\Callbacks\AdminCallbacks;

/**
*
*/

class AdminPages
{
    public $settings;

    public $callbacks;

    public $pages = array();

    public function register()
    {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setPages();


        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
    }

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'Traveler Essential Plugin',
                'menu_title' => 'Traveler Essential',
                'capability' => 'manage_options',
                'menu_slug' => 'traveler_essential',
                'callback' => array( $this->callbacks, 'adminDashboard' ),
                'icon_url' => 'dashicons-store',
                'position' => 110
            )
        );
    }
}
