<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       austinnchristensen.com
 * @since      1.0.0
 *
 * @package    Fbp_Plug
 * @subpackage Fbp_Plug/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <h2 class="nav-tab-wrapper">Clean up</h2>

    <form method="post" name="cleanup_options" action="options.php">

    <?php
        //Grab all options      
        $options = get_option($this->plugin_name);
            
        // Cleanup
        $cleanup = $options['cleanup'];
        $comments_css_cleanup = $options['comments_css_cleanup'];
        $gallery_css_cleanup = $options['gallery_css_cleanup'];
        $body_class_slug = $options['body_class_slug'];
        $jquery_cdn = $options['jquery_cdn'];
        $cdn_provider = $options['cdn_provider'];
        
        // New Login customization vars
        $login_logo_id = $options['login_logo_id'];
        $login_logo = wp_get_attachment_image_src( $login_logo_id, 'thumbnail' );
        $login_logo_url = $login_logo[0];
        $login_background_color = $options['login_background_color'];
        $login_button_primary_color = $options['login_button_primary_color'];

    ?>

    ...


        <!-- Login page customizations -->

        <h2 class="nav-tab-wrapper"><?php _e('Login customization', $this->plugin_name);?></h2>

            <p><?php _e('Add logo to login form change buttons and background color', $this->plugin_name);?></p>

            <!-- add your logo to login -->
                <fieldset>
                    <legend class="screen-reader-text"><span><?php esc_attr_e('Login Logo', $this->plugin_name);?></span></legend>
                    <label for="<?php echo $this->plugin_name;?>-login_logo">
                        <input type="hidden" id="login_logo_id" name="<?php echo $this->plugin_name;?>[login_logo_id]" value="<?php echo $login_logo_id; ?>" />
                        <input id="upload_login_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', $this->plugin_name); ?>" />
                        <span><?php esc_attr_e('Login Logo', $this->plugin_name);?></span>
                    </label>
                    <div id="upload_logo_preview" class="wp_cbf-upload-preview <?php if(empty($login_logo_id)) echo 'hidden'?>">
                        <img src="<?php echo $login_logo_url; ?>" />
                        <button id="wp_cbf-delete_logo_button" class="wp_cbf-delete-image">X</button>
                    </div>
                </fieldset>

            <!-- login background color-->
                <fieldset class="wp_cbf-admin-colors">
                    <legend class="screen-reader-text"><span><?php _e('Login Background Color', $this->plugin_name);?></span></legend>
                    <label for="<?php echo $this->plugin_name;?>-login_background_color">
                        <input type="text" class="<?php echo $this->plugin_name;?>-color-picker" id="<?php echo $this->plugin_name;?>-login_background_color" name="<?php echo $this->plugin_name;?>[login_background_color]"  value="<?php echo $login_background_color;?>"  />
                        <span><?php esc_attr_e('Login Background Color', $this->plugin_name);?></span>
                    </label>
                </fieldset>
                
            <!-- login buttons and links primary color-->
                <fieldset class="wp_cbf-admin-colors">
                    <legend class="screen-reader-text"><span><?php _e('Login Button and Links Color', $this->plugin_name);?></span></legend>
                    <label for="<?php echo $this->plugin_name;?>-login_button_primary_color">
                        <input type="text" class="<?php echo $this->plugin_name;?>-color-picker" id="<?php echo $this->plugin_name;?>-login_button_primary_color" name="<?php echo $this->plugin_name;?>[login_button_primary_color]" value="<?php echo $login_button_primary_color;?>" />
                        <span><?php esc_attr_e('Login Button and Links Color', $this->plugin_name);?></span>
                    </label>
                </fieldset>

            <?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>

     </form>


</div>