<!-- resources/views/jobs/show.blade.php -->
@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Sol Taraf - İlan Detayı -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="h3 mb-2">{{ $job->position }}</h1>
                            <h2 class="h5 text-purple mb-3">{{ $job->company }}</h2>
                            <div class="text-muted">
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
                                    {{ $job->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            @if(Auth::check())
                                @if($hasApplied)
                                    <button class="btn btn-success" disabled>
                                        <i class="fas fa-check me-1"></i> Başvuruldu
                                    </button>
                                @else
                                    <form action="{{ route('jobs.apply', $job->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-purple">Başvur</button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-purple">Başvur</a>
                            @endif
                            <button class="btn btn-outline-purple">
                                <i class="fas fa-share-alt"></i>
                            </button>
                            <button class="btn btn-outline-purple">
                                <i class="far fa-bookmark"></i>
                            </button>
                        </div>
                    </div>

                    <!-- İlan Detayları -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-muted">Çalışma Tercihi</label>
                                <div>{{ $workingPreferenceLabels[$job->working_preference] ?? $job->working_preference }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-muted">Lokasyon</label>
                                <div>{{ $job->city }}@if($job->town), {{ $job->town }}@endif</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-muted">Başvuru Sayısı</label>
                                <div>{{ $applicationCount }} başvuru</div>
                            </div>
                        </div>
                    </div>

                    <!-- İlan İçeriği -->
                    <div class="mb-4">
                        <h5 class="mb-3">İş Tanımı</h5>
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sağ Taraf - Benzer İlanlar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">İlgini Çekebilecek İlanlar</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedJobs as $relatedJob)
                        <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="img-wrapper">
                                            <img src="{{ $job->images ?? $job->randomImage() }}" class="job-img" alt="{{ $job->company }}">
                                        </div>                                 class="rounded me-3" style="width: 48px; height: 48px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $relatedJob->position }}</h6>
                                <div class="small text-muted">{{ $relatedJob->company }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i> 
                                    {{ $relatedJob->city }}@if($relatedJob->town), {{ $relatedJob->town }}@endif
                                </div>
                            </div>
                            <a href="{{ route('jobs.show', $relatedJob->id) }}" class="btn btn-sm btn-outline-purple">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.btn-purple {
    background-color: #8A2BE2;
    border-color: #8A2BE2;
    color: white;
}

.btn-purple:hover {
    background-color: #7525C5;
    border-color: #7525C5;
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
</style>
@endsection