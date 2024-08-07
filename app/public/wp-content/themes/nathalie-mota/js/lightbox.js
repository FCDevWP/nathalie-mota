class Lightbox {
    static init() {
        const links = Array.from(document.querySelectorAll('a.custom-lightbox'));
        const gallery = links.map(link => {
            const info = {
                href: link.getAttribute('href'),
                title: link.getAttribute('data-title'),
                category: link.getAttribute('data-category'),
                reference: link.getAttribute('data-reference')
            };
            console.log('Link info:', info);
            return info;
        });
    

        links.forEach(link => link.addEventListener('click', e => {
            e.preventDefault();
            new Lightbox(e.currentTarget.getAttribute('href'), gallery);
        }));
        const photoItems = document.querySelectorAll('.photo-item');
        photoItems.forEach(item => {
            const eyeIcon = item.querySelector('.photo-eye-icon');
            const expandIcon = item.querySelector('.photo-expand-icon');
            const link = item.querySelector('a.custom-lightbox');
    
            eyeIcon.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                window.location.href = link.getAttribute('data-single-url');
            });
    
            expandIcon.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                link.click();
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
        const imageInfo = this.images.find(img => img.href === url);
        console.log('Image info:', imageInfo);
        this.url = url;
        const container = this.element.querySelector('.lightbox__container');
        const loader = document.createElement('div');
        loader.classList.add('lightbox__loader');
        container.innerHTML = '';
        container.appendChild(loader);
        const img = new Image();
        img.onload = () => {
            console.log('Category:', imageInfo.category);
            console.log('Reference:', imageInfo.reference);
    
            container.removeChild(loader);
            container.appendChild(img);
            if (imageInfo) {
                this.element.querySelector('.lightbox__category').textContent = `${imageInfo.category || 'Non spécifiée'}`;
                this.element.querySelector('.lightbox__reference').textContent = `${imageInfo.reference || 'Non spécifiée'}`;
            }
            this.element.classList.add('lightbox--open');
            console.log('Category element:', this.element.querySelector('.lightbox__category'));
            console.log('Reference element:', this.element.querySelector('.lightbox__reference'));
    
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
        let i = this.images.findIndex(image => image.href === this.url);
        if (i === this.images.length - 1) {
            i = -1;
        }
        this.loadImage(this.images[i + 1].href);
    }

    prev(e) {
        e.preventDefault();
        let i = this.images.findIndex(image => image.href === this.url);
        if (i === 0) {
            i = this.images.length;
        }
        this.loadImage(this.images[i - 1].href);
    }

    buildDOM() {
        const dom = document.createElement('div');
        dom.classList.add('lightbox');
        dom.innerHTML = `
            <button class="lightbox__close">X</button>
            <button class="lightbox__next"><span class="button-icon"></span>Suivante</button>
            <button class="lightbox__prev"><span class="button-icon"></span>Précédente</button>
            <div class="lightbox__content">
                <div class="lightbox__container"></div>
                <div class="lightbox__info">
                    <p class="lightbox__reference"></p>
                    <p class="lightbox__category"></p>
                </div>
            </div>

        `;
        dom.querySelector('.lightbox__close').addEventListener('click', this.close.bind(this));
        dom.querySelector('.lightbox__next').addEventListener('click', this.next.bind(this));
        dom.querySelector('.lightbox__prev').addEventListener('click', this.prev.bind(this));
        
        console.log('Lightbox DOM:', dom.innerHTML);
        
        return dom;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log ('test')
    Lightbox.init();
});
