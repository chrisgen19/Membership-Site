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
const pricingToggle = document.getElementById('pricingToggle');
const premiumMonthly = document.getElementById('premium-monthly');
const premiumYearly = document.getElementById('premium-yearly');
const monthlyText = document.querySelector('span.me-3'); 
const yearlyText = document.querySelector('label.form-check-label'); 

function toggleTextColors(isYearly) {
    if (isYearly) {
        monthlyText.classList.remove('text-white');
        monthlyText.classList.add('text-muted');
        yearlyText.classList.remove('text-muted');
        yearlyText.classList.add('text-white');
    } else {
        monthlyText.classList.remove('text-muted');
        monthlyText.classList.add('text-white');
        yearlyText.classList.remove('text-white');
        yearlyText.classList.add('text-muted');
    }
}

pricingToggle.addEventListener('change', function() {
    if (this.checked) {
        premiumYearly.style.display = 'block';
        premiumMonthly.style.display = 'none';
        toggleTextColors(true);
    } else {
        premiumYearly.style.display = 'none';
        premiumMonthly.style.display = 'block';
        toggleTextColors(false);
    }
});

window.addEventListener('DOMContentLoaded', function() {
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
</script>

</body>
</html>
