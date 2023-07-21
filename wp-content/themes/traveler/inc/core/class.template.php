<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STTemplate
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STTemplate'))
{
    class STTemplate
    {
        static $_message='';
        static $_message_type='';

        public static function init()
        {
        }
        public static function get_vc_pagecontent($page_id=false)
        {
            if($page_id)
            {
                $page=get_post($page_id);

                if($page)
                {
                    $content=apply_filters('the_content', $page->post_content);

                    $content = str_replace(']]>', ']]&gt;', $content);


                    $shortcodes_custom_css = get_post_meta( $page_id, '_wpb_shortcodes_custom_css', true );
                    Assets::add_css($shortcodes_custom_css);

                    wp_reset_postdata();
                    wp_reset_query();

                    return $content;
                }
            }
        }

        public static function set_message($message,$type='info')
        {
            if(is_session_started() === false && !isset($_SESSION)){
                session_start();
            }
            
            $_SESSION['bt_message']['content']=$message;
            $_SESSION['bt_message']['type']=$type;
            session_write_close();
        }
        public static function clear()
        {
            if('' == session_id() ){
                session_start();
            }
            $_SESSION['bt_message']=false;
            session_write_close();
        }

        public static function get_message()
        {
            return @$_SESSION['bt_message'];
        }

        public static function get_message_content()
        {
            if(isset($_SESSION['bt_message']['content'])) return $_SESSION['bt_message']['content'];
        }

        public static function message()
        {
            $content=!empty($_SESSION['bt_message']['content'])?$_SESSION['bt_message']['content']:false;
            $type=!empty($_SESSION['bt_message']['type'])?$_SESSION['bt_message']['type']:false;
            if(!$content) return;

            $html="<div class='alert alert-{$type}'>
                <button type=\"button\" class=\"close\" data-bs-dismiss=\"alert\" data-dismiss=\"alert\" aria-label=\"".__('Close','traveler')."\"><span aria-hidden=\"true\">&times;</span></button>
                {$content}
            </div>";

            //Reset Message
            if('' == session_id() ){
                session_start();
            }
            $_SESSION['bt_message']=array();
            session_write_close();
            STTemplate::clear();
            return $html;
        }

    }

    STTemplate::init();
}
