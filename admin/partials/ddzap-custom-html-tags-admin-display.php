<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://ddzap.com/about
 * @since      1.0.0
 *
 * @package    Ddzap_Custom_Html_Tags
 * @subpackage Ddzap_Custom_Html_Tags/admin/partials
 */
?>

<?php
    $tag_get = isset( $_GET[ 'tag' ] ) ? sanitize_text_field($_GET[ 'tag' ]) : '';
    $current_page = in_array( $tag_get, ['checkbox', 'radio'] ) ? $tag_get : 'checkbox';
?>

<?php Ddzap_Custom_Html_Tags_Admin::update_option($current_page); ?>

<?php $settings = Ddzap_Custom_Html_Tags_Admin::get_option($current_page); ?>

<div class="wrap ddzap-admin-display">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <h2><?php echo get_admin_page_title(); ?></h2>
        </div>
        <!-- /.col -->

        <div class="col-auto">
        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col">
            <ul class="subsubsub">
                <li class="checkbox">
                    <a href="<?php echo admin_url( '/themes.php?page=ddzap-custom-html-tags-admin-menu&tag=checkbox' ); ?>"
                       class="<?php echo $current_page === 'checkbox' ? 'current' : '' ?>"><?php _e('Checkbox', DDZAP_TEXT_DOMAIN); ?></a> |
                </li>
                <li class="radio">
                    <a href="<?php echo admin_url( '/themes.php?page=ddzap-custom-html-tags-admin-menu&tag=radio' ); ?>"
                       class="<?php echo $current_page === 'radio' ? 'current' : '' ?>"><?php _e('Radio', DDZAP_TEXT_DOMAIN); ?></a>
                </li>
            </ul>
            <!-- /.subsubsub -->

        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->

    <div class="row justify-content-between">
        <div class="col-md-9 col-6">
            <div class="block">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <h2><?php _e( 'Settings', DDZAP_TEXT_DOMAIN ); ?></h2>
                    </div>
                    <!-- /.col -->

                    <div class="col-auto">
                        <input type="submit" id="submit" form="ddzap-setting-form-<?php echo $current_page; ?>"
                               class="button button-primary" value="Save Changes">
                    </div>
                    <!-- /.col -->

                    <div class="col-12">
                        <hr>
                    </div>
                    <!-- /.col-12 -->

                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col">

                    <?php
                    switch ($current_page) {
                        case 'radio':
                            require_once plugin_dir_path( __FILE__ ) . 'ddzap-custom-html-tags-admin-form-radio.php';
                            break;
                        default:
                            require_once plugin_dir_path( __FILE__ ) . 'ddzap-custom-html-tags-admin-form-checkbox.php';
                            break;
                    }
                    ?>

                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->

            </div>
            <!-- /.block -->

        </div>
        <!-- /.col-md-9 .col-6 -->

        <div class="col-md-3 col-6">
            <div class="block">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <h2><?php _e( 'Preview', DDZAP_TEXT_DOMAIN ); ?></h2>
                    </div>
                    <!-- /.col -->

                    <div class="col-auto">
                        <button id="ddzap-button-update-preview" class="button button-primary">Refresh</button>
                    </div>
                    <!-- /.col -->

                    <div class="col-12">
                        <hr>
                    </div>
                    <!-- /.col-12 -->

                </div>
                <!-- /.row align-items-center justify-content-between -->

                <iframe src="<?php echo site_url( '?ddzap-preview=1#ddzap-preview-block' ); ?>" frameborder="0"
                        scrolling="no" id="ddzap-iframe-preview"></iframe>
                <!-- /#ddzap-iframe-preview -->

            </div>
            <!-- /.block -->

        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->

    <div class="row justify-content-between">
        <div class="col-6">
            <div class="block">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <h2><?php _e( 'CSS', DDZAP_TEXT_DOMAIN ); ?></h2>
                    </div>
                    <!-- /.col -->

                    <div class="col-auto">
                        <button id="ddzap-button-show-css" class="button button-primary">Show CSS</button>
                        <button id="ddzap-button-copy-css" class="button button-primary">Copy CSS</button>
                    </div>
                    <!-- /.col -->

                    <div class="col-12">
                        <hr>
                    </div>
                    <!-- /.col-12 -->

                </div>

                <pre class="style-css"></pre>

            </div>
            <!-- /.block -->

        </div>
        <!-- /.col -->

        <div class="col-6 script-block">
            <div class="block">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <h2><?php _e( 'JS', DDZAP_TEXT_DOMAIN ); ?></h2>
                    </div>
                    <!-- /.col -->

                    <div class="col-auto">
                        <button id="ddzap-button-show-js" class="button button-primary">Show JS</button>
                        <button id="ddzap-button-copy-js" class="button button-primary">Copy JS</button>
                    </div>
                    <!-- /.col -->

                    <div class="col-12">
                        <hr>
                    </div>
                    <!-- /.col-12 -->

                </div>

                <pre class="script-js"></pre>

            </div>
            <!-- /.block -->

        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->

</div>
<!-- /.wrap ddzap-admin-display -->

