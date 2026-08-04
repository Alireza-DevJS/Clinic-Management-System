window.portfolioSlider = function () {
  return {
    active: 3,

    items: [
      {
        id: 1,
        title: "ایمپلنت دندان ",
        subtitle: "لبخند طبیعی و زیبا",
        description:
          "جایگزینی دندان‌های از دست رفته با ایمپلنت برای بازگرداندن زیبایی، عملکرد و استحکام طبیعی لبخند.",
        image: "/frontend/img/Portfolio-img/After-Implant.png",
        imgBefore: "/frontend/img/Portfolio-img/Before-Implant.png",
        icon: "/frontend/Icons/Dental-Icons/implant.png",
        altBefore:'قبل از ایمپلنت دندان',
        altAfter:'بعد از ایمپلنت دندان',
        features: [
          "🦷 جایگزینی دائمی",
          "✨ ظاهر طبیعی",
          "💎 استحکام بالا",
          "⚡ عملکرد مشابه دندان",
        ],
      },

      {
        id: 2,
        title: "ارتودنسی",
        subtitle: "لبخندی منظم، زیبا و ماندگار",
        description:
          "اصلاح نامرتبی دندان‌ها و ناهنجاری‌های فک برای ایجاد لبخندی سالم، هماهنگ و زیبا.",
        image: "/frontend/img/Portfolio-img/After-Orto.png",
        imgBefore: "/frontend/img/Portfolio-img/Before-Orto.png",
        icon: "/frontend/Icons/Dental-Icons/orthodontic.png",
        altBefore:'قبل از ارتودنسی دندان',
        altAfter:'بعد از ارتودنسی دندان',
        features: [
          "😁 مرتب شدن دندان‌ها",
          "🦷 اصلاح بایت",
          "📈 بهبود عملکرد فک",
          "✨ لبخندی هماهنگ",
        ],
      },

      {
        id: 3,
        title: "کامپوزیت دندان",
        subtitle: "زیبایی طبیعی با کامپوزیت حرفه‌ای",
        description:
          "اصلاح فرم و رنگ دندان‌ها با کامپوزیت برای داشتن لبخندی طبیعی، درخشان و جذاب در کوتاه‌ترین زمان.",
        image: "/frontend/img/Portfolio-img/After-Composite.png",
        imgBefore: "/frontend/img/Portfolio-img/Before-Composite.png",
        icon: "/frontend/Icons/Dental-Icons/dental-crown.png",
        altBefore:'قبل از کامپوزیت دندان',
        altAfter:'بعد از کامپوزیت دندان',
        features: [
          "✨ زیبایی طبیعی",
          "🛡️ بدون تراش زیاد",
          "💎 ماندگاری بالا",
          "⚡ نتیجه فوری",
        ],
      },

      {
        id: 4,
        title: "لمینت دندان",
        subtitle: "لبخندی سفید، طبیعی و ماندگار",
        description:
          "اصلاح رنگ، فرم و فاصله دندان‌ها با لمینت سرامیکی برای ایجاد لبخندی زیبا و ماندگار.",
        image: "/frontend/img/Portfolio-img/After-Laminet.png",
        imgBefore: "/frontend/img/Portfolio-img/Before-Laminet.png",
        icon: "/frontend/Icons/Dental-Icons/dental-crown.png",
        altBefore:'قبل از لمینت دندان',
        altAfter:'بعد از لمینت دندان',
        features: [
          "🤍 سفیدی طبیعی",
          "💎 دوام بالا",
          "😁 اصلاح فرم دندان",
          "✨ لبخندی جذاب",
        ],
      },

      {
        id: 5,
        title: "جرم‌گیری دندان",
        subtitle: "دندان‌هایی تمیز و لبخندی سالم",
        description:
          "حذف جرم و پلاک‌های دندانی برای حفظ سلامت لثه، جلوگیری از بیماری‌های دهان و افزایش درخشندگی دندان‌ها.",
        image: "/frontend/img/Portfolio-img/Fixing.png",
        // imgBefore: "/frontend/img/Portfolio-img/Before-Scaling.png",
        icon: "/frontend/Icons/Dental-Icons/teeth-scaling.png",
        altBefore:'قبل از جرم‌گیری دندان',
        altAfter:'بعد از جرم‌گیری دندان',
        features: [
          "🦷 حذف جرم",
          "🪥 پاکسازی کامل",
          "💙 سلامت لثه",
          "✨ درخشندگی دندان",
        ],
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
    get currentItem() {
      return this.items.find((item) => item.id === this.active);
    },
  };
};
