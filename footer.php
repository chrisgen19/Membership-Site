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
// Get all the necessary elements
const pricingToggle = document.getElementById('pricingToggle');
const premiumMonthly = document.getElementById('premium-monthly');
const premiumYearly = document.getElementById('premium-yearly');
const monthlyText = document.querySelector('span.me-3'); // Get the "Pay Monthly" span
const yearlyText = document.querySelector('label.form-check-label'); // Get the "Save with Yearly" label

// Function to toggle text colors
function toggleTextColors(isYearly) {
    if (isYearly) {
        // If yearly is selected
        monthlyText.classList.remove('text-white');
        monthlyText.classList.add('text-muted');
        yearlyText.classList.remove('text-muted');
        yearlyText.classList.add('text-white');
    } else {
        // If monthly is selected
        monthlyText.classList.remove('text-muted');
        monthlyText.classList.add('text-white');
        yearlyText.classList.remove('text-white');
        yearlyText.classList.add('text-muted');
    }
}

// Add event listener to the toggle
pricingToggle.addEventListener('change', function() {
    if (this.checked) {
        // If toggle is checked (yearly)
        premiumYearly.style.display = 'block';
        premiumMonthly.style.display = 'none';
        toggleTextColors(true);
    } else {
        // If toggle is unchecked (monthly)
        premiumYearly.style.display = 'none';
        premiumMonthly.style.display = 'block';
        toggleTextColors(false);
    }
});

// Initialize the display and text colors on page load
window.addEventListener('DOMContentLoaded', function() {
    // Set initial state based on toggle's initial state
    if (pricingToggle.checked) {
        premiumYearly.style.display = 'block';
        premiumMonthly.style.display = 'none';
        toggleTextColors(true);
    } else {
        premiumYearly.style.display = 'none';
        premiumMonthly.style.display = 'block';
        toggleTextColors(false);
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
