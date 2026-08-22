/*
 * Corporate Academy — vanilla front-end enhancements.
 * No build step: this file is copied verbatim to public/assets/app.js.
 * Keep it small, dependency-free and defensive (every handler no-ops when
 * its target markup is absent).
 */
(function () {
  "use strict";

  var doc = document;

  function on(el, evt, fn) {
    if (el) el.addEventListener(evt, fn);
  }

  /* ── Phone inputs with country dial code ──────────────────── */
  /* Mirrors the React PhoneInput: on submit, prepend the selected dial
     code to the phone field so the stored value is e.g. "+91 9876543210". */
  function initPhoneInputs() {
    var groups = doc.querySelectorAll("[data-phone-group]");
    groups.forEach(function (group) {
      var form = group.closest("form");
      var dial = group.querySelector("[data-phone-dial]");
      var input = group.querySelector('input[name="phone"]');
      if (!form || !dial || !input) return;
      on(form, "submit", function () {
        var local = input.value.trim();
        if (local && local.charAt(0) !== "+") {
          input.value = dial.value + " " + local;
        }
      });
    });
  }

  /* ── Announcement bar dismiss ─────────────────────────────── */
  function initAnnouncement() {
    var bar = doc.querySelector("[data-announcement]");
    var dismiss = doc.querySelector("[data-announcement-dismiss]");
    var header = doc.querySelector("[data-navbar]");
    on(dismiss, "click", function () {
      if (bar) bar.style.display = "none";
      if (header) header.style.top = "0px";
    });
  }

  /* ── Navbar scroll shadow ─────────────────────────────────── */
  function initScrollShadow() {
    var header = doc.querySelector("[data-navbar]");
    if (!header) return;
    var scrolledCls = ["bg-[#060e24]/95", "shadow-xl", "shadow-black/20"];
    var baseCls = ["bg-[#060e24]/85"];
    function apply() {
      var scrolled = window.scrollY > 8;
      scrolledCls.forEach(function (c) { header.classList.toggle(c, scrolled); });
      baseCls.forEach(function (c) { header.classList.toggle(c, !scrolled); });
    }
    window.addEventListener("scroll", apply, { passive: true });
    apply();
  }

  /* ── Mobile menu toggle ───────────────────────────────────── */
  function initMobileMenu() {
    var toggle = doc.querySelector("[data-mobile-toggle]");
    var drawer = doc.querySelector("[data-mobile-drawer]");
    var backdrop = doc.querySelector("[data-mobile-backdrop]");
    var closeBtn = doc.querySelector("[data-mobile-close]");
    if (!drawer) return;

    function open() {
      drawer.classList.remove("hidden");
      drawer.classList.add("flex");
      if (backdrop) backdrop.classList.remove("hidden");
    }
    function close() {
      drawer.classList.add("hidden");
      drawer.classList.remove("flex");
      if (backdrop) backdrop.classList.add("hidden");
    }
    on(toggle, "click", open);
    on(closeBtn, "click", close);
    on(backdrop, "click", close);
  }

  /* ── Desktop nav dropdowns (hover + click) ────────────────── */
  function initDropdowns() {
    var dropdowns = doc.querySelectorAll("[data-dropdown]");
    Array.prototype.forEach.call(dropdowns, function (dd) {
      var toggle = dd.querySelector("[data-dropdown-toggle]");
      var panel = dd.querySelector("[data-dropdown-panel]");
      var caret = dd.querySelector("[data-dropdown-caret]");
      if (!panel) return;
      var timer = null;

      function show() {
        if (timer) { clearTimeout(timer); timer = null; }
        panel.classList.remove("hidden");
        if (caret) caret.classList.add("rotate-180");
      }
      function hide() {
        panel.classList.add("hidden");
        if (caret) caret.classList.remove("rotate-180");
      }
      function scheduleHide() {
        timer = setTimeout(hide, 120);
      }

      dd.addEventListener("mouseenter", show);
      dd.addEventListener("mouseleave", scheduleHide);
      on(toggle, "click", function (e) {
        e.preventDefault();
        if (panel.classList.contains("hidden")) show(); else hide();
      });
    });
  }

  /* ── Language dropdown toggle ─────────────────────────────── */
  function initLangSwitchers() {
    var switchers = doc.querySelectorAll("[data-lang-switcher]");
    Array.prototype.forEach.call(switchers, function (sw) {
      var toggle = sw.querySelector("[data-lang-toggle]");
      var panel = sw.querySelector("[data-lang-panel]");
      if (!panel) return;
      on(toggle, "click", function (e) {
        e.stopPropagation();
        panel.classList.toggle("hidden");
      });
    });
    doc.addEventListener("click", function (e) {
      Array.prototype.forEach.call(doc.querySelectorAll("[data-lang-panel]"), function (p) {
        if (!p.parentNode.contains(e.target)) p.classList.add("hidden");
      });
    });
  }

  /* ── Generic accordion (data-accordion) ───────────────────── */
  function initAccordions() {
    var triggers = doc.querySelectorAll("[data-accordion-trigger]");
    Array.prototype.forEach.call(triggers, function (trigger) {
      on(trigger, "click", function () {
        var id = trigger.getAttribute("data-accordion-trigger");
        var panel = doc.querySelector('[data-accordion-panel="' + id + '"]');
        if (!panel) return;
        var isOpen = !panel.classList.contains("hidden");
        panel.classList.toggle("hidden", isOpen);
        trigger.setAttribute("aria-expanded", String(!isOpen));
      });
    });
  }

  /* ── Fade-in on scroll (.ca-rise-on-scroll) ───────────────── */
  function initScrollReveal() {
    var els = doc.querySelectorAll(".ca-rise-on-scroll");
    if (!els.length) return;
    if (!("IntersectionObserver" in window)) {
      Array.prototype.forEach.call(els, function (el) { el.classList.add("ca-rise"); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("ca-rise");
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    Array.prototype.forEach.call(els, function (el) { io.observe(el); });
  }

  /* ── Chat widget (POST /api/chat) ─────────────────────────── */
  function initChat() {
    var widget = doc.querySelector("[data-chat-widget]");
    if (!widget) return;
    var openBtn = widget.querySelector("[data-chat-open]");
    var closeBtn = widget.querySelector("[data-chat-close]");
    var panel = widget.querySelector("[data-chat-panel]");
    var messagesEl = widget.querySelector("[data-chat-messages]");
    var form = widget.querySelector("[data-chat-form]");
    var input = widget.querySelector("[data-chat-input]");
    if (!panel || !messagesEl || !form || !input) return;

    var errorText = panel.getAttribute("data-chat-error") || "Sorry, something went wrong.";
    var history = [];
    var busy = false;

    function toggle(show) {
      panel.classList.toggle("hidden", !show);
      panel.classList.toggle("flex", show);
      if (show) input.focus();
    }
    on(openBtn, "click", function () { toggle(panel.classList.contains("hidden")); });
    on(closeBtn, "click", function () { toggle(false); });

    function bubble(role, text) {
      var el = doc.createElement("div");
      if (role === "user") {
        el.className = "max-w-[85%] self-end rounded-2xl rounded-br-sm bg-primary px-3 py-2 text-primary-foreground";
      } else {
        el.className = "max-w-[85%] self-start rounded-2xl rounded-bl-sm bg-muted px-3 py-2 text-foreground";
      }
      el.textContent = text;
      messagesEl.appendChild(el);
      messagesEl.scrollTop = messagesEl.scrollHeight;
      return el;
    }

    on(form, "submit", function (e) {
      e.preventDefault();
      if (busy) return;
      var text = (input.value || "").trim();
      if (!text) return;
      input.value = "";
      bubble("user", text);
      history.push({ role: "user", content: text });
      busy = true;

      var typing = bubble("assistant", "…");

      fetch("/api/chat", {
        method: "POST",
        headers: { "Content-Type": "application/json", "Accept": "application/json" },
        body: JSON.stringify({ messages: history })
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          var reply = (data && data.reply) ? data.reply : errorText;
          typing.textContent = reply;
          history.push({ role: "assistant", content: reply });
        })
        .catch(function () {
          typing.textContent = errorText;
        })
        .finally(function () {
          busy = false;
          messagesEl.scrollTop = messagesEl.scrollHeight;
        });
    });
  }

  /* ── Hero course search autocomplete ─────────────────────── */
  function initHeroSearch() {
    var root = doc.querySelector("[data-hero-search]");
    if (!root) return;
    var input = root.querySelector("[data-hero-search-input]");
    var list = root.querySelector("[data-hero-suggestions]");
    if (!input || !list) return;

    var timer = null;
    var controller = null;

    function hide() {
      list.classList.add("hidden");
      list.innerHTML = "";
      input.setAttribute("aria-expanded", "false");
    }

    function render(courses) {
      list.innerHTML = "";
      if (!courses || !courses.length) {
        hide();
        return;
      }
      courses.slice(0, 6).forEach(function (c) {
        var li = doc.createElement("li");
        var a = doc.createElement("a");
        a.href = "/courses/" + encodeURIComponent(c.slug);
        a.className =
          "flex items-start gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-primary/5 transition-colors";
        var title = doc.createElement("span");
        title.className = "font-medium text-gray-900 line-clamp-1";
        title.textContent = c.title || "";
        var cat = doc.createElement("span");
        cat.className = "block text-xs text-gray-400";
        cat.textContent = c.category_name || "";
        var wrap = doc.createElement("span");
        wrap.className = "min-w-0";
        wrap.appendChild(title);
        wrap.appendChild(cat);
        a.appendChild(wrap);
        li.appendChild(a);
        list.appendChild(li);
      });
      list.classList.remove("hidden");
      input.setAttribute("aria-expanded", "true");
    }

    function fetchSuggestions(term) {
      if (controller) controller.abort();
      controller =
        typeof AbortController !== "undefined" ? new AbortController() : null;
      var url = "/api/courses?search=" + encodeURIComponent(term);
      fetch(url, {
        headers: { Accept: "application/json" },
        signal: controller ? controller.signal : undefined,
      })
        .then(function (r) {
          return r.ok ? r.json() : [];
        })
        .then(render)
        .catch(function () {
          /* aborted or network error — leave list untouched */
        });
    }

    on(input, "input", function () {
      var term = input.value.trim();
      if (timer) window.clearTimeout(timer);
      if (term.length < 2) {
        hide();
        return;
      }
      timer = window.setTimeout(function () {
        fetchSuggestions(term);
      }, 220);
    });

    doc.addEventListener("click", function (e) {
      if (!root.contains(e.target)) hide();
    });
    on(input, "keydown", function (e) {
      if (e.key === "Escape") hide();
    });
  }

  /* ── Reviews platform tabs (filter cards client-side) ─────── */
  function initReviewTabs() {
    var tabsWrap = doc.querySelector("[data-review-tabs]");
    var grid = doc.querySelector("[data-review-grid]");
    if (!tabsWrap || !grid) return;
    var tabs = tabsWrap.querySelectorAll("[data-review-tab]");
    var cards = grid.querySelectorAll("[data-review-card]");
    var activeCls = ["bg-primary", "text-white", "shadow-md", "shadow-primary/30"];
    var idleCls = ["text-gray-600", "hover:text-primary", "hover:bg-gray-50"];

    function setActive(btn) {
      Array.prototype.forEach.call(tabs, function (t) {
        activeCls.forEach(function (c) { t.classList.remove(c); });
        idleCls.forEach(function (c) { t.classList.add(c); });
      });
      idleCls.forEach(function (c) { btn.classList.remove(c); });
      activeCls.forEach(function (c) { btn.classList.add(c); });
    }

    Array.prototype.forEach.call(tabs, function (btn) {
      on(btn, "click", function () {
        var filter = btn.getAttribute("data-review-tab");
        setActive(btn);
        Array.prototype.forEach.call(cards, function (card) {
          var src = card.getAttribute("data-review-source");
          card.style.display =
            filter === "all" || src === filter ? "" : "none";
        });
      });
    });
  }

  /* ── Lead-capture popup ("Get Your Free Course Guide") ────── */
  /* Mirrors the React LeadPopup: appears ~5s after load, 3-step wizard,
     submits to POST /leads. Hidden markup lives in partials/lead-popup. */
  function initLeadPopup() {

    
    var overlay = doc.querySelector("[data-lead-popup]");
    if (!overlay) return;
    var panel = overlay.querySelector("[data-lead-panel]");
    var form = overlay.querySelector("[data-lead-form]");
    var wizard = overlay.querySelector("[data-lead-wizard]");
    var success = overlay.querySelector("[data-lead-success]");
    var cta = overlay.querySelector("[data-lead-cta]");
    var ctaText = overlay.querySelector("[data-lead-cta-text]");
    var ctaArrow = overlay.querySelector("[data-lead-cta-arrow]");
    var bar = overlay.querySelector("[data-lead-bar]");
    if (!panel || !form || !wizard || !cta || !ctaText) return;

    var step = 0;
    var busy = false;
    var barColors = [
      ["from-blue-500", "to-primary"],
      ["from-primary", "to-indigo-500"],
      ["from-indigo-500", "to-violet-500"]
    ];

    function qs(sel) { return overlay.querySelector(sel); }

    function setError(name, show) {
      var err = qs('[data-lead-err="' + name + '"]');
      var input = form.querySelector('[name="' + name + '"]');
      if (err) err.classList.toggle("hidden", !show);
      if (input) {
        input.classList.toggle("border-red-400", show);
        input.classList.toggle("ring-red-300", show);
      }
    }

    function renderStep() {
      for (var i = 0; i < 3; i++) {
        var pane = qs('[data-lead-step="' + i + '"]');
        var label = qs('[data-lead-step-label="' + i + '"]');
        if (pane) pane.classList.toggle("hidden", i !== step);
        if (label) label.classList.toggle("hidden", i !== step);

        var dot = qs('[data-lead-step-dot="' + i + '"]');
        if (dot) {
          var check = dot.querySelector("[data-lead-step-check]");
          var icon = dot.querySelector("[data-lead-step-icon]");
          var isDone = i < step;
          var isActive = i === step;
          if (check) check.classList.toggle("hidden", !isDone);
          if (icon) icon.classList.toggle("hidden", isDone);
          dot.className =
            "flex items-center justify-center w-7 h-7 rounded-full border-2 shrink-0 transition-all duration-300 " +
            (isDone
              ? "bg-primary border-primary text-white"
              : isActive
              ? "border-primary text-primary bg-primary/10"
              : "border-muted-foreground/20 text-muted-foreground/30");
        }
        var line = qs('[data-lead-step-line="' + i + '"]');
        if (line) {
          line.classList.toggle("bg-primary", i < step);
          line.classList.toggle("bg-muted-foreground/15", i >= step);
        }
      }
      if (bar) {
        barColors.forEach(function (pair) {
          pair.forEach(function (c) { bar.classList.remove(c); });
        });
        (barColors[step] || barColors[0]).forEach(function (c) { bar.classList.add(c); });
      }
      ctaText.textContent = cta.getAttribute(step < 2 ? "data-label-continue" : "data-label-submit");
      if (ctaArrow) ctaArrow.classList.toggle("hidden", step >= 2);
    }

    function validate() {
      if (step !== 0) return true;
      var name = form.querySelector('[name="name"]');
      var email = form.querySelector('[name="email"]');
      var ok = true;
      var nameBad = !name || !name.value.trim();
      var emailBad = !email || email.value.trim().indexOf("@") === -1;
      setError("name", nameBad);
      setError("email", emailBad);
      if (nameBad || emailBad) ok = false;
      return ok;
    }

    function open() {
      overlay.classList.remove("hidden");
      overlay.classList.add("flex");
      doc.body.style.overflow = "hidden";
    }
    function close() {
      overlay.classList.add("hidden");
      overlay.classList.remove("flex");
      doc.body.style.overflow = "";
    }

    on(overlay, "click", function (e) {
      if (!panel.contains(e.target)) close();
    });
    on(qs("[data-lead-close]"), "click", close);
    doc.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && !overlay.classList.contains("hidden")) close();
    });

    function fillTemplate(sel, value) {
      var el = qs(sel);
      if (!el) return;
      var tpl = el.getAttribute("data-template") || "";
      el.textContent = tpl.replace("__NAME__", value.name || "").replace("__EMAIL__", value.email || "");
    }

    function submitLead() {
      var nameInput = form.querySelector('[name="name"]');
      var emailInput = form.querySelector('[name="email"]');
      var phoneInput = form.querySelector('[name="phone"]');
      var dial = form.querySelector("[data-phone-dial]");
      var ageEl = qs("[data-lead-age]");
      var expEl = qs("[data-lead-experience]");
      var courseEl = qs("[data-lead-course]");
      var msgEl = qs("[data-lead-message]");

      var phone = phoneInput ? phoneInput.value.trim() : "";
      if (phone && phone.charAt(0) !== "+" && dial) {
        phone = dial.value + " " + phone;
      }

      /* Compose the message body exactly like the React popup. */
      var parts = [];
      if (ageEl && ageEl.value.trim()) parts.push("Age: " + ageEl.value.trim());
      if (expEl && expEl.value) parts.push("Experience: " + expEl.value);
      if (courseEl && courseEl.value) parts.push("Course interest: " + courseEl.value);
      if (msgEl && msgEl.value.trim()) parts.push(msgEl.value.trim());

      var data = new FormData();
      var token = form.querySelector('input[name="_token"]');
      if (token) data.append("_token", token.value);
      data.append("name", nameInput ? nameInput.value.trim() : "");
      data.append("email", emailInput ? emailInput.value.trim() : "");
      if (phone) data.append("phone", phone);
      if (parts.length) data.append("message", parts.join(" | "));

      busy = true;
      cta.disabled = true;
      ctaText.textContent = cta.getAttribute("data-label-submitting");

      fetch(form.getAttribute("action") || "/leads", {
        method: "POST",
        headers: { Accept: "application/json" },
        body: data
      })
        .then(function (r) {
          if (!r.ok) throw new Error("lead submit failed");
          var values = {
            name: (nameInput ? nameInput.value.trim() : "").split(" ")[0],
            email: emailInput ? emailInput.value.trim() : ""
          };
          fillTemplate("[data-lead-success-body]", values);
          fillTemplate("[data-lead-success-inbox]", values);
          wizard.classList.add("hidden");
          success.classList.remove("hidden");
          success.classList.add("flex");
          setTimeout(close, 3000);
        })
        .catch(function () {
          /* leave the form open so the visitor can retry */
        })
        .finally(function () {
          busy = false;
          cta.disabled = false;
          ctaText.textContent = cta.getAttribute(step < 2 ? "data-label-continue" : "data-label-submit");
        });
    }

    on(form, "submit", function (e) {
      e.preventDefault();
      if (busy) return;
      if (!validate()) return;
      if (step < 2) {
        step += 1;
        renderStep();
        return;
      }
      submitLead();
    });

    renderStep();
    setTimeout(open, 5000);
  }

  function init() {
    initAnnouncement();
    initScrollShadow();
    initMobileMenu();
    initDropdowns();
    initLangSwitchers();
    initAccordions();
    initScrollReveal();
    initChat();
    initHeroSearch();
    initReviewTabs();
    initPhoneInputs();
    initLeadPopup();
  }

  if (doc.readyState === "loading") {
    doc.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
