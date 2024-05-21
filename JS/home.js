// Slideshow Homepagina

const fotos = document.getElementsByClassName('slideshow')[0].getElementsByTagName('img');
let currentFotoIndex = 0;
 
function reviewStyleGiven() {
    for (const foto of fotos) {
        foto.style.display = 'none';
    }
    fotos[currentFotoIndex].style.display = 'block';
}
 
reviewStyleGiven();
 
function openGamePage(url) {
    window.location.href = url;
}
 
function switchSlide() {
    let nextFotoIndex = currentFotoIndex + 1;
 
    if (nextFotoIndex === fotos.length) {
        nextFotoIndex = 0;
    }
 
    fotos[currentFotoIndex].style.display = 'none';
    fotos[nextFotoIndex].style.display = 'block';
 
    currentFotoIndex = nextFotoIndex; // Update currentFotoIndex
 
    // Don't forget to update currentFotoIndex after switching
}
 
setInterval(switchSlide, 5000);
 

