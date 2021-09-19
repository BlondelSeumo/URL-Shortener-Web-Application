'use strict';

// Pricing plans
document.querySelector('#plan-month') && document.querySelector('#plan-month').addEventListener("click", function() {
    document.querySelectorAll('.plan-month').forEach(element => element.classList.add('d-block'));
    document.querySelectorAll('.plan-year').forEach(element => element.classList.remove('d-block'));
});

document.querySelector('#plan-year') && document.querySelector('#plan-year').addEventListener("click", function() {
    document.querySelectorAll('.plan-year').forEach(element => element.classList.add('d-block'));
    document.querySelectorAll('.plan-month').forEach(element => element.classList.remove('d-block', 'plan-preload'));
});

let updateSummary = (type) => {
    if (type == 'month') {
        document.querySelectorAll('.checkout-month').forEach(function (element) {
            element.classList.add('d-inline-block');
        });

        document.querySelectorAll('.checkout-year').forEach(function (element) {
            element.classList.remove('d-inline-block');
        });
    } else {
        document.querySelectorAll('.checkout-month').forEach(function (element) {
            element.classList.remove('d-inline-block');
        });

        document.querySelectorAll('.checkout-year').forEach(function (element) {
            element.classList.add('d-inline-block');
        });
    }
};

let updateBillingType = (value) => {
    // Show the offline instructions
    if (value == 'bank') {
        document.querySelector('#bank-instructions').classList.remove('d-none');
        document.querySelector('#bank-instructions').classList.add('d-block');
    }
    // Hide the offline instructions
    else {
        if (document.querySelector('#bank-instructions')) {
            document.querySelector('#bank-instructions').classList.add('d-none');
            document.querySelector('#bank-instructions').classList.remove('d-block');
        }
    }

    if (value == 'coinbase' || value == 'bank') {
        document.querySelectorAll('.checkout-subscription').forEach(function (element) {
            element.classList.remove('d-block');
        });

        document.querySelectorAll('.checkout-subscription').forEach(function (element) {
            element.classList.add('d-none');
        });

        document.querySelectorAll('.checkout-one-time').forEach(function (element) {
            element.classList.add('d-block');
        });

        document.querySelectorAll('.checkout-one-time').forEach(function (element) {
            element.classList.remove('d-none');
        });
    } else {
        document.querySelectorAll('.checkout-subscription').forEach(function (element) {
            element.classList.remove('d-none');
        });

        document.querySelectorAll('.checkout-subscription').forEach(function (element) {
            element.classList.add('d-block');
        });

        document.querySelectorAll('.checkout-one-time').forEach(function (element) {
            element.classList.add('d-none');
        });

        document.querySelectorAll('.checkout-one-time').forEach(function (element) {
            element.classList.remove('d-block');
        });
    }
}

// Payment form
if (document.querySelector('#form-payment')) {
    let url = new URL(window.location.href);

    document.querySelectorAll('[name="interval"]').forEach(function (element) {
        if (element.checked) {
            updateSummary(element.value);
        }

        // Listen to interval changes
        element.addEventListener('change', function () {
            // Update the URL address
            url.searchParams.set('interval', element.value);

            history.pushState(null, null, url.href);

            updateSummary(element.value);
        });
    });

    document.querySelectorAll('[name="payment_processor"]').forEach(function (element) {
        if (element.checked) {
            updateBillingType(element.value);
        }

        // Listen to payment processor changes
        element.addEventListener('change', function () {
            // Update the URL address
            url.searchParams.set('payment', element.value);

            history.pushState(null, null, url.href);

            updateBillingType(element.value);
        });
    });

    // If the Add a coupon button is clicked
    document.querySelector('#coupon') && document.querySelector('#coupon').addEventListener('click', function (e) {
        e.preventDefault();

        // Hide the link
        this.classList.add('d-none');

        // Show the coupon input
        document.querySelector('#coupon-input').classList.remove('d-none');

        // Enable the coupon input
        document.querySelector('input[name="coupon"]').removeAttribute('disabled');
    });

    // If the Cancel coupon button is clicked
    document.querySelector('#coupon-cancel') && document.querySelector('#coupon-cancel').addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector('#coupon').classList.remove('d-none');

        // Hide the coupon input
        document.querySelector('#coupon-input').classList.add('d-none');

        // Disable the coupon input
        document.querySelector('input[name="coupon"]').setAttribute('disabled', 'disabled');
    });

    // If the country value changes
    document.querySelector('#i-country').addEventListener('change', function () {
        // Remove the submit button
        document.querySelector('#form-payment').submit.remove();

        // Submit the form
        document.querySelector('#form-payment').submit();
    });
}

// Coupon form
if (document.querySelector('#form-coupon')) {
    document.querySelector('#i-type').addEventListener('change', function () {
        if (document.querySelector('#i-type').value == 1) {
            document.querySelector('#form-group-redeemable').classList.remove('d-none');
            document.querySelector('#form-group-discount').classList.add('d-none');
            document.querySelector('#i-percentage').setAttribute('disabled', 'disabled');
        } else {
            document.querySelector('#form-group-redeemable').classList.add('d-none');
            document.querySelector('#form-group-discount').classList.remove('d-none');
            document.querySelector('#i-percentage').removeAttribute('disabled');
        }
    });
}

// Table filters
document.querySelector('#search-filters') && document.querySelector('#search-filters').addEventListener('click', function(e) {
    e.stopPropagation();
});

/**
 * Get the value of a given cookie.
 *
 * @param   name
 * @returns {*}
 */
let getCookie = (name) => {
    var name = name + '=';
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');

    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while(c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if(c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
};

/**
 * Set a cookie.
 *
 * @param   name
 * @param   value
 * @param   expire
 * @param   path
 */
let setCookie = (name, value, expire, path) => {
    document.cookie = name + "=" + value + ";expires=" + (new Date(expire).toUTCString()) + ";path=" + path;
};

// Tooltip
jQuery('[data-enable="tooltip"]').tooltip({animation: true, trigger: 'hover', boundary: 'window'});

// Copy tooltip
jQuery('[data-enable="tooltip-copy"]').tooltip({animation: true});

document.querySelectorAll('[data-enable="tooltip-copy"]').forEach(function (element) {
    element.addEventListener('click', function (e) {
        // Update the tooltip
        jQuery(this).tooltip('hide').attr('data-original-title', this.dataset.copied).tooltip('show');
    });

    element.addEventListener('mouseleave', function () {
        this.setAttribute('data-original-title', this.dataset.copy);
    });
});

// Slide menu
document.querySelectorAll('.slide-menu-toggle').forEach(function(element) {
    element.addEventListener('click', function() {
        document.querySelector('#slide-menu').classList.toggle('active');
    });
});

// Toggle password visibility
window.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-password]').forEach(function (element) {
        element.addEventListener('click', function (e) {
            let passwordInput = document.querySelector('#' + this.dataset.password);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                jQuery(this).tooltip('hide').attr('data-original-title', this.dataset.passwordHide).tooltip('show');
            } else {
                passwordInput.type = 'password';
                jQuery(this).tooltip('hide').attr('data-original-title', this.dataset.passwordShow).tooltip('show');
            }
        });
    });
});

// Handle the Single URL form
document.querySelector('#single-link') && document.querySelector('#single-link').addEventListener("click", function() {
    document.querySelectorAll('.single-link').forEach(element => element.classList.add('d-flex'));
    document.querySelectorAll('.multi-link').forEach(element => element.classList.remove('d-flex'));
    document.querySelector('#i-alias').removeAttribute('disabled');
    window.setTimeout(function () {
        document.querySelector('#i-url').focus();
    }, 0);
});

// Handle the Multiple URL form
document.querySelector('#multi-link') && document.querySelector('#multi-link').addEventListener("click", function() {
    document.querySelectorAll('.multi-link').forEach(element => element.classList.add('d-flex'));
    document.querySelectorAll('.single-link').forEach(element => element.classList.remove('d-flex'));
    document.querySelector('#i-alias').setAttribute('disabled', 'disabled');
    window.setTimeout(function () {
        document.querySelector('#i-urls').focus();
    }, 0);
});

// Home copy button
document.querySelector('.home-copy') && document.querySelector('.home-copy').addEventListener('click', function () {
    this.querySelectorAll('span').forEach(function (element) {
        element.classList.toggle('d-none');
    });
    this.classList.add('btn-success');
    this.classList.remove('btn-primary');

    document.querySelector('#copy-form-container input').removeAttribute('style');

    setTimeout(function() {
        jQuery('#copy-form-container').fadeOut('done', function () {
            jQuery('#short-form-container').fadeIn();

            // Focus the shorten input
            document.querySelector('input[name="url"]').focus();
        });
    }, 500);

});

// Set dynamic height to the URLs text area
document.querySelector('#i-urls') && document.querySelector('#i-urls').addEventListener("input", (function () {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
    this.style.overflowY = 'hidden';
}), false);

// Info tooltip
jQuery('[data-toggle="tooltip-url"]').tooltip({animation: true, delay: {"show": 500, "hide": 100}});

document.querySelectorAll('.link-copy').forEach(function (element) {
    element.addEventListener('click', function (e) {
        e.preventDefault();

        try {
            let url = this.dataset.url;
            let tempInput = document.createElement('input');

            document.body.append(tempInput);

            // Set the input's value to the url to be copied
            tempInput.value = url;

            // Select the input's value to be copied
            tempInput.select();

            // Copy the url
            document.execCommand("copy");

            // Remove the temporary input
            tempInput.remove();
        } catch (e) {}
    });
});

// Initialize toasts
jQuery('.toast').toast();

// Share modal
document.querySelectorAll('.link-share').forEach(function (element) {
    element.addEventListener('click', function () {
        let url = this.dataset.url;
        let title = this.dataset.title;
        let qr = this.dataset.qr;

        document.querySelectorAll('#share-twitter, #share-facebook, #share-reddit, #share-pinterest, #share-linkedin, #share-tumblr, #share-email, #share-qr').forEach(function(element) {
            element.setAttribute('data-url', url);
            element.setAttribute('data-title', title);
            element.setAttribute('data-qr', qr);
        });
    });
});

document.querySelector('#share-twitter') && document.querySelector('#share-twitter').addEventListener('click', function (e) {
    e.preventDefault();

    popupCenter("https://twitter.com/intent/tweet?text="+encodeURIComponent(this.dataset.title)+"&url="+encodeURIComponent(this.dataset.url), encodeURIComponent(this.dataset.title), 550, 250);
});

document.querySelector('#share-facebook') && document.querySelector('#share-facebook').addEventListener('click', function (e) {
    e.preventDefault();

    popupCenter("https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(this.dataset.url), encodeURIComponent(this.dataset.title), 550, 300);
});

document.querySelector('#share-reddit') && document.querySelector('#share-reddit').addEventListener('click', function (e) {
    e.preventDefault();

    popupCenter("https://www.reddit.com/submit?url="+encodeURIComponent(this.dataset.url), encodeURIComponent(this.dataset.title), 550, 530);
});

document.querySelector('#share-pinterest') && document.querySelector('#share-pinterest').addEventListener('click', function (e) {
    e.preventDefault();

    popupCenter("https://pinterest.com/pin/create/button/?url="+encodeURIComponent(this.dataset.url)+"&description="+encodeURIComponent(this.dataset.title), encodeURIComponent(this.dataset.title), 550, 300);
});

document.querySelector('#share-linkedin') && document.querySelector('#share-linkedin').addEventListener('click', function (e) {
    e.preventDefault();

    popupCenter("https://www.linkedin.com/sharing/share-offsite/?url="+encodeURIComponent(this.dataset.url), encodeURIComponent(this.dataset.title), 550, 300);
});

document.querySelector('#share-tumblr') && document.querySelector('#share-tumblr').addEventListener('click', function (e) {
    e.preventDefault();

    popupCenter("https://www.tumblr.com/widgets/share/tool/preview?posttype=link&canonicalUrl="+encodeURIComponent(this.dataset.url)+"&title="+encodeURIComponent(this.dataset.title), encodeURIComponent(this.dataset.title), 550, 300);
});

document.querySelector('#share-email') && document.querySelector('#share-email').addEventListener('click', function (e) {
    e.preventDefault();

    window.open("mailto:?Subject="+encodeURIComponent(this.dataset.title)+"&body="+encodeURIComponent(this.dataset.title)+" - "+encodeURIComponent(this.dataset.url), "_self");
});

document.querySelector('#share-qr') && document.querySelector('#share-qr').addEventListener('click', function (e) {
    e.preventDefault();

    popupCenter(this.dataset.qr, encodeURIComponent(this.dataset.title), 300, 300);
});

// Links
document.querySelector('[name="stats-menu"]') && document.querySelector('[name="stats-menu"]').addEventListener('change', function () {
    window.location.href = document.querySelector('[name="stats-menu"]').value;
});

document.querySelectorAll('[data-target="#delete-link-modal"]').forEach(function (element) {
    element.addEventListener('click', function () {
        document.querySelector('#deleteLinkMessage').textContent = this.dataset.text;
        document.querySelector('#delete-link-modal form').setAttribute('action', this.dataset.action);
    });
});

// Add new target inputs
if (document.querySelectorAll('input[name="target_type"]')) {
    let radios = document.querySelectorAll('input[name="target_type"]');

    for(var i = 0, max = radios.length; i < max; i++) {
        // Automatically add a new input to the DOM after an empty target type was submitted
        if (radios[i].checked) {
            if (document.querySelector(radios[i].dataset.target).querySelectorAll('input[data-input="value"]').length == 1) {
                if (document.querySelector(radios[i].dataset.target + ' .input-add')) {
                    document.querySelector(radios[i].dataset.target + ' .input-add').click();
                }
            }
        }

        // Automatically add a new input to the DOM after once a button was clicked
        radios[i].onchange = function(e) {
            if (document.querySelector(this.dataset.target).querySelectorAll('input[data-input="value"]').length == 1) {
                if (document.querySelector(this.dataset.target + ' .input-add')) {
                    document.querySelector(this.dataset.target + ' .input-add').click();
                }
            }

            document.querySelectorAll('input[name="target_type"]').forEach(element => element.classList.remove('active'));
            jQuery(this).tab('show');
        }
    }
}

// Handle dynamic field additions and deletions
document.querySelectorAll('#country-container, #platform-container, #language-container, #rotation-container').forEach(element => {
    element.addEventListener('click', function (e) {
        let parentId = this.getAttribute('id');

        let valueName;
        if (element.getAttribute('id') == 'country-container') {
            valueName = 'country';
        } else if (element.getAttribute('id') == 'platform-container') {
            valueName = 'platform';
        } else if (element.getAttribute('id') == 'language-container') {
            valueName = 'language';
        } else {
            valueName = 'rotation';
        }

        if (e.target.closest('.input-delete')) {
            // Delete the inputs parent container
            e.target.closest('.input-delete').parentNode.parentNode.parentNode.parentNode.remove();

            // If there are no inputs left, enable the dummy inputs
            if (element.querySelectorAll('input[data-input="value"]').length == 1) {
                if (element.querySelector('input[name="' + valueName + '[empty][key]"]')) {
                    element.querySelector('input[name="' + valueName + '[empty][key]"]').removeAttribute('disabled');
                }
                element.querySelector('input[name="' + valueName + '[empty][value]"]').removeAttribute('disabled');
            }

        }

        if (e.target.closest('.input-add')) {
            // Clone the input template
            let input = document.querySelector('#' + parentId + ' .input-template').cloneNode(true);

            // Clean up class names
            input.classList.remove('d-none', 'input-template');

            // Enable the inputs
            if (input.querySelector('select')) {
                input.querySelector('select').removeAttribute('disabled');
            }
            input.querySelector('input').removeAttribute('disabled');

            let inputId = new Date().getTime();

            if (input.querySelector('select')) {
                input.querySelector('select').setAttribute('name', valueName + '['+ inputId +'][key]');
            }
            input.querySelector('input').setAttribute('name', valueName + '['+ inputId +'][value]');
            input.querySelector('input').setAttribute('dir', 'ltr');

            element.querySelector('input[name="' + valueName + '[empty][key]"]') && element.querySelector('input[name="' + valueName + '[empty][key]"]').setAttribute('disabled', 'disabled');
            element.querySelector('input[name="' + valueName + '[empty][value]"]') && element.querySelector('input[name="' + valueName + '[empty][value]"]').setAttribute('disabled', 'disabled');

            // Append the inputs to the DOM
            document.querySelector('#' + parentId + ' .input-content').append(input);
        }
    });
});

// UTM Builder
document.querySelector('#utm-builder') && document.querySelector('#utm-builder').addEventListener('click', function () {
    let urlInput = document.querySelector('#i-url');

    let sources = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];

    try {
        let url = new URL(urlInput.value);

        sources.forEach(function(source) {
            // If the URL already has a source set
            if (url.searchParams.has(source)) {
                // Update the input with the current source value
                document.querySelector('input[name="' + source + '"]').value = url.searchParams.get(source);
            }
        });
    } catch(e) {
        sources.forEach(function(source) {
            // Update the input with the current source value
            document.querySelector('input[name="' + source + '"]').value = '';
        });
    }
});

document.querySelectorAll('#i-utm-source, #i-utm-medium, #i-utm-campaign, #i-utm-term, #i-utm-content').forEach(element => {
    element.addEventListener('input', function () {
        let urlInput = document.querySelector('#i-url');

        try {
            let url = new URL(urlInput.value);

            let targetName = element.getAttribute('name');

            let inputValue = document.querySelector('input[name="' + targetName + '"]').value;

            if (inputValue === "") {
                url.searchParams.delete(targetName);
            } else {
                url.searchParams.set(targetName, inputValue);
            }

            urlInput.value = url.href;
        } catch (e) {

        }
    });
});

/**
 * Smooth scrolling to an element
 *
 * @param element
 * @param duration
 * @param offset
 */
let doScrolling = (element, duration, offset) => {
    let startingY = window.pageYOffset;
    let elementY = getElementY(element);
    let targetY = document.body.scrollHeight - elementY < window.innerHeight ? document.body.scrollHeight - window.innerHeight : elementY;
    let diff = targetY - offset - startingY;
    let easing = function (t) { return t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1 };
    let start;

    if (!diff) return;

    // Bootstrap our animation - it will get called right before next frame shall be rendered.
    window.requestAnimationFrame(function step(timestamp) {
        if (!start) start = timestamp;
        // Elapsed milliseconds since start of scrolling.
        let time = timestamp - start;
        // Get percent of completion in range [0, 1].
        let percent = Math.min(time / duration, 1);
        // Apply the easing.
        // It can cause bad-looking slow frames in browser performance tool, so be careful.
        percent = easing(percent);

        window.scrollTo(0, startingY + diff * percent);

        // Proceed with animation as long as we wanted it to.
        if (time < duration) {
            window.requestAnimationFrame(step);
        }
    });
};

/**
 * Center the pop-up window
 *
 * @param url
 * @param title
 * @param w
 * @param h
 */
let popupCenter = (url, title, w, h) => {
    // Fixes dual-screen position                         Most browsers      Firefox
    let dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
    let dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

    let width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    let height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    let systemZoom = width / window.screen.availWidth;
    let left = (width - w) / 2 / systemZoom + dualScreenLeft;
    let top = (height - h) / 2 / systemZoom + dualScreenTop;
    let newWindow = window.open(url, title, 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) newWindow.focus();
};

/**
 * Chart
 *
 * @param n
 * @param x
 * @param s
 * @param c
 * @returns {string}
 */
Number.prototype.format = function(n, x, s, c) {
    let re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

/**
 * Commarize large numbers
 *
 * @param number
 * @param min
 * @returns {string}
 */
let commarize = (number, min) => {
    min = min || 1e3;
    // Alter numbers larger than 1k
    if (number >= min) {
        let units = ["K", "M", "B", "T"];
        let order = Math.floor(Math.log(number) / Math.log(1000));
        let unitname = units[order - 1];
        let num = Number((number / 1000 ** order).toFixed(2));
        // output number remainder + unitname
        return num + unitname;
    }
    // return formatted original number
    return number.toLocaleString();
}