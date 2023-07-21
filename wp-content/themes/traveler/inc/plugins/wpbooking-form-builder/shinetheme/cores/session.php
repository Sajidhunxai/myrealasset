<?php

/**

 * Created by wpbooking.

 * Developer: nasanji

 * Date: 8/2/2017

 * Version: 1.0

 */



if(!class_exists('WB_FB_Session'))

{

    class WB_FB_Session

    {

        static function _init()

        {

        }



        static function get($key=false,$default=NULL)

        {

            if($key and isset($_SESSION[$key])) return $_SESSION[$key];



            return $default;

        }

        static function set($key=false,$value = '')

        {
            if(is_session_started() === false){
                session_start();
            }
            $_SESSION[$key]=$value;
            session_write_close();

        }



        static function destroy($key){
            if(is_session_started() === false){
                session_start();
            }
            if(isset($_SESSION[$key])) unset($_SESSION[$key]);
            session_write_close();
        }

    }



    WB_FB_Session::_init();

}