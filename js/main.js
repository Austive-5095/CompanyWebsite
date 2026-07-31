

let lastScroll = 0;

const header = document.getElementById("header");
const navToggle = document.querySelector('.nav-toggle');
const navActions = document.querySelector('.nav-actions');

if (navToggle && navActions) {
    navToggle.addEventListener('click', () => {
        const isOpen = navActions.classList.toggle('is-open');
        navToggle.setAttribute('aria-expanded', String(isOpen));
        navToggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
    });

    navActions.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
        navActions.classList.remove('is-open');
        navToggle.setAttribute('aria-expanded', 'false');
        navToggle.setAttribute('aria-label', 'Open navigation menu');
    }));
}

window.addEventListener("scroll", () => {

    const currentScroll = window.pageYOffset;

    // 回到顶部
    if(currentScroll <= 0){

        header.classList.remove("hide");
        header.classList.remove("scrolled");

        lastScroll = 0;

        return;

    }

    // 白色背景
    if(currentScroll > 50){

        header.classList.add("scrolled");

    }else{

        header.classList.remove("scrolled");

    }

    // 往下滚
    if(currentScroll > lastScroll && currentScroll > 120){

        header.classList.add("hide");

    }

    // 往上滚
    else{

        header.classList.remove("hide");

    }

    lastScroll = currentScroll;

});

const trainerPhoto = document.querySelector('.trainer-photo');
if (trainerPhoto) {
    let ticking = false;

    function updateTrainerPhoto() {
        const scrollTop = window.pageYOffset;
        const maxOffset = 120;
        const offset = Math.min(maxOffset, scrollTop * 0.18);
        trainerPhoto.style.transform = `translateY(${offset}px)`;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                updateTrainerPhoto();
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    updateTrainerPhoto();
}

