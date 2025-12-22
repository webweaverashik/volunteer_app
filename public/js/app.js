/**
 * Main JavaScript for Nurul Huda Junaid Campaign Website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initScrollToTop();
    initFAQ();
    initManifestoToggle();
    initSmoothScroll();
});

/**
 * Scroll to Top Button
 */
function initScrollToTop() {
    const scrollTopBtn = document.getElementById('scrollTopBtn');

    if (!scrollTopBtn) return;

    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add('visible');
        } else {
            scrollTopBtn.classList.remove('visible');
        }
    });

    // Scroll to top on click
    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * FAQ Accordion
 */
function initFAQ() {
    const faqContainer = document.getElementById('faqContainer');

    if (!faqContainer) return;

    const faqQuestions = faqContainer.querySelectorAll('.faq-question');

    faqQuestions.forEach(function(button) {
        button.addEventListener('click', function() {
            const faqItem = this.closest('.faq-item');
            const answer = faqItem.querySelector('.faq-answer');
            const isOpen = faqItem.classList.contains('open');

            // Close all other FAQs
            faqContainer.querySelectorAll('.faq-item.open').forEach(function(item) {
                if (item !== faqItem) {
                    item.classList.remove('open');
                    item.querySelector('.faq-answer').style.maxHeight = '0';
                }
            });

            // Toggle current FAQ
            if (isOpen) {
                faqItem.classList.remove('open');
                answer.style.maxHeight = '0';
            } else {
                faqItem.classList.add('open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });
}

/**
 * Manifesto Toggle (Show More/Less)
 */
function initManifestoToggle() {
    const toggleBtn = document.getElementById('toggleManifesto');

    if (!toggleBtn) return;

    let isExpanded = false;

    toggleBtn.addEventListener('click', function() {
        const allItems = document.querySelectorAll('.manifesto-item');
        const toggleText = document.getElementById('toggleText');
        const toggleCount = document.getElementById('toggleCount');

        isExpanded = !isExpanded;

        if (isExpanded) {
            allItems.forEach(function(item, index) {
                if (index >= 9) {
                    setTimeout(function() {
                        item.classList.remove('hidden-item');
                        item.classList.add('showing');
                    }, (index - 9) * 50);
                }
            });
            toggleText.textContent = 'সংক্ষিপ্ত করুন';
            toggleCount.textContent = '-১৫';
            toggleBtn.classList.add('expanded');
        } else {
            allItems.forEach(function(item, index) {
                if (index >= 9) {
                    item.classList.add('hidden-item');
                    item.classList.remove('showing');
                }
            });
            toggleText.textContent = 'সবগুলো দেখুন';
            toggleCount.textContent = '+১৫';
            toggleBtn.classList.remove('expanded');
        }
    });
}

/**
 * Smooth Scroll for Anchor Links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Show Toast Notification
 * @param {string} message - The message to display
 * @param {string} type - Type of toast (success, error, info)
 */
function showToast(message, type = 'info') {
    // Remove existing toast
    const existingToast = document.querySelector('.toast');
    if (existingToast) {
        existingToast.remove();
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;

    // Set background color based on type
    switch (type) {
        case 'success':
            toast.style.background = '#22c55e';
            break;
        case 'error':
            toast.style.background = '#ef4444';
            break;
        default:
            toast.style.background = '#1f2937';
    }

    document.body.appendChild(toast);

    // Remove toast after 3 seconds
    setTimeout(function() {
        toast.style.animation = 'slideUp 0.3s ease reverse';
        setTimeout(function() {
            toast.remove();
        }, 300);
    }, 3000);
}

/**
 * Form Validation Helper
 * @param {HTMLFormElement} form - The form element
 * @returns {boolean} - Whether the form is valid
 */
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(function(field) {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        }
    });

    return isValid;
}

/**
 * Mobile Number Validation (Bangladesh)
 * @param {string} number - The mobile number to validate
 * @returns {boolean} - Whether the number is valid
 */
function validateBDMobile(number) {
    const regex = /^01[3-9][0-9]{8}$/;
    return regex.test(number);
}

/**
 * Format number in Bengali
 * @param {number} num - The number to format
 * @returns {string} - Bengali formatted number
 */
function toBengaliNumber(num) {
    const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
    return num.toString().split('').map(d => bengaliDigits[parseInt(d)] || d).join('');
}

// Export functions for external use
window.showToast = showToast;
window.validateForm = validateForm;
window.validateBDMobile = validateBDMobile;
window.toBengaliNumber = toBengaliNumber;
