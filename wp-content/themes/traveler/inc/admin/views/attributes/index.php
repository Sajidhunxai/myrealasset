<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Admin attributes index
 *
 * Created by ShineTheme
 *
 */
?>
<div class="wrap woocommerce">
    <div class="icon32 icon32-attributes" id="icon-woocommerce"><br/></div>
    <h2><?php _e( 'Attributes', 'traveler' ) ?></h2>
    <br class="clear" />
    <div id="col-container">
        <div id="col-right">
            <div class="col-wrap">
                <table class="widefat attributes-table wp-list-table ui-sortable" style="width:100%">
                    <thead>
                    <tr>
                        <th scope="col"><?php _e( 'Name', 'traveler' ) ?></th>
                        <th scope="col"><?php _e( 'Slug', 'traveler' ) ?></th>
                        <th scope="col"><?php _e( 'Hierarchical', 'traveler' ) ?></th>
                        <th scope="col" colspan="2"><?php _e( 'Post Types', 'traveler' ) ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $attribute=new STAttribute();

                    $attribute_taxonomies=$attribute->get_attributes();

                    if ( $attribute_taxonomies and !empty($attribute_taxonomies) ) :
                        foreach ($attribute_taxonomies as $tax=>$value) :
                            $name = $value['name'];
                            ?><tr>

                            <td><a href="edit-tags.php?taxonomy=<?php echo esc_html($tax); ?>"><?php echo esc_html( $name ); ?></a>

                                <div class="row-actions"><span class="edit"><a href="<?php echo esc_url( add_query_arg('edit', $tax) ); ?>"><?php _e( 'Edit', 'traveler' ); ?></a> | </span><span class="delete"><a class="delete" href="<?php echo esc_url( wp_nonce_url( add_query_arg('delete', $tax), 'st_delete_attribute' ) ); ?>"><?php _e( 'Delete', 'traveler' ); ?></a></span></div>
                            </td>
                            <td><?php echo esc_html( $tax ); ?></td>
                            <td><?php if($value['hierarchical']) echo __('Yes','traveler'); else echo __('No','traveler'); ?></td>

                            <td class="attribute-terms"><?php
                                if(!empty($value['post_type']) and is_array($value['post_type']))
                                {
                                    foreach($value['post_type'] as $k=>$v){
                                        $obj=get_post_type_object($v);
                                        if($obj){
                                            if($k)
                                            {
                                                echo ', ';
                                            }
                                            echo ($obj->labels->name);
                                        }
                                    }
                                }
                                ?></td>
                            <?php
                        endforeach;
                    else :
                        ?><tr><td colspan="6"><?php _e( 'No attributes currently exist.', 'traveler' ) ?></td></tr><?php
                    endif;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="col-left">
            <div class="col-wrap">
                <div class="form-wrap">
                    <h3><?php _e( 'Add New Attribute', 'traveler' ) ?></h3>
                    <p><?php _e( 'Attributes let you define unlimited extra infomation for Hotel, Car ..etc', 'traveler' ) ?></p>
                    <form action="#" method="post">
                        <div class="form-field">
                            <label for="attribute_label"><?php _e( 'Name', 'traveler' ); ?></label>
                            <input name="attribute_label" id="attribute_label" type="text" value="" />
                            <p class="description"><?php _e( 'Name for the attribute (shown on the front-end).', 'traveler' ); ?></p>
                        </div>
                        <div class="form-field">
                            <label for="attribute_name"><?php _e( 'Slug (Required)', 'traveler' ); ?></label>
                            <input name="attribute_name" id="attribute_name" type="text" value="" maxlength="28" />
                            <p class="description"><?php _e( 'Unique slug/reference for the attribute; must be shorter than 28 characters and type Alphabet.', 'traveler' ); ?></p>
                        </div>
                        <div class="form-field" style="display: none !important;">
                            <label for="attribute_type"><?php _e( 'Hierarchy', 'traveler' ); ?></label>
                            <select name="attribute_type" id="attribute_type">
                                <option value="1"><?php _e( 'Yes', 'traveler' ) ?></option>
                                <option value="0"><?php _e( 'No', 'traveler' ) ?></option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="attribute_post_type"><?php _e( 'Post Types', 'traveler' ); ?></label>
                                <?php $post_types=get_post_types(array('public'=>true),'objects');

                                ?>
                                <?php if(!empty($post_types))
                                {
                                    foreach($post_types as $key=>$value)
                                    {
                                        ?>
                                        <label >
                                        <input name="attribute_post_type[]" type='checkbox' value="<?php echo esc_html($key) ?>"/><?php echo esc_html($value->labels->name) ?></label>
                                        <?php
                                    }

                                }?>
                        </div>
                        <p class="submit"><input type="submit" name="st_save_attribute" id="submit" class="button" value="<?php _e( 'Add Attribute', 'traveler' ); ?>"></p>
                        <?php wp_nonce_field( 'st_save_attribute' ); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>