<?php
/**
 * Template Name: Homepage Template
 * Template Post Type: page
 *
 * This is a custom page template for WordPress.
 *
 * @package Membership
 */

get_header(); ?>

<div class="membership-header bg-black">
  <div class="container">

    <?php echo mytheme_display_header_text(); ?>
    
    <!-- Pricing Toggle Section -->
    <div class="pricing-toggle text-center mb-40 d-flex justify-content-center align-items-center">
        <span class="text-white me-3">Pay Monthly</span>
        <div class="form-switch d-flex align-items-center">
            <input class="form-check-input" type="checkbox" id="pricingToggle">
            <label class="form-check-label text-muted" for="pricingToggle">Save with Yearly</label>
        </div>
    </div>
    
  </div>
</div>

<div class="pricing-section" >
    <div class="container">
        <div class="memberpress-products-wrapper">
            <?php
            $args = array(
                'post_type'      => 'memberpressproduct',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC'  
            );

            $products_query = new WP_Query($args);

            if ($products_query->have_posts()) :
                echo '<div class="products-grid">';
                while ($products_query->have_posts()) : $products_query->the_post();
                    $product = new MeprProduct(get_the_ID());

                    $product_identifier = get_post_meta(get_the_ID(), '_mepr_product_identifier', true);
                    $hide_box = get_post_meta(get_the_ID(), '_mepr_hide_box', true);

                    // $all_benefits = [
                    //     'View Trailers',
                    //     'Job Board',
                    //     'Watch Career and Education Trailers',
                    //     'Unlimited Access to Career boards',
                    //     'Unlimited Access to Career videos',
                    //     'Premium Industry Awareness Content'
                    // ];

                    $all_benefits = mytheme_get_benefits_array();
                    
                    $membership_title = $product->pricing_title;
                    $membership_heading_text = $product->pricing_heading_txt;
                    $membership_benefits = (array)$product->pricing_benefits;
                    $membership_button_text = $product->pricing_button_txt;
                    
                    if (empty($membership_button_text)) {
                        $membership_button_text = 'Sign Up';
                    }
                    ?>
                    
                    <div id="<?php echo $product_identifier; ?>" class="memberpress-product pricing-card <?php echo $product->is_highlighted ? 'pricing-card--light' : 'pricing-card--dark'; ?>" <?php // echo ($hide_box) ? 'style="display:none;"' : ''; ?> >
                       
                        <?php $card_price = get_memberpress_price_fields(get_the_ID()); ?>

                        <div class="plan-name">Scout</div>

                        <div class="price-section">
                            <div class="price-section">
                                <h2 class="price"><?php echo formatPrice($card_price['card_price']); ?></h2>
                            </div>

                            <div class="billing-info">
                                <?php echo $card_price['price_description']; ?>
                            </div>
                        </div>

                        <a href="<?php echo esc_url(get_permalink()); ?>" class="btn-select premium-plan"><?php echo esc_html($membership_button_text); ?></a>
                        
                        <?php if (!empty($membership_heading_text)) : ?>
                            <div class="description">
                                <?php echo wp_kses_post($membership_heading_text); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-price">
                            <?php 
                            if(isset($product->pricing)) {
                                echo esc_html(sprintf(
                                    '%s%s',
                                    $product->pricing->amount,
                                    $product->pricing->period_type ? '/' . $product->pricing->period_type : ''
                                ));
                            }
                            ?>
                        </div>

                        <?php echo "<ul class='product-benefits features-list'>"; 
                        foreach ($all_benefits as $benefit) {

                            $is_available = in_array($benefit, $membership_benefits, true);
                            
                            echo '<li' . ($is_available ? ' class="available"' : '') . '>';
                            echo htmlspecialchars($benefit);
                            echo '</li>';
                        }
                        echo "</ul>";
                        ?>

                    </div>

                    <?php
                endwhile;
                echo '</div>';
                
                wp_reset_postdata();
                
            else : ?>
                <p><?php _e('No membership products found.', 'your-theme-text-domain'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
