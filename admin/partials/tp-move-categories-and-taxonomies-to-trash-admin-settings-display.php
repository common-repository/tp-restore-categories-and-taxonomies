<div class="tpmcattt-warp">
    <h1><?php echo esc_html(TPMCATTT_PLUGIN_NAME); ?> Settings</h1>

    <form method="post" action="options.php">
        <?php settings_fields( 'tpmcattt-plugin-settings-group' ); ?>
        <?php do_settings_sections( 'tpmcattt-plugin-settings-group' ); ?>

        <div id="tpmcattt-tabs" class="tpglobal-tabs">
            <ul>
                <li><a href="#tabs-1">Settings</a></li>
                <li><a href="#tabs-6">Video</a></li>
                <li><a href="#tabs-7">License (Get PRO)</a></li>
                <!-- <li><a href="#tabs-8">Logs</a></li> -->
            </ul>

            <div id="tabs-1" class="tpglobal-tabs-content">

                <div class="tpglobal-tabs-row">
                    <div class="tpglobal-tabs-row-ins">
                        
                        <h2>Free Plugin Features</h2>
                        <ul>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Wordpress Categories.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Wordpress Tags.</li>
                        </ul>
                        
                        <div class="tpglobal-space"></div>

                        <h2>Pro Version Features</h2>
                        <ul>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Wordpress Categories.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Wordpress Tags.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Wordpress Custom Taxonomy.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Wordpress Taxonomy / Categories / Tags Custom Fields.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Wordpress Taxonomy / Categories / Tags ACF.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Woocommerce Product Categories.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Woocommerce Product Tags.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Woocommerce Product Attributes (product variations).</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Woocommerce Taxonomy / Categories / Tags Custom Fields.</li>
                            <li><span class="dashicons dashicons-yes tpglobal-green"></span> Restore Woocommerce Taxonomy / Categories / Tags ACF.</li>
                        </ul>
                    </div>


                </div>
            
            </div>

            <div id="tabs-6" class="tpglobal-tabs-content">
                <h2>Plugin Demonstration</h2>
				<iframe width="50%" height="500" src="https://www.youtube.com/embed/YaS9L5h6mj0?rel=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div id="tabs-7" class="tpglobal-tabs-content">
                <h2>Free Version</h2>
				<a href="<?php echo esc_url(TPMCATTT_PLUGIN_HOME.'product/'.TPMCATTT_PLUGIN_SLUG_PRO); ?>" target="_blank">Upgrade from the FREE version to the PRO version</a>
            </div>

        </div><!-- tpglobal-tabs -->

        <?php submit_button(); ?>
    </form>
    
</div>