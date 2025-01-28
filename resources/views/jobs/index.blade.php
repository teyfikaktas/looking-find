<!-- resources/views/jobs/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Job Listings') }}</h1>

    <!-- Arama Formu -->
    <form method="GET" action="{{ route('home') }}" class="mb-4">
        <div class="row">
            <div class="col-md-5">
                <input type="text" name="position" class="form-control" placeholder="{{ __('Position') }}" value="{{ request('position') }}" id="position-autocomplete">
            </div>
            <div class="col-md-5">
                <input type="text" name="city" class="form-control" placeholder="{{ __('City') }}" value="{{ request('city') }}" id="city-autocomplete">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">{{ __('Search') }}</button>
            </div>
        </div>
    </form>

    <!-- İş İlanları Listesi -->
    <div>
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

@section('scripts')
<script>
    // Pozisyon autocomplete
    $('#position-autocomplete').autocomplete({
        source: "{{ route('autocomplete.positions') }}",
        minLength: 2,
    });

    // Şehir autocomplete
    $('#city-autocomplete').autocomplete({
        source: "{{ route('autocomplete.cities') }}",
        minLength: 2,
    });
</script>
@endsection
