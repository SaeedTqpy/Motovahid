/* Keep native navigation and filters available when JavaScript is off. */
(function () {
  'use strict';

  var mobileNav = window.matchMedia('(max-width: 760px)');

  function disclosure(selector, panelId, breakpoint) {
    var button = document.querySelector(selector);
    var panel = document.getElementById(panelId);
    if (!button || !panel) return;

    function setOpen(open) {
      panel.hidden = !open;
      button.setAttribute('aria-expanded', String(open));
    }

    function syncLayout() {
      button.hidden = !breakpoint.matches;
      setOpen(!breakpoint.matches);
    }

    button.addEventListener('click', function () {
      setOpen(panel.hidden);
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && breakpoint.matches && !panel.hidden &&
          (panel.contains(document.activeElement) || document.activeElement === button)) {
        setOpen(false);
        button.focus();
      }
    });

    breakpoint.addEventListener('change', syncLayout);
    syncLayout();
  }

  disclosure('[data-vt-menu-toggle]', 'vt-store-nav', mobileNav);

  // The filter sidebar remains visible without JavaScript. Mobile users can collapse it.
  var catalogFilters = document.querySelector('[data-vt-filter-panel]');
  if (catalogFilters) {
    var compactFilters = window.matchMedia('(max-width: 900px)');
    function syncCatalogFilters() {
      catalogFilters.open = !compactFilters.matches;
    }
    compactFilters.addEventListener('change', syncCatalogFilters);
    syncCatalogFilters();
  }

  // Close the category dropdown on outside clicks and Escape.
  var categoryMenu = document.querySelector('.vt-nav-catalog');
  if (categoryMenu) {
    document.addEventListener('click', function (event) {
      if (categoryMenu.open && !categoryMenu.contains(event.target)) categoryMenu.open = false;
    });
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && categoryMenu.open) {
        categoryMenu.open = false;
        categoryMenu.querySelector('summary').focus();
      }
    });
  }

  var purchase = document.getElementById('vt-pdp-purchase');
  if (!purchase) return;

  var sticky = document.querySelector('[data-vt-mobile-buy]');
  var purchaseButton = purchase.querySelector('.single_add_to_cart_button');
  if (sticky && purchaseButton && 'IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      sticky.hidden = entries[0].intersectionRatio >= 0.8;
    }, { threshold: 0.8 });
    observer.observe(purchaseButton);
  }

  var inputs = purchase.querySelectorAll('form.cart:not(.grouped_form) .quantity input.qty[type="number"]');
  inputs.forEach(function (input) {
    if (input.step === 'any' || input.disabled || input.readOnly) return;

    function makeStepButton(label, symbol) {
      var button = document.createElement('button');
      button.type = 'button';
      button.className = 'vt-quantity-step';
      button.setAttribute('aria-label', label);
      button.textContent = symbol;
      return button;
    }

    var minus = makeStepButton('کاهش تعداد', '−');
    var plus = makeStepButton('افزایش تعداد', '+');
    input.before(minus);
    input.after(plus);
    input.parentElement.classList.add('vt-quantity-enhanced');

    function updateSteps() {
      var unavailable = input.disabled || input.readOnly || input.step === 'any';
      minus.disabled = unavailable || (input.min !== '' && input.valueAsNumber <= Number(input.min));
      plus.disabled = unavailable || (input.max !== '' && input.valueAsNumber >= Number(input.max));
    }

    function step(method) {
      input[method]();
      input.dispatchEvent(new Event('input', { bubbles: true }));
      input.dispatchEvent(new Event('change', { bubbles: true }));
    }

    minus.addEventListener('click', function () { step('stepDown'); });
    plus.addEventListener('click', function () { step('stepUp'); });
    input.addEventListener('input', updateSteps);
    input.addEventListener('change', updateSteps);
    new MutationObserver(updateSteps).observe(input, {
      attributes: true,
      attributeFilter: ['min', 'max', 'step', 'disabled', 'readonly', 'value']
    });
    updateSteps();
  });
}());

/* Night Trail: header state on scroll and reveal-on-scroll animations. */
(function () {
  'use strict';
  var header = document.getElementById('vt-header');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  var items = document.querySelectorAll('[data-reveal]');
  if (!items.length) return;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce || !('IntersectionObserver' in window)) {
    items.forEach(function (el) { el.classList.add('is-in'); });
    return;
  }
  // Stagger siblings that share a parent.
  items.forEach(function (el) {
    var siblings = Array.prototype.filter.call(el.parentElement.children, function (c) { return c.hasAttribute('data-reveal'); });
    var index = siblings.indexOf(el);
    if (index > 0) el.style.setProperty('--nt-delay', Math.min(index, 6) * 0.08 + 's');
  });
  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-in');
        observer.unobserve(entry.target);
      }
    });
  }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
  items.forEach(function (el) { observer.observe(el); });
}());

/* Native scroll-snap keeps the sale rail usable by touch and without JavaScript. */
(function () {
  'use strict';
  document.querySelectorAll('[data-sale-carousel]').forEach(function (carousel) {
    var track = carousel.querySelector('.nt-sale-track');
    var controls = carousel.querySelector('.nt-sale-controls');
    if (!track || !controls) return;
    function sync() { controls.hidden = track.scrollWidth <= track.clientWidth + 1; }
    function move(direction) {
      var card = track.querySelector('.nt-sale-card');
      var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      if (card) track.scrollBy({ left: direction * (card.getBoundingClientRect().width + gap), behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
    }
    carousel.querySelector('[data-sale-prev]').addEventListener('click', function () { move(1); });
    carousel.querySelector('[data-sale-next]').addEventListener('click', function () { move(-1); });
    window.addEventListener('resize', sync, { passive: true });
    sync();
  });
}());

/* Show a confirmation only after WooCommerce reports a successful addition. */
(function () {
  'use strict';
  var dialog = document.querySelector('[data-vt-cart-dialog]');
  if (!dialog || typeof dialog.showModal !== 'function') return;
  var description = dialog.querySelector('[data-vt-cart-description]');
  var defaultDescription = description.textContent;
  var returnFocus = null;

  function show(message) {
    description.textContent = message || defaultDescription;
    if (dialog.open) return;
    returnFocus = document.activeElement;
    dialog.showModal();
  }
  dialog.querySelectorAll('[data-vt-cart-close]').forEach(function (button) {
    button.addEventListener('click', function () { dialog.close(); });
  });
  dialog.addEventListener('click', function (event) {
    if (event.target === dialog) dialog.close();
  });
  dialog.addEventListener('close', function () {
    if (returnFocus && typeof returnFocus.focus === 'function') returnFocus.focus();
  });

  var marker = document.querySelector('.vt-cart-added-marker');
  if (marker) {
    var notice = marker.closest('.woocommerce-message, .wc-block-components-notice-banner');
    if (notice) {
      var copy = notice.cloneNode(true);
      copy.querySelectorAll('a, button, .vt-cart-added-marker').forEach(function (node) { node.remove(); });
      var message = copy.textContent.replace(/\s+/g, ' ').trim();
      show(message);
      notice.remove();
    }
  }
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', function (event, fragments, cartHash, button) {
      var card = button && button.length ? button[0].closest('.vt-product-card, .nt-sale-card') : null;
      var name = card && card.querySelector('.vt-product-name, .nt-sale-card-body h3');
      show(name ? '«' + name.textContent.trim() + '» به سبد خرید اضافه شد.' : '');
    });
  }
}());

/* Accessible swatches enhance WooCommerce's variation selects, which remain the source of truth. */
(function () {
  'use strict';
  function init() {
    var $ = window.jQuery;
    if (!$ || !$.fn.wc_variation_form) return;
    var colors = {
      'مشکی': '#202321', 'سیاه': '#202321', 'نارنجی': '#ef6b24',
      'سفید': '#f7f7f4', 'قرمز': '#bf3434', 'آبی': '#356a9a',
      'خاکستری': '#898e8a', 'طوسی': '#898e8a', 'سبز': '#557856',
      'مشکی و نارنجی': 'linear-gradient(135deg, #202321 50%, #ef6b24 50%)',
      'نارنجی و مشکی': 'linear-gradient(135deg, #ef6b24 50%, #202321 50%)'
    };
    document.querySelectorAll('.variations_form').forEach(function (form, formIndex) {
      var groups = [];
      form.querySelectorAll('.variations select').forEach(function (select, groupIndex) {
        var row = select.closest('tr');
        var heading = row && row.querySelector('th label');
        var options = Array.prototype.filter.call(select.options, function (option) { return option.value !== ''; });
        if (!heading || !options.length) return;
        var title = heading.textContent.trim();
        var isColor = /رنگ|color/i.test(title);
        var fieldset = document.createElement('fieldset');
        fieldset.className = 'vt-swatches' + (isColor ? ' vt-swatches-color' : '');
        var legend = document.createElement('legend');
        legend.className = 'screen-reader-text';
        legend.textContent = title;
        fieldset.appendChild(legend);
        var items = [];
        options.forEach(function (option, optionIndex) {
          var label = document.createElement('label');
          label.className = 'vt-swatch';
          var input = document.createElement('input');
          input.type = 'radio';
          input.name = 'vt_choice_' + formIndex + '_' + groupIndex;
          input.value = option.value;
          input.id = 'vt-choice-' + formIndex + '-' + groupIndex + '-' + optionIndex;
          var chip = document.createElement('span');
          chip.className = 'vt-swatch-chip';
          if (isColor && colors[option.textContent.trim()]) {
            var dot = document.createElement('span');
            dot.className = 'vt-swatch-dot';
            dot.setAttribute('aria-hidden', 'true');
            dot.style.background = colors[option.textContent.trim()];
            chip.appendChild(dot);
          }
          var text = document.createElement('span');
          text.textContent = option.textContent.trim();
          chip.appendChild(text);
          label.appendChild(input);
          label.appendChild(chip);
          fieldset.appendChild(label);
          input.addEventListener('change', function () {
            if (!input.checked) return;
            select.value = input.value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
          });
          items.push({ input: input, label: label, value: option.value });
        });
        select.parentNode.insertBefore(fieldset, select.nextSibling);
        select.classList.add('vt-variation-native');
        select.tabIndex = -1;
        select.setAttribute('aria-hidden', 'true');
        heading.removeAttribute('for');
        groups.push({ select: select, items: items });
      });
      function sync() {
        groups.forEach(function (group) {
          group.items.forEach(function (item) {
            var option = Array.prototype.find.call(group.select.options, function (entry) { return entry.value === item.value; });
            item.input.disabled = group.select.disabled || !option || option.disabled;
            item.input.checked = group.select.value === item.value;
            item.label.classList.toggle('is-unavailable', item.input.disabled);
          });
        });
      }
      var queued = false;
      function scheduleSync() {
        if (queued) return;
        queued = true;
        window.setTimeout(function () { queued = false; sync(); }, 0);
      }
      groups.forEach(function (group) {
        group.select.addEventListener('change', scheduleSync);
        new MutationObserver(scheduleSync).observe(group.select, { childList: true, subtree: true, attributes: true, attributeFilter: ['disabled', 'selected'] });
      });
      $(form).on('woocommerce_update_variation_values found_variation reset_data woocommerce_variation_has_changed', scheduleSync);
      sync();
    });
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
}());

/* Product likes stay on this device; product links work even without JavaScript. */
(function () {
  'use strict';
  document.documentElement.classList.add('vt-card-actions-ready');
  var buttons = document.querySelectorAll('[data-vt-like]');
  if (!buttons.length) return;
  var key = 'motovahid-liked-products-v1';
  var likes;
  try {
    likes = JSON.parse(localStorage.getItem(key) || '[]');
    if (!Array.isArray(likes)) likes = [];
    localStorage.setItem(key, JSON.stringify(likes));
  } catch (error) { return; }
  function render() {
    buttons.forEach(function (button) {
      var active = likes.indexOf(button.getAttribute('data-vt-like')) !== -1;
      button.setAttribute('aria-pressed', String(active));
      button.title = active ? 'حذف پسند از این مرورگر' : 'پسندیدن در این مرورگر';
      button.hidden = false;
    });
  }
  buttons.forEach(function (button) {
    button.addEventListener('click', function () {
      var id = button.getAttribute('data-vt-like');
      var index = likes.indexOf(id);
      if (index === -1) likes.push(id); else likes.splice(index, 1);
      try { localStorage.setItem(key, JSON.stringify(likes)); } catch (error) { /* Keep the current page state. */ }
      render();
    });
  });
  render();
}());
