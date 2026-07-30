

let lastScroll = 0;

const header = document.getElementById("header");

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

// ================= PHOTO STACK =================

const container = document.querySelector(".home-about-image");

if (container) {

    const photos = [...container.querySelectorAll(".photo")];

    const positions = [
        "position1",
        "position2",
        "position3"
    ];

    function updateStack() {
        photos.forEach((photo, index) => {
            photo.classList.remove(...positions);
            photo.classList.add(positions[index]);
        });
    }

    function bringToFront(photo) {
        const index = photos.indexOf(photo);
        if (index <= 0) return;

        photos.splice(index, 1);
        photos.unshift(photo);
        updateStack();
    }

    photos.forEach((photo) => {
        photo.addEventListener("mouseenter", () => {
            bringToFront(photo);
        });

        photo.addEventListener("mousemove", (event) => {
            const rect = photo.getBoundingClientRect();
            const offsetX = event.clientX - rect.left;
            const offsetY = event.clientY - rect.top;
            const moveX = (offsetX - rect.width / 2) / 20;
            const moveY = (offsetY - rect.height / 2) / 20;

            photo.style.transform = `translate(${moveX}px, ${moveY}px) rotate(${moveX / 12}deg) scale(1.02)`;
        });

        photo.addEventListener("mouseleave", () => {
            photo.style.transform = "";
        });

        let dragging = false;
        let startX = 0;
        let startY = 0;
        let startLeft = 0;
        let startTop = 0;

        photo.addEventListener("pointerdown", (event) => {
            dragging = true;
            photo.classList.add("is-dragging");
            bringToFront(photo);
            startX = event.clientX;
            startY = event.clientY;
            const rect = photo.getBoundingClientRect();
            startLeft = rect.left;
            startTop = rect.top;
            photo.setPointerCapture(event.pointerId);
        });

        window.addEventListener("pointermove", (event) => {
            if (!dragging) return;

            const deltaX = event.clientX - startX;
            const deltaY = event.clientY - startY;
            photo.style.left = `${startLeft - container.getBoundingClientRect().left + deltaX}px`;
            photo.style.top = `${startTop - container.getBoundingClientRect().top + deltaY}px`;
            photo.style.transform = `translate(0px, 0px) rotate(${deltaX / 40}deg)`;
        });

        window.addEventListener("pointerup", () => {
            if (!dragging) return;
            dragging = false;
            photo.classList.remove("is-dragging");
            photo.style.left = "";
            photo.style.top = "";
            photo.style.transform = "";
            updateStack();
        });
    });

}