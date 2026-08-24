/* Solvive Travel — shared interactions */
document.addEventListener('DOMContentLoaded', function () {

  /* ---- Header scroll state ---- */
  const header = document.querySelector('.site-header');
  const onScroll = () => {
    if (!header) return;
    header.classList.toggle('is-scrolled', window.scrollY > 40);
  };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  /* ---- Mobile nav ---- */
  const hamburger = document.querySelector('.hamburger');
  const nav = document.querySelector('.main-nav');
  if (hamburger && nav) {
    hamburger.addEventListener('click', () => {
      nav.classList.toggle('open');
      hamburger.classList.toggle('open');
      document.body.style.overflow = nav.classList.contains('open') ? 'hidden' : '';
    });
    document.querySelectorAll('.has-dropdown > a').forEach((link) => {
      link.addEventListener('click', (e) => {
        if (window.innerWidth <= 1080) {
          e.preventDefault();
          link.parentElement.classList.toggle('open');
        }
      });
    });
  }

  /* ---- Scroll reveal ---- */
  const revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.14, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach((el) => io.observe(el));
  } else {
    revealEls.forEach((el) => el.classList.add('in'));
  }

  /* ---- Contact page tabs ---- */
  const tabs = document.querySelectorAll('.contact-tab');
  if (tabs.length) {
    const activate = (target) => {
      tabs.forEach((t) => t.classList.remove('active'));
      document.querySelectorAll('.contact-panel').forEach((p) => p.classList.remove('active'));
      const tab = document.querySelector('[data-target="' + target + '"]');
      if (tab) tab.classList.add('active');
      const panel = document.getElementById(target);
      if (panel) panel.classList.add('active');
    };
    tabs.forEach((tab) => {
      tab.addEventListener('click', () => activate(tab.dataset.target));
    });
    if (window.location.hash === '#inquire') activate('panel-inquire');
    if (window.location.hash === '#consult') activate('panel-consult');
  }

  /* ---- FAQ accordion ---- */
  document.querySelectorAll('.faq-item').forEach((item) => {
    const q = item.querySelector('.faq-q');
    const a = item.querySelector('.faq-a');
    if (!q || !a) return;
    q.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach((openItem) => {
        if (openItem !== item) {
          openItem.classList.remove('open');
          openItem.querySelector('.faq-a').style.maxHeight = null;
        }
      });
      item.classList.toggle('open', !isOpen);
      a.style.maxHeight = !isOpen ? a.scrollHeight + 'px' : null;
    });
  });

  /* ---- Inquiry form backend handles submission ---- */

  /* ---- Footer year ---- */
  const yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

});
