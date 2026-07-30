window.portfolioSlider = function () {
  return {
    active: 3,

    items: [
      {
        id: 1,
        title: "ایمپلنت",
        image: "/frontend/img/Portfolio-img/After-Implant.png",
        imgBefore: "/frontend/img/Portfolio-img/Before-Implant.png"
      },
      {
        id: 2,
        title: "ارتودنسی",
        image: "/frontend/img/Portfolio-img/After-Orto.png",
        imgBefore: "/frontend/img/Portfolio-img/Before-Orto.png"
      },
      {
        id: 3,
        title: "کامپوزیت",
        image: "/frontend/img/Portfolio-img/After-Composite.png",
        imgBefore: "/frontend/img/Portfolio-img/Before-Composite.png"
      },
      {
        id: 4,
        title: "لمینت",
        image: "/frontend/img/Portfolio-img/After-Laminet.png",
        imgBefore: "/frontend/img/Portfolio-img/Before-Laminet.png"
      },
      {
        id: 5,
        title: "جرم گیری",
        image: "/frontend/img/Portfolio-img/Fixing.png",
      },
    ],

    next() {
      const card = this.$refs.track.querySelector(".portfolio-card");
      const gap = parseFloat(getComputedStyle(this.$refs.track).gap) || 0;

      this.$refs.track.scrollBy({
        left: card.offsetWidth + gap,
        behavior: "smooth",
      });

      setTimeout(() => this.updateCurrentIndex(), 350);
    },

    prev() {
      const card = this.$refs.track.querySelector(".portfolio-card");
      const gap = parseFloat(getComputedStyle(this.$refs.track).gap) || 0;

      this.$refs.track.scrollBy({
        left: -(card.offsetWidth + gap),
        behavior: "smooth",
      });

      setTimeout(() => this.updateCurrentIndex(), 350);
    },

    currentIndex: 2,

    init() {
      this.$nextTick(() => {
        const card = this.$refs.track.querySelector(".portfolio-card");
        if (!card) return;

        const cards = this.$refs.track.querySelectorAll(".portfolio-card");
        const targetCard = cards[this.currentIndex];

        const left =
          targetCard.offsetLeft -
          this.$refs.track.clientWidth / 2 +
          targetCard.offsetWidth / 2;

        this.$refs.track.scrollTo({
          left,
          behavior: "auto",
        });
      });
    },

    updateCurrentIndex() {
      const cards = this.$refs.track.querySelectorAll(".portfolio-card");

      const trackCenter =
        this.$refs.track.getBoundingClientRect().left +
        this.$refs.track.offsetWidth / 2;

      let active = 0;
      let minDistance = Infinity;

      cards.forEach((card, index) => {
        const rect = card.getBoundingClientRect();

        const cardCenter = rect.left + rect.width / 2;

        const distance = Math.abs(trackCenter - cardCenter);

        if (distance < minDistance) {
          minDistance = distance;
          active = index;
        }
      });

      this.currentIndex = active;
      this.active = this.items[this.currentIndex].id;
    },
    goTo(index) {
      const card = this.$refs.track.querySelector(".portfolio-card");
      const gap = parseFloat(getComputedStyle(this.$refs.track).gap) || 0;

      this.$refs.track.scrollTo({
        left: index * (card.offsetWidth + gap),
        behavior: "smooth",
      });

      this.currentIndex = index;
    },
  };
};
