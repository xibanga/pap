const carousels = document.querySelectorAll(".carousel");

carousels.forEach((carousel) => {
    const imagesContainer = carousel.querySelector(".carousel-images");
    const images = imagesContainer.querySelectorAll("img");
    const prevButton = carousel.querySelector(".carousel-prev");
    const nextButton = carousel.querySelector(".carousel-next");
    let currentIndex = 0;

    const updateCarousel = () => {
        const offset = -currentIndex * 600; // Largura de cada imagem
        imagesContainer.style.transform = `translateX(${offset}px)`;
    };

    prevButton.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateCarousel();
    });

    nextButton.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % images.length;
        updateCarousel();
    });
});
