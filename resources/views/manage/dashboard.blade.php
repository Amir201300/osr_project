
@extends('layouts.manage')
@section('title')
{{ trans('main.home') }}
@endsection

@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Welcome back  -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card  bg-light no-card-border">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <img src="{{ App\Models\basic\Basic::getImage() }}" alt="user" width="60" class="rounded-circle" />
                                </div>
                                <div>
                                    <h3 class="m-b-0">{{trans('main.welcome')}}</h3>
                                    <span>{{date('D , d M Y', strtotime(Carbon\Carbon::now()))}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Sales Summery -->
            <!-- ============================================================== -->
                @include('include.home.counts')
            <!-- ============================================================== -->
            <!-- place order / Exchange -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- project of the month -->
            <!-- ============================================================== -->
            @include('include.home.last_stores')
            <!-- ============================================================== -->
            <!-- Task, Feeds -->
            <!-- ============================================================== -->
            @include('include.home.section_2')
            @include('include.home.reviews')
        </div>
        <!-- ============================================================== -->
        <!-- Trade history / Exchange -->
        <!-- ============================================================== -->
    </div>
@endsection
