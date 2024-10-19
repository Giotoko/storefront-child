<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

// END ENQUEUE PARENT ACTION


/**
 * Output the related products.
 */
function storefront_child_output_related_products()
{
    error_log("hmmm");
    $args = array(
        'posts_per_page' => 3,
        'columns'        => 3,
        'orderby'        => 'rand', // @codingStandardsIgnoreLine.
    );

    storefront_child_related_products(apply_filters('woocommerce_output_related_products_args', $args));
}


/**
 * Output the related products.
 *
 * @param array $args Provided arguments.
 */
function storefront_child_related_products($args = array())
{
    global $product;

    if (! $product) {
        return;
    }

    $defaults = array(
        'posts_per_page' => 3,
        'columns'        => 3,
        'orderby'        => 'rand', // @codingStandardsIgnoreLine.
        'order'          => 'desc',
        'category'       => wc_get_product_category_list($product->get_id()),
    );

    $args = wp_parse_args($args, $defaults);

    // Get visible related products then sort them at random.
    $args['related_products'] = array_filter(array_map('wc_get_product', wc_get_products($args)), 'wc_products_array_filter_visible');

    // Handle orderby.
    $args['related_products'] = wc_products_array_orderby($args['related_products'], $args['orderby'], $args['order']);

    // Set global loop values.
    wc_set_loop_prop('name', 'related');
    wc_set_loop_prop('columns', apply_filters('woocommerce_related_products_columns', $args['columns']));

    wc_get_template('single-product/custom-related.php', $args);
}

add_action('woocommerce_after_single_product_summary', 'storefront_child_output_related_products', 10);
