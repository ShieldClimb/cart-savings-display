<?php

/**
 * Plugin Name: ShieldClimb – Cart Savings Display for WooCommerce
 * Plugin URI: https://shieldclimb.com/free-woocommerce-plugins/cart-savings-display/
 * Description: Cart Savings Display for WooCommerce shows customers their total savings in the cart & checkout, boosting conversions and purchase confidence.
 * Version: 1.0.2
 * Requires Plugins: woocommerce
 * Requires at least: 5.8
 * Tested up to: 6.8
 * WC requires at least: 5.8
 * WC tested up to: 9.8.1
 * Requires PHP: 7.2
 * Author: shieldclimb.com
 * Author URI: https://shieldclimb.com/about-us/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('woocommerce_cart_totals_after_order_total', 'shieldclimb_cart_savings_display', 9999);
add_action('woocommerce_review_order_after_order_total', 'shieldclimb_cart_savings_display', 9999);

function shieldclimb_cart_savings_display() {   
    $discount_total = 0;  

    foreach (WC()->cart->get_cart() as $cart_item_key => $values) {         
        $product = $values['data'];
        if ($product->is_on_sale()) {
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            $discount = ((float) $regular_price - (float) $sale_price) * (int) $values['quantity'];
            $discount_total += $discount;
        }
    }

    if ($discount_total > 0) {
        echo '<tr><th>' . esc_html__('You Saved', 'shieldclimb-cart-savings-display') . '</th><td data-title="' . esc_attr__('You Saved', 'shieldclimb-cart-savings-display') . '">' . wp_kses_post(wc_price($discount_total + WC()->cart->get_discount_total())) . '</td></tr>';
    }
}

?>