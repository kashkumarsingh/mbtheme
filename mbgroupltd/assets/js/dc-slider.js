/* MeraBoiler promo offers slider (vanilla JS, no dependencies).
   Autoplay + swipe only - no arrows or dots.
   Visible cards: 3 side-by-side on desktop (>820px), 1 on smaller screens
   (must match the .dc-slider__slide flex-basis breakpoints in dc-home.css). */
(function () {
  var REDUCED = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var DESKTOP_Q = '(min-width: 821px)';
  var DESKTOP_PER_VIEW = 3;
  var MOBILE_PER_VIEW = 1;

  function init(slider) {
    var track = slider.querySelector('.dc-slider__track');
    var slides = slider.querySelectorAll('.dc-slider__slide');

    function shown() {
      return Array.prototype.filter.call(slides, function (slide) {
        return window.getComputedStyle(slide).display !== 'none';
      });
    }
    if (!track || slides.length < 2) {
      slider.setAttribute('data-dc-slider', 'ready');
      return;
    }

    var timeout = parseInt(slider.getAttribute('data-autoplay'), 10) || 0;
    var index = 0;
    var timer = null;

    function perView() {
      if (window.matchMedia && window.matchMedia(DESKTOP_Q).matches) return DESKTOP_PER_VIEW;
      return MOBILE_PER_VIEW;
    }

    function maxIndex() {
      return Math.max(0, shown().length - perView());
    }

    // Pixel step (slide width + track gap) so any gap/basis stays exact.
    function step() {
      var visible = shown();
      var w = (visible[0] || slides[0]).getBoundingClientRect().width;
      var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      return w + gap;
    }

    function go(i) {
      var max = maxIndex();
      index = ((i % (max + 1)) + (max + 1)) % (max + 1);
      track.style.transform = 'translateX(-' + index * step() + 'px)';
    }

    function stop() {
      if (timer) { clearInterval(timer); timer = null; }
      slider.removeAttribute('data-dc-autoplay-on');
    }

    function start() {
      if (timeout <= 0 || REDUCED || timer) return;
      if (document.hidden) return;
      timer = setInterval(function () { go(index + 1); }, timeout);
      slider.setAttribute('data-dc-autoplay-on', 'true');
    }

    function restart() { stop(); start(); }

    // Optional prev/next controls - bound only if present in markup.
    var prev = slider.querySelector('[data-dc-prev]');
    var next = slider.querySelector('[data-dc-next]');
    if (prev) prev.addEventListener('click', function () { go(index - 1); restart(); });
    if (next) next.addEventListener('click', function () { go(index + 1); restart(); });

    // Pause while the visitor interacts; resume afterwards.
    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);
    slider.addEventListener('focusin', stop);
    slider.addEventListener('focusout', start);
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) stop();
      else start();
    });

    // Re-clamp when crossing the desktop/mobile breakpoint.
    if (window.matchMedia) {
      window.matchMedia(DESKTOP_Q).addEventListener('change', function () { go(index); });
    }
    // Re-snap after resize (slide pixel widths change).
    var rsTimer = null;
    window.addEventListener('resize', function () {
      clearTimeout(rsTimer);
      rsTimer = setTimeout(function () { go(index); }, 150);
    });

    // Basic touch swipe.
    var startX = null;
    track.addEventListener('touchstart', function (e) {
      startX = e.touches[0].clientX;
      stop();
    }, { passive: true });
    track.addEventListener('touchend', function (e) {
      if (startX === null) { start(); return; }
      var dx = e.changedTouches[0].clientX - startX;
      startX = null;
      if (Math.abs(dx) > 40) go(index + (dx < 0 ? 1 : -1));
      start();
    }, { passive: true });

    go(0);
    start();
    slider.setAttribute('data-dc-slider', 'ready');
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('[data-dc-slider]').forEach(init);
    });
  } else {
    document.querySelectorAll('[data-dc-slider]').forEach(init);
  }
})();
