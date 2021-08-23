// // Automatic Slideshow
// var slides = document.querySelectorAll("#slides .slide");
// var currentSlide = 0;
// var slideInterval = setInterval(nextSlide, 2000);

// function nextSlide(slides, currentSlide) {
//   slides[currentSlide].className = "slide";
//   currentSlide = (currentSlide + 1) % slides.length;
//   slides[currentSlide].className = "slide showing";
// }

// // Manual toggle Slideshow

// var quotes = document.querySelectorAll("#Quotes .quoteitems");
// var currentQuote = 0;

// function nextQuote() {
//   console.log(currentQuote);
//   if (currentQuote <= 3) {
//     quotes[currentQuote].className = "quoteitems";
//     currentQuote = currentQuote + 1;
//     quotes[currentQuote].className = "quote showing";
//   }
// }

// function prevQuote() {
//   console.log(currentQuote);

//   if (currentQuote >= 1) {
//     quotes[currentQuote].className = "quoteitems";
//     currentQuote = (currentQuote - 1) % quotes.length;
//     quotes[currentQuote].className = "quote showing";
//   }
// }

// // ImageGallery
// console.log("hello");
