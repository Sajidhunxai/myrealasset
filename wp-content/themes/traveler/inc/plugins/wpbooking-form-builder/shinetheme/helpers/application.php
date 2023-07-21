<?php

/**

 * Created by wpbooking

 * Developer: nasanji

 * Date: 12/20/2016

 * Version: 1.0

 */



/**

 * Load view path

 *

 * @since 1.0

 */

if(!function_exists('wb_form_builder_view_path')) {

    function wb_form_builder_view_path($view)

    {

        // Try to find overided file in theme_name/wpbooking/file-name.php

        $file=locate_template(array(

            'wpbooking/wpbooking-form-builder/'.$view.'.php'

        ),FALSE);



        if(!file_exists($file)){



            $file=WB_Form_Builder::inst()->get_dir('shinetheme/views/'.$view.'.php');

        }



        $file=apply_filters('wb_form_builder_load_view_'.$view,$file,$view);



        if(file_exists($file)){



            return $file;

        }



        return false;

    }

}



/**

 * Get content by file name

 *

 * @since 1.0

 */

if(!function_exists('wb_form_builder_load_view')) {

    function wb_form_builder_load_view($view, $data = array())

    {

        $file=locate_template(array(

            'wpbooking/frontend/wpbooking-form-builder/'.$view.'.php'

        ),FALSE);



        if(!file_exists($file)){



            $file = WB_Form_Builder::inst()->get_dir('shinetheme/views/'.$view.'.php');

        }



        $file=apply_filters('wb_form_builder_load_view_'.$view,$file,$view,$data);



        if(file_exists($file)){



            if(is_array($data))

                extract($data);



            ob_start();

            include($file);

            return @ob_get_clean();

        }

    }

}



/**

 * Get field setting by field type

 *

 * @since 1.0

 */

if(!function_exists('wb_form_builder_field_setting')){

    function wb_form_builder_field_setting($field_data, $action = 'new', $key = false, $old_data = false){

        if(!empty($field_data)){

            $html = '';

            switch($field_data['type']){

                case 'text':

                    if($action == 'edit'){

                        $value = $old_data[$field_data['id']];

                        $input_name = 'item_data['.$key.']['.$field_data['id'].']';

                    }else{

                        $value = '';

                        $input_name = 'item_data[{{data.index}}]['.$field_data['id'].']';

                    }



                    $html .= '<p class="description description-wide '.((!empty($field_data['adv_field']))?'wb-advance-field':'').'"><label>

                                    '.$field_data['label'].(isset($field_data['require'])?'<span class="required"> *</span>':'').'<br><input type="text" class="widefat edit-form-item-'.$field_data['id'].'" name="'.$input_name.'" value="'.esc_attr($value).'">

                                    <span class="field-admin-desc">'.(isset($field_data['desc'])?$field_data['desc']:'').'</span>

                                    </label>

                                    </p>';

                    break;

                case 'checkbox':

                    if($action == 'edit'){

                        $value = isset($old_data[$field_data['id']])?$old_data[$field_data['id']]:'';

                        $input_name = 'item_data['.$key.']['.$field_data['id'].']';

                    }else{

                        $value = '';

                        $input_name = 'item_data[{{data.index}}]['.$field_data['id'].']';

                    }

                    $html .= '<p class="description wb-option-checkbox">

					        <label>

						        <input type="checkbox" '.checked('1',$value,false).' value="1" name="'.$input_name.'">'.$field_data['label'].'</label>

                        </p>';

                    break;

                case 'link':

                    $html .= '<p class="description">

					        <a href="#" class="wb-field-'.$field_data['id'].'">'.$field_data['label'].'</a>

                        </p>';

                    break;

                case 'hidden':

                    if($action == 'edit'){

                        $input_name = 'item_data['.$key.']['.$field_data['id'].']';

                    }else{

                        $input_name = 'item_data[{{data.index}}]['.$field_data['id'].']';

                    }

                    $html .= '<p class="description description-wide '.((!empty($field_data['adv_field']))?'wb-advance-field':'').'"><label>

                    '.$field_data['label'].(isset($field_data['require'])?'<span class="required"> *</span>':'').'<br>

                    <input type="text" readonly class="widefat edit-form-item-'.$field_data['id'].' wb-field-'.$field_data['id'].'" name="'.$input_name.'" value="'.$field_data['value'].'"></label></p>';

                    break;

                case 'select_option':

                    if($action == 'edit'){

                        $index = $key;

                        $input_name_value = 'item_data['.$key.']['.$field_data['id'].'][op_value][]';

                        $input_name_key = 'item_data['.$key.']['.$field_data['id'].'][op_key][]';

                    }else{

                        $index = '{{data.index}}';

                        $input_name_key = 'item_data[{{data.index}}]['.$field_data['id'].'][op_key][]';

                        $input_name_value = 'item_data[{{data.index}}]['.$field_data['id'].'][op_value][]';

                    }

                    $html .= '<p class="description">

                            <label>'.$field_data['label'].'</label>

                            <span class="wb-value-table">

                                <span class="value-row-header">

                                    <span class="value-label">'.esc_html__('Value','traveler').'</span>

                                    <span class="value-label">'.esc_html__('Option','traveler').'</span>

                                    <span class="value-label"></span>

                                </span>';

                    $chck = false;

                    if($action == 'edit'){

                        if(!empty($old_data[$field_data['id']]) && is_array($old_data[$field_data['id']])){

                            $chck = true;

                            $i = 0;

                            foreach($old_data[$field_data['id']] as $key => $val){

                                $html .= '<span class="value-row-content">

                                    <span class="value-label key"><input type="text" name="' . $input_name_key . '" value="'.$key.'"></span>

                                    <span class="value-label"><input type="text" name="' . $input_name_value . '" value="'.esc_attr($val).'"></span>

                                    <span class="value-label">';

                                if($i != 0)

                                    $html .= '<i class="dashicons dashicons-no-alt"></i>';

                                $i++;

                                $html .= '</span>

                                </span>';

                            }

                        }

                    }

                    if(!$chck) {

                        $html .= '    <span class="value-row-content">

                                    <span class="value-label key"><input type="text" name="' . $input_name_key . '" value=""></span>

                                    <span class="value-label"><input type="text" name="' . $input_name_value . '" value=""></span>

                                    <span class="value-label"></span>

                                </span>';

                    }

                    $html .= '        </span>

                            <span class="add_new_row"><a class="wb-add-new-value" href="#" data-id="'.$field_data['id'].'" data-index="'.$index.'">'.esc_html__('Add new','traveler').'</a></span>

                        </p>';

                    break;

                case 'post_types':

                    $post_types = get_post_types();

                     if($action == 'edit'){

                        $value = $old_data[$field_data['id']];

                        $input_name = 'item_data['.$key.']['.$field_data['id'].']';

                    }else{

                        $value = '';

                        $input_name = 'item_data[{{data.index}}]['.$field_data['id'].']';

                    }

                    $html .= '<p class="description description-wide '.((!empty($field_data['adv_field']))?'wb-advance-field':'').'"><label>

                                    '.$field_data['label'].'<br>';

                    $html .= '<select class="widefat" name="'.$input_name.'">';

                    foreach($post_types as $key => $val){

                        $pt_opject = get_post_type_object($val);

                        if($val != 'attachment' && $val != 'revision' && $val != 'nav_menu_item' && $val != 'custom_css' && $val != 'customize_changeset' && $val != 'wpcf7_contact_form' && $val != 'option-tree' && $val != 'wb_form_builder' && $val != 'location'&& $val != 'st_layouts'&& $val != 'mc4wp-form'&& $val != 'st_flight'&& $val != 'st_order' && $val != 'st_coupon_code' && $val != 'vc4_templates' && $val != 'vc_grid_item'){

                            $html .= '<option '.selected($value, $val, false).' value="'.$val.'">'.$pt_opject->label.'</option>';

                        }

                    }

                    $html .= '</select></label></p>';

                    break;

                // case 'taxonomy':

                //     $taxonomy = get_object_taxonomies('wpbooking_service', 'array');

                //     if(!empty($taxonomy) && !is_wp_error($taxonomy )){

                //         if($action == 'edit'){

                //             $value = $old_data[$field_data['id']];

                //             $input_name = 'item_data['.$key.']['.$field_data['id'].']';

                //         }else{

                //             $value = '';

                //             $input_name = 'item_data[{{data.index}}]['.$field_data['id'].']';

                //         }

                //         $html .= '<p class="description description-wide '.((!empty($field_data['adv_field']))?'wb-advance-field':'').'"><label>

                //                         '.$field_data['label'].'<br>';



                //         $html .= '<select class="widefat" name="'.$input_name.'">';

                //         foreach ($taxonomy as $key => $val) {

                //             if ($key == 'wpbooking_location') continue;

                //             if ($key == 'wpbooking_extra_service') continue;

                //             if ($key == 'wb_review_stats') continue;

                //             if ($key == 'wb_tour_type') continue;

                //             $html .= '<option '.selected($value, $key, false).' value="'.$key.'">'.$val->label.'</option>';

                //         }

                //         $html .= '</select></label></p>';

                //     }

                //     break;

            }

            return $html;

        }

        return '';

    }

}



/**

 * Check form user for checkout

 *

 * @since 1.0

 */

if(!function_exists('wb_use_for_checkout')){

    function wb_use_for_checkout(){

        $form_id = get_option('wb_form_use_for_checkout','');

        return !empty($form_id)?$form_id:0;

    }

}



/**

 * List country

 *

 * @since 1.0

 */

if(!function_exists('wb_list_country')){

    function wb_list_country(){

        $country_array = array(

            ''   => esc_html__('--Select country--','traveler'),

            "AF" => esc_html__("Afghanistan",'traveler'),

            "AL" => esc_html__("Albania",'traveler'),

            "DZ" => esc_html__("Algeria",'traveler'),

            "AS" => esc_html__("American Samoa",'traveler'),

            "AD" => esc_html__("Andorra",'traveler'),

            "AO" => esc_html__("Angola",'traveler'),

            "AI" => esc_html__("Anguilla",'traveler'),

            "AQ" => esc_html__("Antarctica",'traveler'),

            "AG" => esc_html__("Antigua and Barbuda",'traveler'),

            "AR" => esc_html__("Argentina",'traveler'),

            "AM" => esc_html__("Armenia",'traveler'),

            "AW" => esc_html__("Aruba",'traveler'),

            "AU" => esc_html__("Australia",'traveler'),

            "AT" => esc_html__("Austria",'traveler'),

            "AZ" => esc_html__("Azerbaijan",'traveler'),

            "BS" => esc_html__("Bahamas",'traveler'),

            "BH" => esc_html__("Bahrain",'traveler'),

            "BD" => esc_html__("Bangladesh",'traveler'),

            "BB" => esc_html__("Barbados",'traveler'),

            "BY" => esc_html__("Belarus",'traveler'),

            "BE" => esc_html__("Belgium",'traveler'),

            "BZ" => esc_html__("Belize",'traveler'),

            "BJ" => esc_html__("Benin",'traveler'),

            "BM" => esc_html__("Bermuda",'traveler'),

            "BT" => esc_html__("Bhutan",'traveler'),

            "BO" => esc_html__("Bolivia",'traveler'),

            "BA" => esc_html__("Bosnia and Herzegovina",'traveler'),

            "BW" => esc_html__("Botswana",'traveler'),

            "BV" => esc_html__("Bouvet Island",'traveler'),

            "BR" => esc_html__("Brazil",'traveler'),

            "BQ" => esc_html__("British Antarctic Territory",'traveler'),

            "IO" => esc_html__("British Indian Ocean Territory",'traveler'),

            "VG" => esc_html__("British Virgin Islands",'traveler'),

            "BN" => esc_html__("Brunei",'traveler'),

            "BG" => esc_html__("Bulgaria",'traveler'),

            "BF" => esc_html__("Burkina Faso",'traveler'),

            "BI" => esc_html__("Burundi",'traveler'),

            "KH" => esc_html__("Cambodia",'traveler'),

            "CM" => esc_html__("Cameroon",'traveler'),

            "CA" => esc_html__("Canada",'traveler'),

            "CT" => esc_html__("Canton and Enderbury Islands",'traveler'),

            "CV" => esc_html__("Cape Verde",'traveler'),

            "KY" => esc_html__("Cayman Islands",'traveler'),

            "CF" => esc_html__("Central African Republic",'traveler'),

            "TD" => esc_html__("Chad",'traveler'),

            "CL" => esc_html__("Chile",'traveler'),

            "CN" => esc_html__("China",'traveler'),

            "CX" => esc_html__("Christmas Island",'traveler'),

            "CC" => esc_html__("Cocos [Keeling] Islands",'traveler'),

            "CO" => esc_html__("Colombia",'traveler'),

            "KM" => esc_html__("Comoros",'traveler'),

            "CG" => esc_html__("Congo - Brazzaville",'traveler'),

            "CD" => esc_html__("Congo - Kinshasa",'traveler'),

            "CK" => esc_html__("Cook Islands",'traveler'),

            "CR" => esc_html__("Costa Rica",'traveler'),

            "HR" => esc_html__("Croatia",'traveler'),

            "CU" => esc_html__("Cuba",'traveler'),

            "CY" => esc_html__("Cyprus",'traveler'),

            "CZ" => esc_html__("Czech Republic",'traveler'),

            "CI" => esc_html__("Côte d’Ivoire",'traveler'),

            "DK" => esc_html__("Denmark",'traveler'),

            "DJ" => esc_html__("Djibouti",'traveler'),

            "DM" => esc_html__("Dominica",'traveler'),

            "DO" => esc_html__("Dominican Republic",'traveler'),

            "NQ" => esc_html__("Dronning Maud Land",'traveler'),

            "DD" => esc_html__("East Germany",'traveler'),

            "EC" => esc_html__("Ecuador",'traveler'),

            "EG" => esc_html__("Egypt",'traveler'),

            "SV" => esc_html__("El Salvador",'traveler'),

            "GQ" => esc_html__("Equatorial Guinea",'traveler'),

            "ER" => esc_html__("Eritrea",'traveler'),

            "EE" => esc_html__("Estonia",'traveler'),

            "ET" => esc_html__("Ethiopia",'traveler'),

            "FK" => esc_html__("Falkland Islands",'traveler'),

            "FO" => esc_html__("Faroe Islands",'traveler'),

            "FJ" => esc_html__("Fiji",'traveler'),

            "FI" => esc_html__("Finland",'traveler'),

            "FR" => esc_html__("France",'traveler'),

            "GF" => esc_html__("French Guiana",'traveler'),

            "PF" => esc_html__("French Polynesia",'traveler'),

            "TF" => esc_html__("French Southern Territories",'traveler'),

            "FQ" => esc_html__("French Southern and Antarctic Territories",'traveler'),

            "GA" => esc_html__("Gabon",'traveler'),

            "GM" => esc_html__("Gambia",'traveler'),

            "GE" => esc_html__("Georgia",'traveler'),

            "DE" => esc_html__("Germany",'traveler'),

            "GH" => esc_html__("Ghana",'traveler'),

            "GI" => esc_html__("Gibraltar",'traveler'),

            "GR" => esc_html__("Greece",'traveler'),

            "GL" => esc_html__("Greenland",'traveler'),

            "GD" => esc_html__("Grenada",'traveler'),

            "GP" => esc_html__("Guadeloupe",'traveler'),

            "GU" => esc_html__("Guam",'traveler'),

            "GT" => esc_html__("Guatemala",'traveler'),

            "GG" => esc_html__("Guernsey",'traveler'),

            "GN" => esc_html__("Guinea",'traveler'),

            "GW" => esc_html__("Guinea-Bissau",'traveler'),

            "GY" => esc_html__("Guyana",'traveler'),

            "HT" => esc_html__("Haiti",'traveler'),

            "HM" => esc_html__("Heard Island and McDonald Islands",'traveler'),

            "HN" => esc_html__("Honduras",'traveler'),

            "HK" => esc_html__("Hong Kong SAR China",'traveler'),

            "HU" => esc_html__("Hungary",'traveler'),

            "IS" => esc_html__("Iceland",'traveler'),

            "IN" => esc_html__("India",'traveler'),

            "ID" => esc_html__("Indonesia",'traveler'),

            "IR" => esc_html__("Iran",'traveler'),

            "IQ" => esc_html__("Iraq",'traveler'),

            "IE" => esc_html__("Ireland",'traveler'),

            "IM" => esc_html__("Isle of Man",'traveler'),

            "IL" => esc_html__("Israel",'traveler'),

            "IT" => esc_html__("Italy",'traveler'),

            "JM" => esc_html__("Jamaica",'traveler'),

            "JP" => esc_html__("Japan",'traveler'),

            "JE" => esc_html__("Jersey",'traveler'),

            "JT" => esc_html__("Johnston Island",'traveler'),

            "JO" => esc_html__("Jordan",'traveler'),

            "KZ" => esc_html__("Kazakhstan",'traveler'),

            "KE" => esc_html__("Kenya",'traveler'),

            "KI" => esc_html__("Kiribati",'traveler'),

            "KW" => esc_html__("Kuwait",'traveler'),

            "KG" => esc_html__("Kyrgyzstan",'traveler'),

            "LA" => esc_html__("Laos",'traveler'),

            "LV" => esc_html__("Latvia",'traveler'),

            "LB" => esc_html__("Lebanon",'traveler'),

            "LS" => esc_html__("Lesotho",'traveler'),

            "LR" => esc_html__("Liberia",'traveler'),

            "LY" => esc_html__("Libya",'traveler'),

            "LI" => esc_html__("Liechtenstein",'traveler'),

            "LT" => esc_html__("Lithuania",'traveler'),

            "LU" => esc_html__("Luxembourg",'traveler'),

            "MO" => esc_html__("Macau SAR China",'traveler'),

            "MK" => esc_html__("Macedonia",'traveler'),

            "MG" => esc_html__("Madagascar",'traveler'),

            "MW" => esc_html__("Malawi",'traveler'),

            "MY" => esc_html__("Malaysia",'traveler'),

            "MV" => esc_html__("Maldives",'traveler'),

            "ML" => esc_html__("Mali",'traveler'),

            "MT" => esc_html__("Malta",'traveler'),

            "MH" => esc_html__("Marshall Islands",'traveler'),

            "MQ" => esc_html__("Martinique",'traveler'),

            "MR" => esc_html__("Mauritania",'traveler'),

            "MU" => esc_html__("Mauritius",'traveler'),

            "YT" => esc_html__("Mayotte",'traveler'),

            "FX" => esc_html__("Metropolitan France",'traveler'),

            "MX" => esc_html__("Mexico",'traveler'),

            "FM" => esc_html__("Micronesia",'traveler'),

            "MI" => esc_html__("Midway Islands",'traveler'),

            "MD" => esc_html__("Moldova",'traveler'),

            "MC" => esc_html__("Monaco",'traveler'),

            "MN" => esc_html__("Mongolia",'traveler'),

            "ME" => esc_html__("Montenegro",'traveler'),

            "MS" => esc_html__("Montserrat",'traveler'),

            "MA" => esc_html__("Morocco",'traveler'),

            "MZ" => esc_html__("Mozambique",'traveler'),

            "MM" => esc_html__("Myanmar [Burma]",'traveler'),

            "NA" => esc_html__("Namibia",'traveler'),

            "NR" => esc_html__("Nauru",'traveler'),

            "NP" => esc_html__("Nepal",'traveler'),

            "NL" => esc_html__("Netherlands",'traveler'),

            "AN" => esc_html__("Netherlands Antilles",'traveler'),

            "NT" => esc_html__("Neutral Zone",'traveler'),

            "NC" => esc_html__("New Caledonia",'traveler'),

            "NZ" => esc_html__("New Zealand",'traveler'),

            "NI" => esc_html__("Nicaragua",'traveler'),

            "NE" => esc_html__("Niger",'traveler'),

            "NG" => esc_html__("Nigeria",'traveler'),

            "NU" => esc_html__("Niue",'traveler'),

            "NF" => esc_html__("Norfolk Island",'traveler'),

            "KP" => esc_html__("North Korea",'traveler'),

            "VD" => esc_html__("North Vietnam",'traveler'),

            "MP" => esc_html__("Northern Mariana Islands",'traveler'),

            "NO" => esc_html__("Norway",'traveler'),

            "OM" => esc_html__("Oman",'traveler'),

            "PC" => esc_html__("Pacific Islands Trust Territory",'traveler'),

            "PK" => esc_html__("Pakistan",'traveler'),

            "PW" => esc_html__("Palau",'traveler'),

            "PS" => esc_html__("Palestinian Territories",'traveler'),

            "PA" => esc_html__("Panama",'traveler'),

            "PZ" => esc_html__("Panama Canal Zone",'traveler'),

            "PG" => esc_html__("Papua New Guinea",'traveler'),

            "PY" => esc_html__("Paraguay",'traveler'),

            "YD" => esc_html__("People's Democratic Republic of Yemen",'traveler'),

            "PE" => esc_html__("Peru",'traveler'),

            "PH" => esc_html__("Philippines",'traveler'),

            "PN" => esc_html__("Pitcairn Islands",'traveler'),

            "PL" => esc_html__("Poland",'traveler'),

            "PT" => esc_html__("Portugal",'traveler'),

            "PR" => esc_html__("Puerto Rico",'traveler'),

            "QA" => esc_html__("Qatar",'traveler'),

            "RO" => esc_html__("Romania",'traveler'),

            "RU" => esc_html__("Russia",'traveler'),

            "RW" => esc_html__("Rwanda",'traveler'),

            "RE" => esc_html__("Réunion",'traveler'),

            "BL" => esc_html__("Saint Barthélemy",'traveler'),

            "SH" => esc_html__("Saint Helena",'traveler'),

            "KN" => esc_html__("Saint Kitts and Nevis",'traveler'),

            "LC" => esc_html__("Saint Lucia",'traveler'),

            "MF" => esc_html__("Saint Martin",'traveler'),

            "PM" => esc_html__("Saint Pierre and Miquelon",'traveler'),

            "VC" => esc_html__("Saint Vincent and the Grenadines",'traveler'),

            "WS" => esc_html__("Samoa",'traveler'),

            "SM" => esc_html__("San Marino",'traveler'),

            "SA" => esc_html__("Saudi Arabia",'traveler'),

            "SN" => esc_html__("Senegal",'traveler'),

            "RS" => esc_html__("Serbia",'traveler'),

            "CS" => esc_html__("Serbia and Montenegro",'traveler'),

            "SC" => esc_html__("Seychelles",'traveler'),

            "SL" => esc_html__("Sierra Leone",'traveler'),

            "SG" => esc_html__("Singapore",'traveler'),

            "SK" => esc_html__("Slovakia",'traveler'),

            "SI" => esc_html__("Slovenia",'traveler'),

            "SB" => esc_html__("Solomon Islands",'traveler'),

            "SO" => esc_html__("Somalia",'traveler'),

            "ZA" => esc_html__("South Africa",'traveler'),

            "GS" => esc_html__("South Georgia and the South Sandwich Islands",'traveler'),

            "KR" => esc_html__("South Korea",'traveler'),

            "ES" => esc_html__("Spain",'traveler'),

            "LK" => esc_html__("Sri Lanka",'traveler'),

            "SD" => esc_html__("Sudan",'traveler'),

            "SR" => esc_html__("Suriname",'traveler'),

            "SJ" => esc_html__("Svalbard and Jan Mayen",'traveler'),

            "SZ" => esc_html__("Swaziland",'traveler'),

            "SE" => esc_html__("Sweden",'traveler'),

            "CH" => esc_html__("Switzerland",'traveler'),

            "SY" => esc_html__("Syria",'traveler'),

            "ST" => esc_html__("São Tomé and Príncipe",'traveler'),

            "TW" => esc_html__("Taiwan",'traveler'),

            "TJ" => esc_html__("Tajikistan",'traveler'),

            "TZ" => esc_html__("Tanzania",'traveler'),

            "TH" => esc_html__("Thailand",'traveler'),

            "TL" => esc_html__("Timor-Leste",'traveler'),

            "TG" => esc_html__("Togo",'traveler'),

            "TK" => esc_html__("Tokelau",'traveler'),

            "TO" => esc_html__("Tonga",'traveler'),

            "TT" => esc_html__("Trinidad and Tobago",'traveler'),

            "TN" => esc_html__("Tunisia",'traveler'),

            "TR" => esc_html__("Turkey",'traveler'),

            "TM" => esc_html__("Turkmenistan",'traveler'),

            "TC" => esc_html__("Turks and Caicos Islands",'traveler'),

            "TV" => esc_html__("Tuvalu",'traveler'),

            "UM" => esc_html__("U.S. Minor Outlying Islands",'traveler'),

            "PU" => esc_html__("U.S. Miscellaneous Pacific Islands",'traveler'),

            "VI" => esc_html__("U.S. Virgin Islands",'traveler'),

            "UG" => esc_html__("Uganda",'traveler'),

            "UA" => esc_html__("Ukraine",'traveler'),

            "SU" => esc_html__("Union of Soviet Socialist Republics",'traveler'),

            "AE" => esc_html__("United Arab Emirates",'traveler'),

            "GB" => esc_html__("United Kingdom",'traveler'),

            "US" => esc_html__("United States",'traveler'),

            "ZZ" => esc_html__("Unknown or Invalid Region",'traveler'),

            "UY" => esc_html__("Uruguay",'traveler'),

            "UZ" => esc_html__("Uzbekistan",'traveler'),

            "VU" => esc_html__("Vanuatu",'traveler'),

            "VA" => esc_html__("Vatican City",'traveler'),

            "VE" => esc_html__("Venezuela",'traveler'),

            "VN" => esc_html__("Vietnam",'traveler'),

            "WK" => esc_html__("Wake Island",'traveler'),

            "WF" => esc_html__("Wallis and Futuna",'traveler'),

            "EH" => esc_html__("Western Sahara",'traveler'),

            "YE" => esc_html__("Yemen",'traveler'),

            "ZM" => esc_html__("Zambia",'traveler'),

            "ZW" => esc_html__("Zimbabwe",'traveler'),

            "AX" => esc_html__("Åland Islands",'traveler')

        );
        return apply_filters('st_form_builder_list_country',$country_array);

    }

}



if(!function_exists('wb_get_admin_message'))

{

    function wb_get_admin_message($clear_message=true){

        $message = WB_Form_Builder::inst()->get_admin_message($clear_message);



        if($message){

            $type=$message['type'];

            switch($type){

                case "error":

                    $type='error';

                    break;

                case "success":

                    $type='updated';

                    break;

                default:

                    $type='notice-warning';

                    break;

            }

            return sprintf('<div class="notice %s" >%s</div>',$type,$message['content']);

        }



        return false;

    }

}

if(!function_exists('wb_set_admin_message'))

{

    function wb_set_admin_message($message,$type='information'){

        WB_Form_Builder::inst()->set_admin_message($message,$type);

    }

}