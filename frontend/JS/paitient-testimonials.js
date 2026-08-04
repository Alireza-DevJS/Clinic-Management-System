function patientTestimonials() {
    return {

        active: 0,

        items: [
            {
                name: "سارا محمدی",
                role: "کامپوزیت ونیر",
                image: "./assets/images/patients/1.webp",
                text: "از همون جلسه اول احساس آرامش داشتم..."
            },
            {
                name: "علی کریمی",
                role: "ایمپلنت دندان",
                image: "./assets/images/patients/2.webp",
                text: "تجربه فوق‌العاده‌ای بود..."
            },
            {
                name: "مهدی رضایی",
                role: "ارتودنسی ثابت",
                image: "./assets/images/patients/3.webp",
                text: "نتیجه دقیقاً همون چیزی شد که میخواستم..."
            },
            {
                name: "نگار احمدی",
                role: "لمینت",
                image: "./assets/images/patients/4.webp",
                text: "برخورد پرسنل فوق‌العاده بود..."
            }
        ],

        next() {
            this.active =
                (this.active + 1) % this.items.length;
        },

        prev() {
            this.active =
                (this.active - 1 + this.items.length) % this.items.length;
        },

        go(index) {
            this.active = index;
        },

        isActive(index) {
            return index === this.active;
        },

        isPrev(index) {
            return index ===
                (this.active - 1 + this.items.length) % this.items.length;
        },

        isNext(index) {
            return index ===
                (this.active + 1) % this.items.length;
        }

    }
}