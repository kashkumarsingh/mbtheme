/**
 * Meraboiler front-end scripts (kept light for Core Web Vitals).
 */
(function () {
  // NOTE: Owl Carousel was removed from the theme 2026-10-14 (no slider
  // uses it any more; promos use dc-slider.js). Do not re-add Owl init here
  // without re-enqueuing the library in functions.php.

  function pingVisit() {
    try {
      var img = new Image();
      img.decoding = "async";
      img.src =
        "https://emeraboiler.com/tracking/log_visit.php?" +
        new URLSearchParams({
          website: window.location.hostname,
          pageUrl: window.location.href,
        }).toString();
    } catch (e) {}
  }

  var pingStarted = false;
  function startPing() {
    if (pingStarted) return;
    pingStarted = true;
    pingVisit();
  }
  ["scroll", "mousedown", "touchstart", "keydown"].forEach(function (evt) {
    window.addEventListener(evt, startPing, { once: true, passive: true });
  });
  setTimeout(startPing, 8000);

  /* ── Header navigation: dropdown toggles + reliable close behaviour ── */
  function hideCollapse(header) {
    var open = header.querySelector("#dcDesktopNav.show");
    if (open && window.bootstrap && window.bootstrap.Collapse) {
      window.bootstrap.Collapse.getOrCreateInstance(open, {
        toggle: false,
      }).hide();
    }
  }

  function initHeaderNav() {
    var header = document.querySelector(".header-section");
    if (!header) return;

    var items = header.querySelectorAll(".nav-item.group");

    function setExpanded(li, expanded) {
      var btn = li.querySelector("button.nav-link");
      if (btn) btn.setAttribute("aria-expanded", expanded ? "true" : "false");
    }

    function closeAll(except) {
      items.forEach(function (li) {
        if (li === except) return;
        if (li.classList.contains("show")) {
          li.classList.remove("show");
          setExpanded(li, false);
        }
      });
    }

    items.forEach(function (li) {
      var btn = li.querySelector("button.nav-link");
      if (!btn) return;
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        var willOpen = !li.classList.contains("show");
        closeAll(li);
        li.classList.toggle("show", willOpen);
        setExpanded(li, willOpen);
      });
    });

    // Clicking anywhere outside the header closes any open dropdown.
    document.addEventListener("click", function (e) {
      if (!header.contains(e.target)) closeAll(null);
    });

    // Escape closes dropdowns and the collapsed mobile menu.
    document.addEventListener("keydown", function (e) {
      if (e.key !== "Escape" && e.key !== "Esc") return;
      closeAll(null);
      hideCollapse(header);
    });

    // Tapping a real link closes the mobile menu.
    header.querySelectorAll(".dc-drawer a[href]").forEach(function (a) {
      a.addEventListener("click", function () {
        closeAll(null);
        closeDrawer();
      });
    });

    // Reset dropdowns whenever the collapsed menu finishes closing.
    var collapseEl = header.querySelector("#dcDesktopNav");
    if (collapseEl) {
      collapseEl.addEventListener("hidden.bs.collapse", function () {
        closeAll(null);
      });
    }

    /* ── Mobile off-canvas drawer ── */
    var drawer = header.querySelector("#dcMobileMenu");
    var overlay = header.querySelector(".dc-drawer__overlay");
    var openBtns = header.querySelectorAll("[data-dc-drawer-open]");
    var closeBtns = header.querySelectorAll("[data-dc-drawer__close]");
    var reduceMotion =
      window.matchMedia &&
      window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    function setToggler(open) {
      openBtns.forEach(function (btn) {
        btn.setAttribute("aria-expanded", open ? "true" : "false");
        btn.setAttribute("aria-label", open ? "Close menu" : "Open menu");
      });
    }

    function openDrawer() {
      if (!drawer || !overlay) return;
      closeSeq++;
      overlay.hidden = false;
      drawer.hidden = false;
      drawer.setAttribute("aria-hidden", "false");
      // Force reflow so the slide transition runs even where rAF is
      // throttled (background tabs); no rAF dependency.
      void drawer.offsetWidth;
      overlay.classList.add("open");
      drawer.classList.add("open");
      document.body.classList.add("dc-lock");
      setToggler(true);
      var closeBtn = drawer.querySelector(".dc-drawer__close");
      if (closeBtn && !reduceMotion) {
        setTimeout(function () {
          closeBtn.focus({ preventScroll: true });
        }, 350);
      } else if (closeBtn) {
        closeBtn.focus({ preventScroll: true });
      }
    }

    var closeSeq = 0;

    function closeDrawer() {
      if (!drawer || !overlay) return;
      if (drawer.hidden && !drawer.classList.contains("open")) return;
      var mySeq = ++closeSeq;
      overlay.classList.remove("open");
      drawer.classList.remove("open");
      document.body.classList.remove("dc-lock");
      drawer.setAttribute("aria-hidden", "true");
      setToggler(false);
      var hide = function () {
        overlay.hidden = true;
        drawer.hidden = true;
      };
      if (reduceMotion) {
        hide();
      } else {
        setTimeout(function () {
          // Skip if the drawer was re-opened while closing.
          if (mySeq === closeSeq) hide();
        }, 360);
      }
    }

    openBtns.forEach(function (btn) {
      btn.addEventListener("click", function () {
        if (drawer.classList.contains("open")) {
          closeDrawer();
        } else {
          closeAll(null);
          openDrawer();
        }
      });
    });

    closeBtns.forEach(function (btn) {
      // Links with data-dc-drawer__close are handled above (navigation);
      // buttons just close.
      if (btn.tagName === "BUTTON") {
        btn.addEventListener("click", function () {
          closeDrawer();
        });
      }
    });

    if (overlay) {
      overlay.addEventListener("click", function () {
        closeDrawer();
      });
    }

    // Escape also closes the drawer (dropdowns handled above).
    document.addEventListener("keydown", function (e) {
      if (e.key !== "Escape" && e.key !== "Esc") return;
      closeDrawer();
    });

    // Submenu accordions inside the drawer.
    header.querySelectorAll(".dc-drawer__toggle").forEach(function (toggle) {
      toggle.addEventListener("click", function () {
        var li = toggle.closest(".dc-drawer__item");
        if (!li) return;
        var sub = li.querySelector(".dc-drawer__sub");
        var willOpen = !li.classList.contains("open");
        // Single-open accordion.
        li.parentElement
          .querySelectorAll(".dc-drawer__item.open")
          .forEach(function (other) {
            if (other !== li) {
              other.classList.remove("open");
              var oSub = other.querySelector(".dc-drawer__sub");
              if (oSub) oSub.hidden = true;
              var oT = other.querySelector(".dc-drawer__toggle");
              if (oT) oT.setAttribute("aria-expanded", "false");
            }
          });
        li.classList.toggle("open", willOpen);
        if (sub) sub.hidden = !willOpen;
        toggle.setAttribute("aria-expanded", willOpen ? "true" : "false");
      });
    });

    // If the viewport grows to desktop while open, close it.
    if (window.matchMedia) {
      window
        .matchMedia("(min-width: 1200px)")
        .addEventListener("change", function (e) {
          if (e.matches) closeDrawer();
        });
    }
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initHeaderNav);
  } else {
    initHeaderNav();
  }

  // Careers roles: single-open accordion.
  function initJobsAccordion() {
    document.querySelectorAll(".dc-jobs").forEach(function (wrap) {
      wrap.addEventListener(
        "toggle",
        function (e) {
          if (!e.target || e.target.open !== true) return;
          wrap.querySelectorAll("details.dc-job[open]").forEach(function (other) {
            if (other !== e.target) other.open = false;
          });
        },
        true
      );
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initJobsAccordion);
  } else {
    initJobsAccordion();
  }
})();
