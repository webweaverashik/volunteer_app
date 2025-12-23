/**
 * Volunteer Form Validation
 * Mirrors Laravel VolunteerRequest validation rules
 */

(function() {
    'use strict';

    // Validation rules matching Laravel backend
    const validationRules = {
        full_name: {
            required: true,
            maxLength: 255,
            messages: {
                required: 'পূর্ণ নাম প্রয়োজন।',
                maxLength: 'পূর্ণ নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।'
            }
        },
        mobile: {
            required: true,
            pattern: /^01[3-9]\d{8}$/,
            messages: {
                required: 'মোবাইল নম্বর প্রয়োজন।',
                pattern: 'সঠিক বাংলাদেশি মোবাইল নম্বর দিন (০১XXXXXXXXX)।'
            }
        },
        nid: {
            required: false,
            pattern: /^(?:\d{10}|\d{13}|\d{17})$/,
            messages: {
                pattern: '১০ বা ১৩ বা ১৭ ডিজিটের এনআইডি নং দিন।'
            }
        },
        sylhet3_resident: {
            required: true,
            type: 'radio',
            validValues: ['yes', 'no'],
            messages: {
                required: 'আপনি সিলেট-৩ এর অধিবাসী কিনা তা নির্বাচন করুন।'
            }
        },
        upazila_id: {
            required: true,
            type: 'select',
            messages: {
                required: 'উপজেলা নির্বাচন করুন।'
            }
        },
        union_name: {
            required: true,
            maxLength: 255,
            messages: {
                required: 'ইউনিয়নের নাম প্রয়োজন।',
                maxLength: 'ইউনিয়নের নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।'
            }
        },
        current_address: {
            required: true,
            maxLength: 1000,
            messages: {
                required: 'বর্তমান ঠিকানা প্রয়োজন।',
                maxLength: 'ঠিকানা সর্বোচ্চ ১০০০ অক্ষর হতে পারে।'
            }
        },
        voting_center: {
            required: false,
            maxLength: 255,
            messages: {
                maxLength: 'ভোট কেন্দ্রের নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।'
            }
        },
        age: {
            required: true,
            type: 'number',
            min: 18,
            max: 80,
            messages: {
                required: 'বয়স প্রয়োজন।',
                min: 'বয়স কমপক্ষে ১৮ বছর হতে হবে।',
                max: 'বয়স সর্বোচ্চ ৮০ বছর হতে পারে।',
                number: 'বয়স একটি সংখ্যা হতে হবে।'
            }
        },
        teams: {
            required: true,
            type: 'checkbox',
            minCount: 1,
            messages: {
                required: 'অন্তত একটি টিম নির্বাচন করুন।'
            }
        },
        other_team_description: {
            required: false,
            maxLength: 500,
            messages: {
                maxLength: 'বিবরণ সর্বোচ্চ ৫০০ অক্ষর হতে পারে।'
            }
        },
        reference: {
            required: false,
            maxLength: 255,
            messages: {
                maxLength: 'রেফারেন্স সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।'
            }
        },
        weekly_hours: {
            required: true,
            type: 'radio',
            validValues: ['1-4', '5-8', '9-12', '12+'],
            messages: {
                required: 'সপ্তাহে কত ঘন্টা সময় দিতে পারবেন তা নির্বাচন করুন।'
            }
        },
        preferred_time: {
            required: true,
            type: 'radio',
            validValues: ['morning', 'noon', 'afternoon', 'evening', 'anytime'],
            messages: {
                required: 'পছন্দের সময় নির্বাচন করুন।'
            }
        },
        comments: {
            required: false,
            maxLength: 2000,
            messages: {
                maxLength: 'মন্তব্য সর্বোচ্চ ২০০০ অক্ষর হতে পারে।'
            }
        },
        terms: {
            required: true,
            type: 'checkbox-single',
            messages: {
                required: 'শর্তাবলী মেনে নিতে হবে।'
            }
        }
    };

    // Store for tracking validation state
    const validationState = {};

    /**
     * Initialize validation on DOM ready
     */
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('volunteerForm');
        if (!form) return;

        initializeValidation(form);
    });

    /**
     * Initialize form validation
     */
    function initializeValidation(form) {
        // Get all form fields
        const fields = form.querySelectorAll('input, select, textarea');

        // Attach blur event for real-time validation
        fields.forEach(field => {
            const fieldName = getFieldName(field);
            if (!fieldName || !validationRules[fieldName]) return;

            // For text inputs, validate on blur and input
            if (field.type === 'text' || field.type === 'number' || field.tagName === 'TEXTAREA') {
                field.addEventListener('blur', () => validateField(fieldName, form));
                field.addEventListener('input', () => {
                    // Clear error on typing (debounced validation)
                    clearFieldError(fieldName, form);
                    debounce(() => validateField(fieldName, form), 500)();
                });
            }

            // For select, validate on change
            if (field.tagName === 'SELECT') {
                field.addEventListener('change', () => validateField(fieldName, form));
            }

            // For radio buttons
            if (field.type === 'radio') {
                field.addEventListener('change', () => validateField(fieldName, form));
            }

            // For checkboxes
            if (field.type === 'checkbox') {
                field.addEventListener('change', () => {
                    validateField(fieldName, form);
                    // Handle "other" team checkbox
                    if (field.id === 'otherTeamCheckbox') {
                        toggleOtherTeamInput(field.checked);
                    }
                });
            }
        });

        // Form submit handler
        form.addEventListener('submit', function(e) {
            const isValid = validateAllFields(form);

            if (!isValid) {
                e.preventDefault();
                scrollToFirstError(form);
                showFormErrorSummary(form);
            } else {
                // Show loading state
                showSubmitLoading(form);
            }
        });
    }

    /**
     * Get field name from input element
     */
    function getFieldName(field) {
        let name = field.name;
        // Handle array fields like teams[]
        if (name.endsWith('[]')) {
            name = name.slice(0, -2);
        }
        return name;
    }

    /**
     * Validate a single field
     */
    function validateField(fieldName, form) {
        const rule = validationRules[fieldName];
        if (!rule) return true;

        let value = getFieldValue(fieldName, form, rule);
        let error = null;

        // Required check
        if (rule.required) {
            if (rule.type === 'checkbox') {
                const checkboxes = form.querySelectorAll(`input[name="${fieldName}[]"]:checked`);
                if (checkboxes.length < (rule.minCount || 1)) {
                    error = rule.messages.required;
                }
            } else if (rule.type === 'checkbox-single') {
                const checkbox = form.querySelector(`input[name="${fieldName}"]`);
                if (!checkbox || !checkbox.checked) {
                    error = rule.messages.required;
                }
            } else if (rule.type === 'radio') {
                const selected = form.querySelector(`input[name="${fieldName}"]:checked`);
                if (!selected) {
                    error = rule.messages.required;
                }
            } else if (rule.type === 'select') {
                if (!value || value === '') {
                    error = rule.messages.required;
                }
            } else {
                if (!value || value.trim() === '') {
                    error = rule.messages.required;
                }
            }
        }

        // Skip further validation if empty and not required
        if (!error && (!value || (typeof value === 'string' && value.trim() === ''))) {
            clearFieldError(fieldName, form);
            validationState[fieldName] = true;
            return true;
        }

        // Pattern validation
        if (!error && rule.pattern && value) {
            if (!rule.pattern.test(value)) {
                error = rule.messages.pattern;
            }
        }

        // Max length validation
        if (!error && rule.maxLength && value && value.length > rule.maxLength) {
            error = rule.messages.maxLength;
        }

        // Number validations
        if (!error && rule.type === 'number' && value) {
            const numValue = parseInt(value, 10);
            if (isNaN(numValue)) {
                error = rule.messages.number;
            } else {
                if (rule.min !== undefined && numValue < rule.min) {
                    error = rule.messages.min;
                }
                if (rule.max !== undefined && numValue > rule.max) {
                    error = rule.messages.max;
                }
            }
        }

        // Update UI
        if (error) {
            showFieldError(fieldName, error, form);
            validationState[fieldName] = false;
            return false;
        } else {
            clearFieldError(fieldName, form);
            showFieldSuccess(fieldName, form);
            validationState[fieldName] = true;
            return true;
        }
    }

    /**
     * Get field value based on type
     */
    function getFieldValue(fieldName, form, rule) {
        if (rule.type === 'radio') {
            const selected = form.querySelector(`input[name="${fieldName}"]:checked`);
            return selected ? selected.value : null;
        }
        if (rule.type === 'checkbox') {
            const checkboxes = form.querySelectorAll(`input[name="${fieldName}[]"]:checked`);
            return Array.from(checkboxes).map(cb => cb.value);
        }
        if (rule.type === 'checkbox-single') {
            const checkbox = form.querySelector(`input[name="${fieldName}"]`);
            return checkbox ? checkbox.checked : false;
        }

        const field = form.querySelector(`[name="${fieldName}"]`);
        return field ? field.value : null;
    }

    /**
     * Show field error
     */
    function showFieldError(fieldName, message, form) {
        const field = getFieldElement(fieldName, form);
        if (!field) return;

        // Add error class to field
        if (field.classList) {
            field.classList.remove('border-gray-300', 'border-green-500');
            field.classList.add('border-red-500');
        }

        // Find or create error message element
        let errorEl = form.querySelector(`[data-error-for="${fieldName}"]`);
        
        if (!errorEl) {
            errorEl = document.createElement('p');
            errorEl.className = 'text-red-500 text-sm mt-1 flex items-center gap-1 validation-error';
            errorEl.setAttribute('data-error-for', fieldName);
            
            // Insert after the field or field container
            const container = getFieldContainer(fieldName, form);
            if (container) {
                container.appendChild(errorEl);
            }
        }

        errorEl.innerHTML = `<span class="animate-pulse">⚠️</span> ${message}`;
        errorEl.style.display = 'flex';

        // Add shake animation
        if (field.classList) {
            field.classList.add('animate-shake');
            setTimeout(() => field.classList.remove('animate-shake'), 500);
        }
    }

    /**
     * Clear field error
     */
    function clearFieldError(fieldName, form) {
        const field = getFieldElement(fieldName, form);
        if (field && field.classList) {
            field.classList.remove('border-red-500');
            field.classList.add('border-gray-300');
        }

        const errorEl = form.querySelector(`[data-error-for="${fieldName}"]`);
        if (errorEl) {
            errorEl.style.display = 'none';
        }
    }

    /**
     * Show field success state
     */
    function showFieldSuccess(fieldName, form) {
        const field = getFieldElement(fieldName, form);
        if (field && field.classList && field.tagName !== 'INPUT' || 
            (field && field.type !== 'radio' && field.type !== 'checkbox')) {
            field.classList.remove('border-gray-300', 'border-red-500');
            field.classList.add('border-green-500');
        }
    }

    /**
     * Get field element
     */
    function getFieldElement(fieldName, form) {
        const rule = validationRules[fieldName];
        
        if (rule && rule.type === 'radio') {
            return form.querySelector(`input[name="${fieldName}"]`);
        }
        if (rule && rule.type === 'checkbox') {
            return form.querySelector(`input[name="${fieldName}[]"]`);
        }
        
        return form.querySelector(`[name="${fieldName}"]`);
    }

    /**
     * Get field container for error message insertion
     */
    function getFieldContainer(fieldName, form) {
        const rule = validationRules[fieldName];
        
        if (rule && rule.type === 'radio') {
            const radioGroup = form.querySelector(`input[name="${fieldName}"]`);
            if (radioGroup) {
                return radioGroup.closest('.flex, .grid')?.parentElement || radioGroup.parentElement;
            }
        }
        
        if (rule && rule.type === 'checkbox') {
            const checkboxGroup = form.querySelector(`input[name="${fieldName}[]"]`);
            if (checkboxGroup) {
                return checkboxGroup.closest('.grid')?.parentElement || checkboxGroup.parentElement;
            }
        }
        
        if (rule && rule.type === 'checkbox-single') {
            const checkbox = form.querySelector(`input[name="${fieldName}"]`);
            if (checkbox) {
                return checkbox.closest('label')?.parentElement || checkbox.parentElement;
            }
        }
        
        const field = form.querySelector(`[name="${fieldName}"]`);
        return field ? field.parentElement : null;
    }

    /**
     * Validate all fields
     */
    function validateAllFields(form) {
        let allValid = true;

        Object.keys(validationRules).forEach(fieldName => {
            const isValid = validateField(fieldName, form);
            if (!isValid) {
                allValid = false;
            }
        });

        return allValid;
    }

    /**
     * Scroll to first error
     */
    function scrollToFirstError(form) {
        const firstError = form.querySelector('.border-red-500, [data-error-for]');
        if (firstError) {
            const errorField = firstError.hasAttribute('data-error-for') 
                ? getFieldElement(firstError.getAttribute('data-error-for'), form)
                : firstError;
            
            if (errorField) {
                errorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Focus the field after scroll
                setTimeout(() => {
                    if (errorField.focus) {
                        errorField.focus();
                    }
                }, 500);
            }
        }
    }

    /**
     * Show form error summary at top
     */
    function showFormErrorSummary(form) {
        // Remove existing summary
        const existingSummary = form.querySelector('.validation-summary');
        if (existingSummary) {
            existingSummary.remove();
        }

        // Count errors
        const errorCount = Object.values(validationState).filter(v => v === false).length;
        
        if (errorCount === 0) return;

        // Create summary element
        const summary = document.createElement('div');
        summary.className = 'validation-summary mb-6 bg-red-50 border border-red-200 rounded-xl p-4 animate-fadeIn';
        const bengaliErrorCount = toBengaliNumber(errorCount);
        summary.innerHTML = `
            <div class="flex items-center gap-2 text-red-700 font-semibold">
                <span class="text-xl">⚠️</span>
                <span>অনুগ্রহ করে ${bengaliErrorCount}টি ত্রুটি সংশোধন করুন</span>
            </div>
            <p class="text-red-600 text-sm mt-1">নিচে লাল চিহ্নিত ফিল্ডগুলো সঠিকভাবে পূরণ করুন।</p>
        `;

        // Insert at top of form
        form.insertBefore(summary, form.firstChild);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (summary.parentElement) {
                summary.classList.add('animate-fadeOut');
                setTimeout(() => summary.remove(), 300);
            }
        }, 5000);
    }

    /**
     * Show submit loading state
     */
    function showSubmitLoading(form) {
        const submitBtn = form.querySelector('#submitBtn');
        if (submitBtn) {
            submitBtn.innerHTML = `
                <span class="inline-flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    অপেক্ষা করুন...
                </span>
            `;
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        }
    }

    /**
     * Toggle other team input visibility
     */
    function toggleOtherTeamInput(show) {
        const otherTeamInput = document.getElementById('otherTeamInput');
        if (otherTeamInput) {
            if (show) {
                otherTeamInput.classList.remove('hidden');
                otherTeamInput.classList.add('animate-slideDown');
            } else {
                otherTeamInput.classList.add('hidden');
                otherTeamInput.classList.remove('animate-slideDown');
            }
        }
    }

    /**
     * Convert English numbers to Bengali numerals
     */
    function toBengaliNumber(num) {
        const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return num.toString().replace(/[0-9]/g, function(digit) {
            return bengaliDigits[parseInt(digit)];
        });
    }

    /**
     * Debounce utility
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Add CSS animations dynamically
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .animate-fadeOut {
            animation: fadeOut 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; max-height: 0; }
            to { opacity: 1; max-height: 100px; }
        }
        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            ring: 2px;
            ring-color: #22c55e;
            border-color: #22c55e !important;
        }
        .border-green-500 {
            border-color: #22c55e !important;
        }
        .border-red-500 {
            border-color: #ef4444 !important;
        }
    `;
    document.head.appendChild(style);

})();