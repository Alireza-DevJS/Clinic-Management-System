function testimonialSlider() {

    return {

        current: 1,

        timer: null,

        testimonials: [

            {
                name: "علی رضایی",
                service: "ایمپلنت",
                avatar: "/frontend/img/Face-Avatar/Avatar1.jpg",
                text: "تجربه خیلی خوبی داشتم. همه چیز حرفه‌ای و بدون درد انجام شد."
            },

            {
                name: "نگار حسینی",
                service: "کامپوزیت",
                avatar: "/frontend/img/Face-Avatar/Avatar2.jpg",
                text: "خیلی خوشحالم که این کلینیک رو انتخاب کردم. رفتار پرسنل فوق‌العاده بود."
            },

            {
                name: "امیر محمدی",
                service: "ارتودنسی",
                avatar: "/frontend/img/Face-Avatar/Avatar3.jpg",
                text: "بهترین تجربه دندانپزشکی من بود. از نتیجه درمان واقعاً راضی هستم."
            }

        ],

        next() {

            this.current++;

            if (this.current >= this.testimonials.length) {

                this.current = 0;

            }

        },

        prev() {

            this.current--;

            if (this.current < 0) {

                this.current = this.testimonials.length - 1;

            }

        },

        startAutoPlay() {

            this.timer = setInterval(() => {

                this.next();

            }, 4500);

        }

    }

}