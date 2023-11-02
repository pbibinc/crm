@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                @foreach ($userProfiles as $userProfile)
                    <div class="col-lg-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <img class="d-flex me-3 rounded-circle img-thumbnail avatar-lg"
                                        src="{{ asset($userProfile->media->filepath) }}" alt="Generic placeholder image">
                                    <div class="flex-grow-1">
                                        @php
                                            $ratings = $userProfile->ratings;
                                            $numberOfRatings = $ratings->count();
                                            $sumOfRatings = $ratings->sum('rating');
                                            $divisorRatings = $numberOfRatings * 5;
                                            $overallRating = $numberOfRatings > 0 ? $sumOfRatings / $numberOfRatings : 0;
                                            $overallRatingPercentage = $numberOfRatings > 0 ? ($sumOfRatings / $divisorRatings) * 100 : 0;
                                        @endphp
                                        <h5 class="mt-0 font-size-18 mb-1">
                                            {{ $userProfile->firstname . ' ' . $userProfile->american_surname }}</h5>
                                        <p class="text-muted font-size-14">{{ $userProfile->position->name }}</p>
                                        <ul class="social-links list-inline mb-0">
                                            {{-- <li>
                                        <input type="hidden" class="rating-tooltip" value={{ $overallRating }} data-filled="mdi mdi-star text-primary" data-empty="mdi mdi-star-outline text-muted" disabled="disabled"/>
                                    </li> --}}
                                            <li class="list-inline-item">
                                                <a role="button" class="text-reset"
                                                    title="{{ $userProfile->streams_number }}" data-bs-placement="top"
                                                    data-bs-toggle="tooltip" class="tooltips" href=""><i
                                                        class="fas fa-phone-alt"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a role="button" class="text-reset"
                                                    title="{{ $userProfile->skype_profile }}" data-bs-placement="top"
                                                    data-bs-toggle="tooltip" class="tooltips" href=""><i
                                                        class="fab fa-skype"></i></a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                @endforeach
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/assets/libs/bootstrap-rating/bootstrap-rating.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pages/rating-init.js') }}"></script>
@endsection
