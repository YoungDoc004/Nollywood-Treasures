let slideIndex = 0;

function showSlides() {
    const slides = document.querySelectorAll('.slideshow-container .slide');
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    slides[slideIndex - 1].style.display = 'block';
    setTimeout(showSlides, 5000); // Change image every 5 seconds
}

document.addEventListener('DOMContentLoaded', () => {
    showSlides();
});

document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('introModal');
  document.getElementById('enterBtn').onclick = () => {
    modal.style.display = 'none';
  };
  // Optional: auto-hide after 5 seconds
  // setTimeout(() => modal.style.display = 'none', 5000);
});
