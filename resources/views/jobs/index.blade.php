@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-center mt-5">
        <!-- Sol Taraf: Arama Kutusu + Popüler Aramalar -->
        <div class="col-md-8">
            <h1 class="fw-bold">{{ __('Kariyer Fırsatlarını Keşfet') }}</h1>
            <p class="fs-5"><strong>71.293</strong> {{ __('iş ilanı on binlerce şirket') }}</p>

            <!-- Arama Formu -->
            <form method="GET" action="{{ route('home') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" name="position" id="position-autocomplete" class="form-control" placeholder="{{ __('Pozisyon, Şirket') }}" value="{{ request('position') }}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="city" id="city-autocomplete" class="form-control" placeholder="{{ __('Şehir veya İlçe') }}" value="{{ request('city') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn search-btn">
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
        <h2 class="fw-bold">{{ __('Öne Çıkan İlanlar') }}</h2>
        <div class="row">
            @if($jobs->count())
                @foreach($jobs as $job)
                    <div class="col-md-3">
                        <div class="card job-card">
                            <!-- Rastgele Resim -->
                            <img src="{{ $job->randomImage() }}" class="card-img-top job-img" alt="{{ $job->company }}">
                            
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $job->position }}</h5>
                                <p class="card-text fw-bold">{{ $job->company }}</p>
                                <p class="text-muted">{{ $job->city }} @if($job->town), {{ $job->town }} @endif</p>
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary w-100">{{ __('Detayları Gör') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>{{ __('No job postings available.') }}</p>
            @endif
        </div>
    </div>
</div>
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
                            response([{ label: "Pozisyonlarda ara...", value: "" }]); // İlk satırda sabit mesaj göster
                        } else {
                            response(data);
                        }
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                if (ui.item.value === "") {
                    event.preventDefault(); // Eğer tıklarsa, seçim olmasın
                }
            }
        });

        // Şehir autocomplete
        $('#city-autocomplete').autocomplete({
            source: "{{ route('autocomplete.cities') }}",
            minLength: 2,
        });
    });
</script>

@endsection
