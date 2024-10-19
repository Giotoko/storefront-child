<?php

/**
 * Custom Related Products
 */

if (! defined('ABSPATH')) {
    exit;
}
global $product;

if ($related_products) : ?>

    <section class="related products custom-related">

        <h2 class="custom-related"><?php echo esc_html("Custom related products"); ?></h2>

        <?php woocommerce_product_loop_start(); ?>

        <?php foreach ($related_products as $related_product) : ?>

            <?php
            //exclude the current product from the list
            if ($product->get_id() == $related_product->get_id()) {
                continue;
            }

            $post_object = get_post($related_product->get_id());

            setup_postdata($GLOBALS['post'] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

            wc_get_template_part('content-product-custom');
            ?>

        <?php endforeach; ?>

        <?php woocommerce_product_loop_end(); ?>

    </section>
<?php
endif;

wp_reset_postdata();
