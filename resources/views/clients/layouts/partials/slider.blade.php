<div id="mainSlider" class="carousel slide mb-4" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('assets/img/slider/slider4.jpg') }}" class="d-block w-100" alt="Banner 1">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/img/slider/slider5.jpg') }}" class="d-block w-100" alt="Banner 2">
    </div>
    <div class="carousel-item">
      <img src="{{ asset('assets/img/slider/slider6.jpg') }}" class="d-block w-100" alt="Banner 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Slider loaded");

        const myCarousel = document.querySelector('#mainSlider');
        if (myCarousel) {
            new bootstrap.Carousel(myCarousel, {
                interval: 3000,
                ride: 'carousel'
            });
        }
    });
</script> -->
