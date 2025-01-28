@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-center mt-5">
        <!-- Sol Taraf: Arama Kutusu + Popüler Aramalar -->
        <div class="col-md-8">
            <h1 class="fw-bold">Kariyer Fırsatlarını Keşfet</h1>
            <p class="fs-5"><strong>71.293</strong> iş ilanı on binlerce şirket</p>

            <!-- Arama Formu -->
            <form method="GET" action="{{ route('home') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" name="position" class="form-control" placeholder="{{ __('Pozisyon, Şirket') }}" value="{{ request('position') }}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="city" class="form-control" placeholder="{{ __('Şehir veya İlçe') }}" value="{{ request('city') }}">
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
                <a href="#" class="btn btn-outline-secondary m-1">Finans Uzmanı</a>
                <a href="#" class="btn btn-outline-secondary m-1">Dijital Pazarlama Uzmanı</a>
                <a href="#" class="btn btn-outline-secondary m-1">Yazılım Geliştirme Uzmanı</a>
                <a href="#" class="btn btn-outline-secondary m-1">Proje Yöneticisi</a>
                <a href="#" class="btn btn-outline-secondary m-1">İK Uzmanı</a>
                <a href="#" class="btn btn-outline-secondary m-1">İstanbul</a>
                <a href="#" class="btn btn-outline-secondary m-1">Ankara</a>
                <a href="#" class="btn btn-outline-secondary m-1">İzmir</a>
                <a href="#" class="btn btn-outline-secondary m-1">Bursa</a>
            </div>
        </div>

        <!-- Sağ Taraf: Büyük "K" Logosu -->
        <div class="col-md-4 text-end">
            <img src="{{ asset('images/k-logo.png') }}" alt="K Logo" class="img-fluid" style="max-height: 250px;">
        </div>
    </div>

    <!-- İş İlanları Listesi -->
    <div class="mt-5">
        @if($jobs->count())
            @foreach($jobs as $job)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $job->position }} - {{ $job->company }}</h5>
                        <p class="card-text">{{ Str::limit($job->description, 100) }}</p>
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary">{{ __('View Details') }}</a>
                    </div>
                </div>
            @endforeach
        @else
            <p>{{ __('No job postings available.') }}</p>
        @endif
    </div>
</div>
@endsection
