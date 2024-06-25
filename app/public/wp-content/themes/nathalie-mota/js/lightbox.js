class Lightbox {
    static init() {
        const links = document.querySelectorAll('.photo-gallery .photo-item a.fancybox');
        links.forEach((link) => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const url = link.getAttribute('href');
                const images = Array.from(links).map(link => link.getAttribute('href'));
                new Lightbox(url, images);
            });
        });
    }

    constructor(url, images) {
        this.element = this.buildDOM();
        this.images = images;
        this.loadImage(url);
        this.onKeyUp = this.onKeyUp.bind(this);
        document.body.appendChild(this.element);
        document.addEventListener('keyup', this.onKeyUp);
    }

    loadImage(url) {
        this.url = url;
        const container = this.element.querySelector('.lightbox__container');
        const loader = document.createElement('div');
        loader.classList.add('lightbox__loader');
        container.innerHTML = '';
        container.appendChild(loader);
        const img = new Image();
        img.onload = () => {
            container.removeChild(loader);
            container.appendChild(img);
            this.element.classList.add('lightbox--open');
        }
        img.src = url;
    }

    onKeyUp(e) {
        if (e.key === 'Escape') {
            this.close(e);
        } else if (e.key === 'ArrowLeft') {
            this.prev(e);
        } else if (e.key === 'ArrowRight') {
            this.next(e);
        }
    }

    close(e) {
        e.preventDefault();
        this.element.classList.remove('lightbox--open');
        window.setTimeout(() => {
            this.element.parentElement.removeChild(this.element);
        }, 500);
        document.removeEventListener('keyup', this.onKeyUp);
    }

    next(e) {
        e.preventDefault();
        let i = this.images.findIndex(image => image === this.url);
        if (i === this.images.length - 1) {
            i = -1;
        }
        this.loadImage(this.images[(i + 1)]);
    }

    prev(e) {
        e.preventDefault();
        let i = this.images.findIndex(image => image === this.url);
        if (i === 0) {
            i = this.images.length;
        }
        this.loadImage(this.images[i - 1]);
    }

    buildDOM() {
        const dom = document.createElement('div');
        dom.classList.add('lightbox');
        dom.innerHTML = `
            <button class="lightbox__close">X</button>
            <button class="lightbox__next"><span class="button-icon"></span>Suivante</button>
            <button class="lightbox__prev"><span class="button-icon"></span>Précédente</button>
            <div class="lightbox__container"></div>
        `;
        dom.querySelector('.lightbox__close').addEventListener('click', this.close.bind(this));
        dom.querySelector('.lightbox__next').addEventListener('click', this.next.bind(this));
        dom.querySelector('.lightbox__prev').addEventListener('click', this.prev.bind(this));
        return dom;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    Lightbox.init();

    const photoItems = document.querySelectorAll('.photo-item');
    photoItems.forEach(item => {
        const eyeIcon = item.querySelector('.photo-eye-icon');
        const expandIcon = item.querySelector('.photo-expand-icon');
        const link = item.querySelector('a.fancybox');

        eyeIcon.addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = link.getAttribute('data-single-url');
        });

        expandIcon.addEventListener('click', (e) => {
            e.preventDefault();
            link.click();
        });
    });
});
