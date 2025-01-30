@extends('layouts.main') 

@section('content')
<div class="container">
    <div class="row align-items-center mt-5">
        <!-- Sol Taraf: Arama Kutusu + Popüler Aramalar -->
        <div class="col-md-8">
            <h1 class="fw-bold"><span data-translate="discover_opportunities">Kariyer Fırsatlarını Keşfet</span></h1>
            <p class="fs-5"><strong>71.293</strong> <span data-translate="job_listings">iş ilanı on binlerce şirket</span></p>

            <!-- Arama Formu -->
            <form method="GET" action="{{ route('search.results') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" 
                               name="position" 
                               id="position-autocomplete" 
                               class="form-control" 
                               data-translate-placeholder="search_position"
                               value="{{ request('position') }}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" 
                               name="city" 
                               id="city-autocomplete" 
                               class="form-control" 
                               data-translate-placeholder="search_city"
                               value="{{ request('city') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn search-btn w-100">
                            <i class="fas fa-search"></i> <span data-translate="find_job">İş Bul</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Popüler Aramalar -->
            <div class="d-flex flex-wrap">
                <a href="{{ route('search.results', ['position' => 'Finans Uzmanı']) }}" class="btn btn-outline-secondary m-1"><span data-translate="finance_specialist">Finans Uzmanı</span></a>
                <a href="{{ route('search.results', ['position' => 'Dijital Pazarlama Uzmanı']) }}" class="btn btn-outline-secondary m-1"><span data-translate="digital_marketing">Dijital Pazarlama Uzmanı</span></a>
                <a href="{{ route('search.results', ['position' => 'Yazılım Geliştirme Uzmanı']) }}" class="btn btn-outline-secondary m-1"><span data-translate="software_developer">Yazılım Geliştirme Uzmanı</span></a>
                <a href="{{ route('search.results', ['position' => 'Proje Yöneticisi']) }}" class="btn btn-outline-secondary m-1"><span data-translate="project_manager">Proje Yöneticisi</span></a>
                <a href="{{ route('search.results', ['position' => 'İK Uzmanı']) }}" class="btn btn-outline-secondary m-1"><span data-translate="hr_specialist">İK Uzmanı</span></a>
                <a href="{{ route('search.results', ['city' => 'İstanbul']) }}" class="btn btn-outline-secondary m-1"><span data-translate="istanbul">İstanbul</span></a>
                <a href="{{ route('search.results', ['city' => 'Ankara']) }}" class="btn btn-outline-secondary m-1"><span data-translate="ankara">Ankara</span></a>
                <a href="{{ route('search.results', ['city' => 'İzmir']) }}" class="btn btn-outline-secondary m-1"><span data-translate="izmir">İzmir</span></a>
                <a href="{{ route('search.results', ['city' => 'Bursa']) }}" class="btn btn-outline-secondary m-1"><span data-translate="bursa">Bursa</span></a>
            </div>
        </div>

        <!-- Sağ Taraf: Büyük "K" Logosu -->
        <div class="col-md-4 text-end">
            <img src="{{ asset('images/k-logo.png') }}" alt="K Logo" class="img-fluid" style="max-height: 250px;">
        </div>
    </div>

    <!-- Öne Çıkan İlanlar -->
    <div class="mt-5">
        <h2 class="fw-bold mb-4"><span data-translate="featured_jobs">Öne Çıkan İlanlar</span></h2>
        
        <div class="featured-jobs-slider">
            <div class="slider-container">
                <button class="slider-nav prev-btn" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="jobs-wrapper">
                    <div class="jobs-track">
                        @if($jobs->count())
                            @foreach($jobs as $job)
                                <div class="job-card" onclick="window.location.href='{{ route('jobs.show', $job->id) }}'">
                                    <div class="card">
                                        <div class="img-wrapper">
                                            <img src="{{ $job->images ?? $job->randomImage() }}" class="job-img" alt="{{ $job->company }}">
                                        </div>
                                        <div class="card-content">
                                            <h5 class="title">{{ $job->position }}</h5>
                                            <p class="company">{{ $job->company }}</p>
                                            <p class="location">{{ $job->city }} @if($job->town), {{ $job->town }} @endif</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p><span data-translate="no_jobs">İş ilanı bulunmamaktadır.</span></p>
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
    :root {
        --primary-purple: #6934FF;
        --primary-purple-hover: #5729D9;
        --secondary-purple: #8B5CF6;
        --light-purple: #EDE9FE;
    }

    /* Ana Başlık Stilleri */
    h1 {
        color: #1F2937;
    }

    /* Arama butonu */
    .search-btn {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
        color: white;
        border-radius: 8px;
        padding: 0.625rem 1rem;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background-color: var(--primary-purple-hover);
        border-color: var(--primary-purple-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(105, 52, 255, 0.2);
    }

    /* Popüler aramalar butonları */
    .btn-outline-secondary {
        border-color: #E2E8F0;
        color: #64748B;
        border-radius: 20px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-outline-secondary:hover {
        background-color: var(--light-purple);
        border-color: var(--primary-purple);
        color: var(--primary-purple);
    }

    /* İş Kartları Slider */
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

    /* İş Kartları */
    .job-card {
        flex: 0 0 25%;
        padding: 10px;
    }

    .job-card .card {
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        height: 300px;
        background: white;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .job-card .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(105, 52, 255, 0.1);
        border-color: var(--primary-purple);
    }

    .img-wrapper {
        height: 160px;
        width: 100%;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .job-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .card-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .title, .company, .location {
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-purple);
    }

    .company {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .location {
        font-size: 14px;
        color: #6B7280;
    }

    /* Slider Navigasyon Butonları */
    .slider-nav {
        background: white;
        border: 2px solid var(--primary-purple);
        color: var(--primary-purple);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .slider-nav:hover:not(:disabled) {
        background: var(--primary-purple);
        color: white;
    }

    .slider-nav:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        border-color: #CBD5E1;
        color: #CBD5E1;
    }

    /* Form Kontrolleri */
    .form-control {
        border-radius: 8px;
        padding: 0.625rem 1rem;
        border: 2px solid #E2E8F0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 3px rgba(105, 52, 255, 0.1);
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