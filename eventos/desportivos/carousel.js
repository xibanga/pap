const carousels = document.querySelectorAll(".carousel");

carousels.forEach((carousel) => {
    const imagesContainer = carousel.querySelector(".carousel-images");
    const images = imagesContainer.querySelectorAll("img");
    const prevButton = carousel.querySelector(".carousel-prev");
    const nextButton = carousel.querySelector(".carousel-next");
    let currentIndex = 0;

    const updateCarousel = () => {
        const offset = -currentIndex * 100; 
        imagesContainer.style.transform = `translateX(${offset}%)`;
    };

    prevButton.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateCarousel();
    });

    nextButton.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % images.length;
        updateCarousel();
    });

    // Adicionar evento de arrastar com o mouse/touch para permitir deslizar manualmente
    let startX = 0;
    let isDragging = false;

    imagesContainer.addEventListener("mousedown", (event) => {
        isDragging = true;
        startX = event.clientX;
    });

    imagesContainer.addEventListener("mouseup", () => {
        isDragging = false;
    });

    imagesContainer.addEventListener("mousemove", (event) => {
        if (!isDragging) return;
        let moveX = event.clientX - startX;
        if (moveX > 50) { // Se arrastar para a direita
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateCarousel();
            isDragging = false;
        } else if (moveX < -50) { // Se arrastar para a esquerda
            currentIndex = (currentIndex + 1) % images.length;
            updateCarousel();
            isDragging = false;
        }
    });

    // Para suportar toque em dispositivos móveis
    imagesContainer.addEventListener("touchstart", (event) => {
        isDragging = true;
        startX = event.touches[0].clientX;
    });

    imagesContainer.addEventListener("touchend", () => {
        isDragging = false;
    });

    imagesContainer.addEventListener("touchmove", (event) => {
        if (!isDragging) return;
        let moveX = event.touches[0].clientX - startX;
        if (moveX > 50) {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateCarousel();
            isDragging = false;
        } else if (moveX < -50) {
            currentIndex = (currentIndex + 1) % images.length;
            updateCarousel();
            isDragging = false;
        }
    });
});
