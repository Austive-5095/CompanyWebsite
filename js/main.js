

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

