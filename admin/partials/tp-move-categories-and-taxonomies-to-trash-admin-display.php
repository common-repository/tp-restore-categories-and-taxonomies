<div class="tpmcattt-warp">
    <h1><?php echo esc_html(TPMCATTT_PLUGIN_NAME); ?> <a href="<?php echo esc_url(''.TPMCATTT_PLUGIN_HOME.'product/'.TPMCATTT_PLUGIN_SLUG_PRO.''); ?>" target="_blank" class="tpmcattt-get-pro-link-a">Get PRO</a></h1>

    <div class="lds-roller-mask"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>
        
    <?php if($results || $results_woo): ?>
    
        <table id="tpmcattt-table" class="tpmcattt-table display" style="width:100%">
            <thead>
                <tr>
                    <th>Term id</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Taxonomy</th>
                    <th>Term Group</th>
                    <th>Count</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($results): ?>
                    <?php foreach($results as $result): ?>
                        <tr id="tr-<?php echo esc_attr($result->term_id); ?>">
                            <td><?php echo esc_html($result->term_id); ?></td>
                            <td><?php echo esc_html($result->name); ?></td>
                            <td><?php echo esc_html($result->slug); ?></td>
                            <td><?php echo esc_html($result->description); ?></td>
                            <td><?php echo esc_html($result->taxonomy); ?></td>
                            <td><?php echo esc_html($result->term_group); ?></td>
                            <td><?php echo esc_html($result->count); ?></td>
                            <td><?php echo esc_html($result->term_status); ?></td>
                            <td>
                                <span class="dashicons dashicons-image-rotate" onclick="tpmcattt_restore_term(<?php echo esc_js($result->term_id); ?>);"></span>
                                <span class="dashicons dashicons-trash" onclick="tpmcattt_delete_term(<?php echo esc_js($result->term_id); ?>);"></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if($results_woo): ?>
                    <?php foreach($results_woo as $result_woo): ?>
                        <tr id="tr-<?php echo esc_attr($result_woo->attribute_id); ?>">
                            <td><?php echo esc_html($result_woo->attribute_id); ?></td>
                            <td><?php echo esc_html($result_woo->attribute_label); ?></td>
                            <td><?php echo esc_html($result_woo->attribute_name); ?></td>
                            <td><?php echo ''; ?></td>
                            <td><?php echo ''; ?></td>
                            <td><?php echo ''; ?></td>
                            <td><?php echo ''; ?></td>
                            <td><?php echo 'trash'; ?></td>
                            <td>
                                <span class="dashicons dashicons-image-rotate" onclick="tpmcattt_restore_woo_term(<?php echo esc_js($result_woo->attribute_id); ?>);"></span>
                                <span class="dashicons dashicons-trash" onclick="tpmcattt_delete_woo_term(<?php echo esc_js($result_woo->attribute_id); ?>);"></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Term id</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Taxonomy</th>
                    <th>Term Group</th>
                    <th>Count</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>

        <div id="tpmcattt-test"></div>

    <?php else: ?>
        <h2>You don't have Categories / Taxonomies in trash</h2>
    <?php endif; ?>
        
</div>