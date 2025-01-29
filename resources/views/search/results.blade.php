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
                            <select class="form-select mb-2" name="country">
                                <option value="">Ülke Seçin</option>
                                <option value="Türkiye" {{ request('country') == 'Türkiye' ? 'selected' : '' }}>Türkiye</option>
                            </select>
                            <select class="form-select" name="city">
                                <option value="">Şehir Seçin</option>
                                <!-- Şehirler AJAX ile yüklenebilir -->
                            </select>
                        </div>

                        <!-- Çalışma Tercihi -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Çalışma Tercihi</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="working_preference[]" value="remote" id="remote"
                                    {{ in_array('remote', (array)request('working_preference')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="remote">Uzaktan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="working_preference[]" value="on-site" id="on-site"
                                    {{ in_array('on-site', (array)request('working_preference')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="on-site">İş Yerinde</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="working_preference[]" value="hybrid" id="hybrid"
                                    {{ in_array('hybrid', (array)request('working_preference')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hybrid">Hibrit</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Filtrele</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sağ Taraf - Sonuçlar -->
        <div class="col-lg-9">
            <!-- Aktif Filtreler -->
            @if(request()->anyFilled(['position', 'city', 'working_preference']))
                <div class="d-flex align-items-center mb-3 flex-wrap">
                    <span class="me-2">Seçili Filtreler:</span>
                    @if(request('position'))
                        <span class="badge bg-light text-dark me-2 mb-2">
                            Pozisyon/Şirket: {{ request('position') }}
                            <a href="{{ request()->except('position') }}" class="text-dark text-decoration-none ms-1">&times;</a>
                        </span>
                    @endif
                    @if(request('city'))
                        <span class="badge bg-light text-dark me-2 mb-2">
                            Şehir: {{ request('city') }}
                            <a href="{{ request()->except('city') }}" class="text-dark text-decoration-none ms-1">&times;</a>
                        </span>
                    @endif
                    @if(request('working_preference'))
                        @foreach((array)request('working_preference') as $pref)
                            <span class="badge bg-light text-dark me-2 mb-2">
                                {{ ucfirst($pref) }}
                                <a href="#" class="text-dark text-decoration-none ms-1 remove-preference" data-preference="{{ $pref }}">&times;</a>
                            </span>
                        @endforeach
                    @endif
                    <a href="{{ route('search.results') }}" class="btn btn-sm btn-outline-secondary mb-2">Filtreleri Temizle</a>
                </div>
            @endif

            <!-- Sonuç Sayısı ve Sıralama -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="mb-0">{{ $jobs->total() }} ilan bulundu</p>
                <select class="form-select" style="width: auto;" onchange="window.location.href=this.value">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" 
                            {{ request('sort') == 'newest' ? 'selected' : '' }}>En Yeni</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}"
                            {{ request('sort') == 'oldest' ? 'selected' : '' }}>En Eski</option>
                </select>
            </div>

            <!-- İş İlanları -->
            @forelse($jobs as $job)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ $job->randomImage() }}" alt="{{ $job->company }}" 
                                     class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="col">
                                <h5 class="card-title mb-1">{{ $job->position }}</h5>
                                <h6 class="text-primary mb-2">{{ $job->company }}</h6>
                                <div class="d-flex flex-wrap text-muted small">
                                    <span class="me-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $job->city }}@if($job->town), {{ $job->town }}@endif
                                    </span>
                                    <span class="me-3">
                                        <i class="fas fa-building me-1"></i>
                                        {{ ucfirst($job->working_preference) }}
                                    </span>
                                    <span>
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $job->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-outline-primary">Detayları Gör</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Arama kriterlerinize uygun ilan bulunamadı.
                </div>
            @endforelse

            <!-- Pagination -->
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
    // Filtreleri otomatik submit et
    $('.form-check-input').change(function() {
        $('#filter-form').submit();
    });

    // Çalışma tercihini kaldır
    $('.remove-preference').click(function(e) {
        e.preventDefault();
        let preference = $(this).data('preference');
        let preferences = @json((array)request('working_preference'));
        preferences = preferences.filter(p => p !== preference);
        
        let url = new URL(window.location.href);
        url.searchParams.delete('working_preference[]');
        preferences.forEach(p => url.searchParams.append('working_preference[]', p));
        
        window.location.href = url.toString();
    });
});
</script>
@endsection