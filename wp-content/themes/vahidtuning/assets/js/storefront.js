/* Accessible, dependency-free storefront interactions. */
(function () {
  'use strict';
  var menuButton = document.querySelector('[data-vt-menu-toggle]');
  var mobileMenu = document.getElementById('vt-mobile-navigation');
  var searchButton = document.querySelector('[data-vt-search-toggle]');
  var searchPanel = document.getElementById('vt-search-panel');
  var filterButton = document.querySelector('[data-vt-filter-toggle]');
  var filterPanel = document.getElementById('vt-filter-panel');

  function setExpanded(button, panel, isOpen) {
    if (!button || !panel) return;
    panel.hidden = !isOpen;
    button.setAttribute('aria-expanded', String(isOpen));
  }
  if (mobileMenu) mobileMenu.hidden = true;
  if (searchPanel) searchPanel.hidden = true;
  if (menuButton && mobileMenu) {
    menuButton.addEventListener('click', function () {
      var next = menuButton.getAttribute('aria-expanded') !== 'true';
      setExpanded(menuButton, mobileMenu, next);
      if (next) setExpanded(searchButton, searchPanel, false);
    });
  }
  if (searchButton && searchPanel) {
    searchButton.addEventListener('click', function () {
      var next = searchButton.getAttribute('aria-expanded') !== 'true';
      setExpanded(searchButton, searchPanel, next);
      if (next) {
        setExpanded(menuButton, mobileMenu, false);
        var input = searchPanel.querySelector('input[type="search"]');
        if (input) input.focus();
      }
    });
  }
  if (filterButton && filterPanel) {
    filterButton.addEventListener('click', function () {
      var next = filterButton.getAttribute('aria-expanded') !== 'true';
      filterPanel.classList.toggle('is-open', next);
      filterPanel.hidden = !next && window.innerWidth <= 820;
      filterButton.setAttribute('aria-expanded', String(next));
    });
  }
  document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;
    setExpanded(menuButton, mobileMenu, false);
    setExpanded(searchButton, searchPanel, false);
    if (filterButton && filterPanel) {
      filterPanel.classList.remove('is-open');
      filterButton.setAttribute('aria-expanded', 'false');
      if (window.innerWidth <= 820) filterPanel.hidden = true;
    }
  });
  window.addEventListener('resize', function () {
    if (window.innerWidth > 820) {
      setExpanded(menuButton, mobileMenu, false);
      if (filterPanel) filterPanel.hidden = false;
    } else if (filterPanel && !filterPanel.classList.contains('is-open')) {
      filterPanel.hidden = true;
    }
  });
  if (filterPanel && window.innerWidth <= 820) filterPanel.hidden = true;
}());
