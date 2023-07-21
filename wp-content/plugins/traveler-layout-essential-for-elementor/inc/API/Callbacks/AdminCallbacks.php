<?php
/**
 *
 */
namespace Inc\API\Callbacks;

use WP_Error;

class AdminCallbacks
{
    public function adminDashboard()
    {
        include(ST_ESSENTIAL_PLUGIN_PATH . 'templates/admin.php');
    }
    // Check valid purchasecode
    public function check_valid_purchasecode($pcc)
    {
        
        $array = [
            'cfd6b1472250ae8d0b3548c41cb8868e',
            '3997f54ee0e20ff46c959461b7882355',
            '22c4999f03e69c5ffe34898fc80d7e58',
        ];
        if (in_array(md5($pcc), $array)) {
            return true;
        } else {
            return false;
        }
    }
    // Check valid purchasecode
    public function checkValidatePurchaseCode($_purchase_code = false)
    {
       
      
        if (!empty($_purchase_code)) {
            if (self::check_valid_purchasecode($_purchase_code)) {
                return [
                    'status'=> true,
                ];
            } else {
                $item_id = 10822683;

                $url = "https://api.envato.com/v3/market/author/sale?code=".$_purchase_code;
                
                $personal_token = "fivQeTQarEgttMvvxLjnYza19xh1r8lo";

                if (ini_get('allow_url_fopen')) {
                    $options = array('http' => array(
                        'method'  => 'GET',
                        'header' => 'Authorization: Bearer '.$personal_token
                    ));
                    $context  = stream_context_create($options);
                    $envatoRes = file_get_contents($url, false, $context);
                }
                if (!$envatoRes) {
                    $curl = curl_init($url);
                    $header = array();
                    $header[] = 'Authorization: Bearer '.$personal_token;
                    $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
                    $header[] = 'timeout: 30';
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

                    $envatoRes = curl_exec($curl);
                    curl_close($curl);
                }

                if (!empty($envatoRes)) {
                    $res=json_decode($envatoRes, true);
                    
                    if (!empty($res)) {
                        if (isset($res['item']['id'])) {
                            if ($res['item']['id'] == $item_id) {
                                return [
                                    'status'=> true,
                                ];
                            } else {
                                return [
                                    'status' => false,
                                    'message' => __('Invalid Purchase code', 'traveler-layout-essential'),
                                ];
                            }
                        }
                    }
                }
            }
        } else {
            return [
                'status' => false,
                'message' => __('Requied Purchase code', 'traveler-layout-essential'),
            ];
        }
    }

    public function get_item_template_api($type = '')
    {
        $api_url = 'https://library.travelerwp.com/wp-json/traveler/get-list-item/'.$type;
        
        
        $response = wp_remote_get($api_url);
        $response_code  = wp_remote_retrieve_response_code($response);
        $response_body  = json_decode(wp_remote_retrieve_body($response), true);
        $response_error = null;
        if (is_wp_error($response)) {
            $response_error = $response;
        } elseif (200 !== $response_code) {
            $response_error = new WP_Error(
                'api-error',
                /* translators: %d: Numeric HTTP status code, e.g. 400, 403, 500, 504, etc. */
                sprintf(__('Invalid API response code (%d).'), $response_code)
            );
        } elseif (! isset($response_body['data'])) {
            $response_error = new WP_Error(
                'api-invalid-response',
                isset($response_body['error']) ? $response_body['error'] : __('Unknown API error.', 'traveler-layout-essential')
            );
        }
        if (is_wp_error($response_error)) {
            return $response_error;
        } else {
            return $response_body['data'];
        }
    }

    public function get_template_item_api($id = '', $_purchase_code = '')
    {
        $api_url = 'https://library.travelerwp.com/wp-json/traveler/get-template-item';
        global $current_user;
        $current_user = wp_get_current_user() ;
    
        $request_args = array(
            'body' => array(
                'id' => $id,
                'pass_application' => $_purchase_code,
                'user-domain' => home_url('/'),
                'user-name' => $current_user->display_name,
                'user-email' => $current_user->user_email,
            ),
            
        );
        
        $check = $this->checkValidatePurchaseCode($_purchase_code);

        if ($check['status'] == true) {
            $response = wp_remote_get($api_url, $request_args);
    
            $response_code  = wp_remote_retrieve_response_code($response);
            
            $response_body  = json_decode(wp_remote_retrieve_body($response), true);
            
            $response_error = null;
            if (is_wp_error($response)) {
                $response_error = $response;
            } elseif (200 !== $response_code) {
                $response_error = new WP_Error(
                    'api-error',
                    /* translators: %d: Numeric HTTP status code, e.g. 400, 403, 500, 504, etc. */
                    sprintf(__('Invalid API response code (%d).'), $response_code)
                );
            } elseif (! isset($response_body['data'])) {
                $response_error = new WP_Error(
                    'api-invalid-response',
                    isset($response_body['error']) ? $response_body['error'] : __('Unknown API error.')
                );
            }
            if (is_wp_error($response_error)) {
                return $response_error;
            } else {
                return $response_body['data'];
            }
        } else {
            return [
                'message'=>$check['message']
            ];
        }
    }
}
