@extends('admin.master')
@section('dashboard')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sections</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $exercise }}</span>
                                    <span class="label">Exercises</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- c2 -->
                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $workout }}</span>
                                    <span class="label">Workouts</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- c3 -->
                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $bodyPart }}</span>
                                    <span class="label">Bodyparts</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- c4 -->
                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $equipment }}</span>
                                    <span class="label">Equipments</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row2 -->
            <div class="row">
                <!-- c1 -->
                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $levels }}</span>
                                    <span class="label">Levels</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- c2 -->
                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $goals }}</span>
                                    <span class="label">Goals</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- c3 -->
                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $recipes }}</span>
                                    <span class="label">Recipes</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- c4 -->
                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $posts }}</span>
                                    <span class="label">Posts</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $measurementUnits }}</span>
                                    <span class="label">Measurement Units</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $foodExchanges }}</span>
                                    <span class="label">Food Exchanges</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $tips }}</span>
                                    <span class="label">Tip Of The Day</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card" style="border-radius: 14px;">
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg value">{{ $customers }}</span>
                                    <span class="label">Customers</span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
