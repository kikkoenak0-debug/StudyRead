// landing.js
document.addEventListener('DOMContentLoaded', () => {
    const searchBtn = document.getElementById('searchBtn');
    const searchInput = document.getElementById('searchInput');

    // Fitur Cari Buku Sederhana
    searchBtn.addEventListener('click', () => {
        const query = searchInput.value.trim();
        if (query !== "") {
            alert("Mencari buku: " + query + "\n(Fitur ini akan terhubung ke database nanti)");
        } else {
            alert("Masukkan judul buku atau nama penulis!");
        }
    });

    // Menangani pencarian dengan tombol Enter
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            searchBtn.click();
        }
    });

    // Slider functionality with DOM manipulation
    (function() {
      const container = document.getElementById('newContainer');
      const prevBtn = document.getElementById('prevNew');
      const nextBtn = document.getElementById('nextNew');
      if (!container || !prevBtn || !nextBtn) return;

      let isAnimating = false;

      const getCardWidth = () => {
        const first = container.querySelector('.book-card');
        if (!first) return 0;
        const style = window.getComputedStyle(first);
        const marginRight = parseFloat(style.marginRight) || 0;
        return first.getBoundingClientRect().width + marginRight;
      };

      const slideNext = () => {
        if (isAnimating) return;
        isAnimating = true;
        const distance = getCardWidth();
        container.style.transition = 'transform 300ms ease';
        container.style.transform = `translateX(-${distance}px)`;

        const onEnd = () => {
          container.style.transition = 'none';
          container.style.transform = 'translateX(0)';
          const first = container.querySelector('.book-card');
          if (first) container.appendChild(first);
          isAnimating = false;
          container.removeEventListener('transitionend', onEnd);
        };
        container.addEventListener('transitionend', onEnd);
      };

      const slidePrev = () => {
        if (isAnimating) return;
        isAnimating = true;
        const cards = container.querySelectorAll('.book-card');
        if (!cards.length) { isAnimating = false; return; }
        const last = cards[cards.length - 1];
        container.insertBefore(last, container.firstChild);
        const distance = getCardWidth();
        container.style.transition = 'none';
        container.style.transform = `translateX(-${distance}px)`;
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            container.style.transition = 'transform 300ms ease';
            container.style.transform = 'translateX(0)';
          });
        });

        const onEnd = () => {
          container.style.transition = 'none';
          isAnimating = false;
          container.removeEventListener('transitionend', onEnd);
        };
        container.addEventListener('transitionend', onEnd);
      };

      nextBtn.addEventListener('click', slideNext);
      prevBtn.addEventListener('click', slidePrev);

      // Opsional: auto slide
      // let auto = setInterval(slideNext, 5000);
      // [prevBtn, nextBtn, container].forEach(el => {
      //   el.addEventListener('mouseenter', () => clearInterval(auto));
      //   el.addEventListener('mouseleave', () => auto = setInterval(slideNext, 5000));
      // });
    })();
});
