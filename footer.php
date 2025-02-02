<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Membership
 */

?>

<?php wp_footer(); ?>

<script>
// Get the necessary elements
const pricingToggle = document.getElementById('pricingToggle');
const premiumMonthly = document.getElementById('premium-monthly');
const premiumYearly = document.getElementById('premium-yearly');

// Add event listener to the toggle
pricingToggle.addEventListener('change', function() {
    if (this.checked) {
        // If toggle is checked (yearly)
        premiumYearly.style.display = 'block';
        premiumMonthly.style.display = 'none';
    } else {
        // If toggle is unchecked (monthly)
        premiumYearly.style.display = 'none';
        premiumMonthly.style.display = 'block';
    }
});

// Initialize the display on page load (optional)
window.addEventListener('DOMContentLoaded', function() {
    // Set initial state based on toggle's initial state
    if (pricingToggle.checked) {
        premiumYearly.style.display = 'block';
        premiumMonthly.style.display = 'none';
    } else {
        premiumYearly.style.display = 'none';
        premiumMonthly.style.display = 'block';
    }
});

// 	document.addEventListener('DOMContentLoaded', function() {
//     const pricingToggle = document.getElementById('pricingToggle');
//     const priceElement = document.querySelector('.pricing-card--light .price');
//     const savingsElement = document.querySelector('.pricing-card--light .save');
//     const periodElement = document.querySelector('.pricing-card--light .period');
//     const premiumPlanLink = document.querySelector('.premium-plan'); // Updated selector
    
//     // Monthly and yearly pricing data
//     const pricing = {
//         monthly: {
//             price: '19',
//             period: '/month',
//             savings: 'Save £99',
//             link: 'https://membership.test/register/premium/'
//         },
//         yearly: {
//             price: '129',
//             period: '/year',
//             savings: 'Save £99',
//             link: 'https://membership.test/register/premium-billed-yearly/'
//         }
//     };

//     // Update pricing information and link
//     function updatePricing(isYearly) {
//         const plan = isYearly ? pricing.yearly : pricing.monthly;
        
//         // Update price display
//         priceElement.innerHTML = `£${plan.price} <span class="period">${plan.period}</span>`;
        
//         // Update savings text
//         savingsElement.textContent = plan.savings;
        
//         // Update link href
//         premiumPlanLink.href = plan.link;
//     }

//     // Toggle event listener
//     pricingToggle.addEventListener('change', function(e) {
//         updatePricing(e.target.checked);
//     });
// });
</script>

</body>
</html>
