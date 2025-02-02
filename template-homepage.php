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

<div id="primary" class="content-area">
    <main id="main" class="site-main">

    </main><!-- #main -->
</div><!-- #primary -->

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

                    $all_benefits = [
                        'View Trailers',
                        'Job Board',
                        'Watch Career and Education Trailers',
                        'Unlimited Access to Career boards',
                        'Unlimited Access to Career videos',
                        'Premium Industry Awareness Content'
                    ];
                    
                    // Get custom fields
                    $membership_title = $product->pricing_title;
                    $membership_heading_text = $product->pricing_heading_txt;
                    $membership_benefits = (array)$product->pricing_benefits;
                    $membership_button_text = $product->pricing_button_txt;
                    
                    // If button text is empty, use default
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
                            // Check if current benefit exists in membership benefits
                            $is_available = in_array($benefit, $membership_benefits, true);
                            
                            // Escape output and create list item
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

<style>
    .memberpress-products-wrapper {
        margin: 0 auto;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 columns on desktop */
        gap: 30px;
        margin-top: 30px;
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: 1fr; /* 1 column on mobile */
        }
    }

    
    .memberpress-product {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        background: #fff;
        transition: transform 0.3s ease;
        /* text-align: center; */
    }
    
    .memberpress-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .product-title {
        margin-bottom: 15px;
        font-size: 1.8em;
        color: #333;
    }
    
    .product-heading-text {
        margin-bottom: 20px;
        color: #666;
        font-size: 1.1em;
    }
    
    .product-price {
        font-size: 2em;
        font-weight: bold;
        margin: 25px 0;
        color: #0073aa;
    }
    
    .product-button .button {
        display: inline-block;
        width: 100%;
        padding: 15px 25px;
        background-color: #0073aa;
        color: #fff;
        text-decoration: none;
        border-radius: 3px;
        transition: all 0.3s ease;
        text-align: center;
        box-sizing: border-box;
        font-size: 1.1em;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .product-button .button:hover {
        background-color: #005177;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .product-title {
            font-size: 1.5em;
        }
        
        .product-price {
            font-size: 1.6em;
        }
    }
</style>

<?php
get_footer();
