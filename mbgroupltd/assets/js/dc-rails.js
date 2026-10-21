/* MeraBoiler linear rail slider for homepage reviews (vanilla JS).
   Arrows + draggable rail thumb. 3 cards visible on desktop (>820px),
   1 on smaller screens (must match .dc-rail__slide basis in dc-home.css). */
(function () {
  var REDUCED = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var DESKTOP_Q = '(min-width: 821px)';
  var DESKTOP_PER_VIEW = 3;
  var MOBILE_PER_VIEW = 1;

  function init(rail) {
    var track = rail.querySelector('.dc-rail__track');
    var slides = rail.querySelectorAll('.dc-rail__slide');
    var bar = rail.querySelector('[data-dc-rail-bar]');
    var thumb = rail.querySelector('[data-dc-rail-thumb]');
    if (!track || slides.length < 2) {
      rail.setAttribute('data-dc-rail', 'ready');
      return;
    }

    var timeout = parseInt(rail.getAttribute('data-autoplay'), 10) || 0;
    var total = slides.length;
    var index = 0;
    var timer = null;
    var dotsWrap = rail.querySelector('[data-dc-rail-dots]');
    var lastMax = -1;

    function perView() {
      if (window.matchMedia && window.matchMedia(DESKTOP_Q).matches) return Math.min(DESKTOP_PER_VIEW, total);
      return MOBILE_PER_VIEW;
    }

    function maxIndex() {
      return Math.max(0, total - perView());
    }

    function step() {
      var w = slides[0].getBoundingClientRect().width;
      var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      return w + gap;
    }

    function paint() {
      var max = maxIndex();
      if (thumb) {
        var span = 100 / total;
        thumb.style.width = (span * perView()) + '%';
        thumb.style.left = (max > 0 ? (index / max) * (100 - span * perView()) : 0) + '%';
      }
      paintDots(max);
    }

    function paintDots(max) {
      if (!dotsWrap) return;
      if (max !== lastMax) {
        lastMax = max;
        dotsWrap.innerHTML = '';
        for (var k = 0; k <= max; k++) {
          (function (n) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'dc-rail__dot';
            b.setAttribute('aria-label', 'Show reviews from position ' + (n + 1));
            b.addEventListener('click', function () { go(n); restart(); });
            dotsWrap.appendChild(b);
          })(k);
        }
      }
      var kids = dotsWrap.children;
      for (var k = 0; k < kids.length; k++) {
        kids[k].classList.toggle('dc-rail__dot--active', k === index);
        kids[k].setAttribute('aria-current', k === index ? 'true' : 'false');
      }
    }

    function go(i) {
      var max = maxIndex();
      index = ((i % (max + 1)) + (max + 1)) % (max + 1);
      track.style.transform = 'translateX(-' + index * step() + 'px)';
      paint();
    }

    function stop() {
      if (timer) { clearInterval(timer); timer = null; }
      rail.removeAttribute('data-dc-autoplay-on');
    }

    function start() {
      if (timeout <= 0 || REDUCED || timer) return;
      if (document.hidden) return;
      timer = setInterval(function () { go(index + 1); }, timeout);
      rail.setAttribute('data-dc-autoplay-on', 'true');
    }

    function restart() { stop(); start(); }

    rail.addEventListener('mouseenter', stop);
    rail.addEventListener('mouseleave', start);
    rail.addEventListener('focusin', stop);
    rail.addEventListener('focusout', start);
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) stop();
      else start();
    });

    if (window.matchMedia) {
      window.matchMedia(DESKTOP_Q).addEventListener('change', function () { go(index); });
    }
    var rsTimer = null;
    window.addEventListener('resize', function () {
      clearTimeout(rsTimer);
      rsTimer = setTimeout(function () { go(index); }, 150);
    });

    // Drag the thumb to scrub through the reviews (only if the rail bar exists).
    if (bar && thumb) {
    var dragging = false;
    function thumbTo(clientX) {
      var rect = bar.getBoundingClientRect();
      var ratio = (clientX - rect.left) / rect.width;
      ratio = Math.max(0, Math.min(1, ratio));
      go(Math.round(ratio * maxIndex()));
    }
    thumb.addEventListener('pointerdown', function (e) {
      dragging = true;
      thumb.setPointerCapture(e.pointerId);
      stop();
      thumbTo(e.clientX);
    });
    thumb.addEventListener('pointermove', function (e) {
      if (dragging) thumbTo(e.clientX);
    });
    thumb.addEventListener('pointerup', function () {
      dragging = false;
      start();
    });
    thumb.addEventListener('pointercancel', function () {
      dragging = false;
      start();
    });
    bar.addEventListener('click', function (e) {
      thumbTo(e.clientX);
      restart();
    });
    }

    // Basic touch swipe on the track.
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
    rail.setAttribute('data-dc-rail', 'ready');
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('[data-dc-rail]').forEach(init);
    });
  } else {
    document.querySelectorAll('[data-dc-rail]').forEach(init);
  }
})();
