@extends('layouts.main') 

@section('content')
<div class="container">
    <div class="row align-items-center mt-5">
        <!-- Sol Taraf: Arama Kutusu + Popüler Aramalar -->
        <div class="col-md-8">
            <h1 class="fw-bold">{{ __('Kariyer Fırsatlarını Keşfet') }}</h1>
            <p class="fs-5"><strong>71.293</strong> {{ __('iş ilanı on binlerce şirket') }}</p>

            <!-- Arama Formu -->
       <!-- resources/views/home.blade.php içindeki form kısmı -->
<form method="GET" action="{{ route('search.results') }}" class="mb-4">
    <div class="row">
        <div class="col-md-5">
            <input type="text" 
                   name="position" 
                   id="position-autocomplete" 
                   class="form-control" 
                   placeholder="{{ __('Pozisyon, Şirket') }}" 
                   value="{{ request('position') }}">
        </div>
        <div class="col-md-5">
            <input type="text" 
                   name="city" 
                   id="city-autocomplete" 
                   class="form-control" 
                   placeholder="{{ __('Şehir veya İlçe') }}" 
                   value="{{ request('city') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary search-btn w-100">
                <i class="fas fa-search"></i> {{ __('İş Bul') }}
            </button>
        </div>
    </div>
</form>

            <!-- Popüler Aramalar -->
            <div class="d-flex flex-wrap">
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('Finans Uzmanı') }}</a>
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('Dijital Pazarlama Uzmanı') }}</a>
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('Yazılım Geliştirme Uzmanı') }}</a>
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('Proje Yöneticisi') }}</a>
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('İK Uzmanı') }}</a>
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('İstanbul') }}</a>
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('Ankara') }}</a>
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('İzmir') }}</a>
                <a href="#" class="btn btn-outline-secondary m-1">{{ __('Bursa') }}</a>
            </div>
        </div>

        <!-- Sağ Taraf: Büyük "K" Logosu -->
        <div class="col-md-4 text-end">
            <img src="{{ asset('images/k-logo.png') }}" alt="K Logo" class="img-fluid" style="max-height: 250px;">
        </div>
    </div>

    <!-- Öne Çıkan İlanlar -->
    <div class="mt-5">
        <h2 class="fw-bold mb-4">{{ __('Öne Çıkan İlanlar') }}</h2>
        
        <div class="featured-jobs-slider">
            <div class="slider-container">
                <button class="slider-nav prev-btn" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="jobs-wrapper">
                    <div class="jobs-track">
                        @if($jobs->count())
                            @foreach($jobs as $job)
                                <div class="job-card">
                                    <div class="card h-100">
                                        <img src="{{ $job->randomImage() }}" class="card-img-top job-img" alt="{{ $job->company }}">
                                        <div class="card-body text-center d-flex flex-column">
                                            <h5 class="card-title mb-3">{{ $job->position }}</h5>
                                            <p class="card-text fw-bold mb-2">{{ $job->company }}</p>
                                            <p class="text-muted mb-3">{{ $job->city }} @if($job->town), {{ $job->town }} @endif</p>
                                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary mt-auto">{{ __('Detayları Gör') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>{{ __('No job postings available.') }}</p>
                        @endif
                    </div>
                </div>
                <button class="slider-nav next-btn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.featured-jobs-slider {
    position: relative;
    margin: 20px 0;
}

.slider-container {
    display: flex;
    align-items: center;
    gap: 20px;
}

.jobs-wrapper {
    overflow: hidden;
    width: 100%;
}

.jobs-track {
    display: flex;
    transition: transform 0.3s ease-in-out;
}

.job-card {
    flex: 0 0 25%;
    padding: 0 10px;
    box-sizing: border-box;
}

.job-img {
    height: 200px;
    object-fit: cover;
}

.slider-nav {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.slider-nav:hover:not(:disabled) {
    background: #e9ecef;
    border-color: #ced4da;
}

.slider-nav:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive ayarlamalar */
@media (max-width: 992px) {
    .job-card {
        flex: 0 0 33.333%;
    }
}

@media (max-width: 768px) {
    .job-card {
        flex: 0 0 50%;
    }
}

@media (max-width: 576px) {
    .job-card {
        flex: 0 0 100%;
    }
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Pozisyon autocomplete
    $('#position-autocomplete').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('autocomplete.positions') }}",
                data: { term: request.term },
                dataType: "json",
                success: function(data) {
                    if (data.length === 0) {
                        response([{ label: "Pozisyonlarda ara...", value: "" }]);
                    } else {
                        response(data);
                    }
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            if (ui.item.value === "") {
                event.preventDefault();
            }
        }
    });

    // Şehir autocomplete
    $('#city-autocomplete').autocomplete({
        source: "{{ route('autocomplete.cities') }}",
        minLength: 2,
    });

    // Slider fonksiyonları
    const wrapper = $('.jobs-wrapper');
    const track = $('.jobs-track');
    const cards = $('.job-card');
    const prevBtn = $('.prev-btn');
    const nextBtn = $('.next-btn');
    
    let currentIndex = 0;
    let visibleCards = 4;

    // Responsive görünüm için kart sayısını ayarla
    function updateVisibleCards() {
        if (window.innerWidth <= 576) {
            visibleCards = 1;
        } else if (window.innerWidth <= 768) {
            visibleCards = 2;
        } else if (window.innerWidth <= 992) {
            visibleCards = 3;
        } else {
            visibleCards = 4;
        }
        updateSliderPosition();
    }

    function updateSliderPosition() {
        const cardWidth = wrapper.width() / visibleCards;
        const translateX = -currentIndex * cardWidth;
        track.css('transform', `translateX(${translateX}px)`);
        
        // Buton durumlarını güncelle
        prevBtn.prop('disabled', currentIndex === 0);
        nextBtn.prop('disabled', currentIndex >= cards.length - visibleCards);
    }

    nextBtn.click(function() {
        if (currentIndex < cards.length - visibleCards) {
            currentIndex++;
            updateSliderPosition();
        }
    });

    prevBtn.click(function() {
        if (currentIndex > 0) {
            currentIndex--;
            updateSliderPosition();
        }
    });

    // Sayfa yüklendiğinde ve pencere boyutu değiştiğinde
    updateVisibleCards();
    $(window).resize(_.debounce(updateVisibleCards, 150));
});
</script>
@endsection