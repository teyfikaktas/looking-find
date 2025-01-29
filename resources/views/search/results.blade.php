<!-- resources/views/search/results.blade.php -->
@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Sol Taraf - Filtreler -->
        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filtreler</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('search.results') }}" method="GET" id="filter-form">
                        <!-- Mevcut arama parametrelerini koru -->
                        <input type="hidden" name="position" value="{{ request('position') }}">
                        <input type="hidden" name="city" value="{{ request('city') }}">

                        <!-- Ülke/Şehir/İlçe -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ülke / Şehir / İlçe</label>
                            <select class="form-select mb-2" name="country" id="country-select">
                                <option value="">Ülke Seçin</option>
                                <option value="Türkiye" {{ request('country') == 'Türkiye' ? 'selected' : '' }}>Türkiye</option>
                            </select>
                            <select class="form-select mb-2" name="city" id="city-select">
                                <option value="">Şehir Seçin</option>
                            </select>
                            <select class="form-select" name="town" id="town-select">
                                <option value="">İlçe Seçin</option>
                            </select>
                        </div>

                        <!-- Çalışma Tercihi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Çalışma Tercihi</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="working_preference[]" value="on-site" id="on-site"
                                    {{ in_array('on-site', (array)request('working_preference')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="on-site">İş Yerinde</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="working_preference[]" value="remote" id="remote"
                                    {{ in_array('remote', (array)request('working_preference')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="remote">Uzaktan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="working_preference[]" value="hybrid" id="hybrid"
                                    {{ in_array('hybrid', (array)request('working_preference')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hybrid">Hibrit</label>
                            </div>
                        </div>

                        <!-- İlan Tarihi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">İlan Tarihi</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="date_filter" value="today" id="today"
                                    {{ request('date_filter') == 'today' ? 'checked' : '' }}>
                                <label class="form-check-label" for="today">Bugün</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="date_filter" value="yesterday" id="yesterday"
                                    {{ request('date_filter') == 'yesterday' ? 'checked' : '' }}>
                                <label class="form-check-label" for="yesterday">Dün</label>
                            </div>
                        </div>

                        <button type="submit" class="btn w-100" style="background-color: #8A2BE2; color: white;">Uygula</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sağ Taraf - Sonuçlar -->
        <div class="col-lg-9">
            <!-- Üst Kısım - Sonuç Sayısı ve Sıralama -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="mb-0">{{ $jobs->total() }} ilan bulundu</p>
                <select class="form-select" style="width: auto;" onchange="window.location.href=this.value">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" 
                            {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>En Yeni</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}"
                            {{ request('sort') == 'oldest' ? 'selected' : '' }}>En Eski</option>
                </select>
            </div>

            <!-- Aktif Filtreler -->
            @if(request()->anyFilled(['position', 'city', 'working_preference', 'country', 'town', 'date_filter']))
                <div class="d-flex align-items-center mb-3 flex-wrap">
                    <span class="me-2">Seçili Filtreler:</span>
                    
                    @if(request('position'))
                        <span class="badge bg-light text-dark me-2 mb-2">
                            {{ request('position') }}
                            <a href="{{ route('search.results', array_merge(
                                request()->except('position'),
                                ['page' => 1]
                            )) }}" class="text-dark text-decoration-none ms-1">&times;</a>
                        </span>
                    @endif

                    @if(request('country'))
                        <span class="badge bg-light text-dark me-2 mb-2">
                            {{ request('country') }}
                            <a href="{{ route('search.results', array_merge(
                                request()->except('country'),
                                ['page' => 1]
                            )) }}" class="text-dark text-decoration-none ms-1">&times;</a>
                        </span>
                    @endif

                    @if(request('city'))
                        <span class="badge bg-light text-dark me-2 mb-2">
                            {{ request('city') }}
                            <a href="{{ route('search.results', array_merge(
                                request()->except('city'),
                                ['page' => 1]
                            )) }}" class="text-dark text-decoration-none ms-1">&times;</a>
                        </span>
                    @endif

                    @if(request('town'))
                        <span class="badge bg-light text-dark me-2 mb-2">
                            {{ request('town') }}
                            <a href="{{ route('search.results', array_merge(
                                request()->except('town'),
                                ['page' => 1]
                            )) }}" class="text-dark text-decoration-none ms-1">&times;</a>
                        </span>
                    @endif

                    @if(request('working_preference'))
                        @foreach((array)request('working_preference') as $pref)
                            <span class="badge bg-light text-dark me-2 mb-2">
                                @php
                                    $prefLabels = [
                                        'on-site' => 'İş Yerinde',
                                        'remote' => 'Uzaktan',
                                        'hybrid' => 'Hibrit'
                                    ];
                                @endphp
                                {{ $prefLabels[$pref] ?? $pref }}
                                <a href="{{ route('search.results', array_merge(
                                    request()->except('working_preference'),
                                    [
                                        'working_preference' => array_values(array_diff((array)request('working_preference'), [$pref])),
                                        'page' => 1
                                    ]
                                )) }}" class="text-dark text-decoration-none ms-1">&times;</a>
                            </span>
                        @endforeach
                    @endif

                    @if(request('date_filter'))
                        <span class="badge bg-light text-dark me-2 mb-2">
                            {{ request('date_filter') == 'today' ? 'Bugün' : 'Dün' }}
                            <a href="{{ route('search.results', array_merge(
                                request()->except('date_filter'),
                                ['page' => 1]
                            )) }}" class="text-dark text-decoration-none ms-1">&times;</a>
                        </span>
                    @endif

                    <a href="{{ route('search.results') }}" class="btn btn-sm btn-outline-secondary mb-2">Filtreleri Temizle</a>
                </div>
            @endif

            <!-- Sonuçlar -->
            @forelse($jobs as $job)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ $job->company_logo }}" alt="{{ $job->company }}" 
                                     class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="col">
                                <h5 class="card-title mb-1">{{ $job->position }}</h5>
                                <h6 class="text-purple mb-2">{{ $job->company }}</h6>
                                <div class="d-flex flex-wrap text-muted small">
                                    <span class="me-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $job->city }}@if($job->town), {{ $job->town }}@endif
                                    </span>
                                    <span class="me-3">
                                        <i class="fas fa-building me-1"></i>
                                        @php
                                            $workingPreferenceLabels = [
                                                'on-site' => 'İş Yerinde',
                                                'remote' => 'Uzaktan',
                                                'hybrid' => 'Hibrit'
                                            ];
                                        @endphp
                                        {{ $workingPreferenceLabels[$job->working_preference] ?? $job->working_preference }}
                                    </span>
                                    <span>
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $job->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-purple">Detayları Gör</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Arama kriterlerinize uygun ilan bulunamadı.
                </div>
            @endforelse

            <!-- Sayfalama -->
            <div class="d-flex justify-content-center">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Sayfa yüklendiğinde şehirleri getir
    if ($('#country-select').val() === 'Türkiye') {
        $.get('/api/cities', function(cities) {
            let citySelect = $('#city-select');
            citySelect.empty().append('<option value="">Şehir Seçin</option>');
            cities.forEach(city => {
                citySelect.append(`<option value="${city}" ${city === '{{ request('city') }}' ? 'selected' : ''}>${city}</option>`);
            });
            
            // Şehir seçili ise ilçeleri getir
            if ('{{ request('city') }}') {
                loadTowns('{{ request('city') }}');
            }
        });
    }

    // Filtreleri otomatik submit et
    $('.form-check-input, select[name="city"], select[name="town"]').change(function() {
        $('#filter-form').submit();
    });

    // Ülke değiştiğinde şehirleri getir
    $('#country-select').change(function() {
        let country = $(this).val();
        let citySelect = $('#city-select');
        let townSelect = $('#town-select');
        
        citySelect.empty().append('<option value="">Şehir Seçin</option>');
        townSelect.empty().append('<option value="">İlçe Seçin</option>');
        
        if(country === 'Türkiye') {
            $.get('/api/cities', function(cities) {
                cities.forEach(city => {
                    citySelect.append(`<option value="${city}">${city}</option>`);
                });
            });
        }
        
        $('#filter-form').submit();
    });

    // İlçeleri dinamik yükle
    function loadTowns(city) {
        if(city) {
            $.get(`/api/towns/${city}`, function(towns) {
                let townSelect = $('#town-select');
                townSelect.empty().append('<option value="">İlçe Seçin</option>');
                towns.forEach(town => {
                    townSelect.append(`<option value="${town}" ${town === '{{ request('town') }}' ? 'selected' : ''}>${town}</option>`);
                });
            });
        }
    }

    $('#city-select').change(function() {
        loadTowns($(this).val());
        $('#filter-form').submit();
    });
});
</script>
@endsection

@section('styles')
<style>
.btn-purple, .btn-purple:hover {
    background-color: #8A2BE2;
    border-color: #8A2BE2;
    color: white;
}

.btn-outline-purple {
    color: #8A2BE2;
    border-color: #8A2BE2;
}

.btn-outline-purple:hover {
    background-color: #8A2BE2;
    color: white;
}

.text-purple {
    color: #8A2BE2 !important;
}

.badge {
    padding: 0.5em 0.8em;
}

.form-select:focus, .form-check-input:checked {
    border-color: #8A2BE2;
    box-shadow: 0 0 0 0.25rem rgba(138, 43, 226, 0.25);
}

.form-check-input:checked {
    background-color: #8A2BE2;
}
</style>
@endsection