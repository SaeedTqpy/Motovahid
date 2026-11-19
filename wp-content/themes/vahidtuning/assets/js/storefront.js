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
