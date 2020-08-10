@extends('layouts.manage')

@section('title')
    الاعضاء
@endsection

@section('content')

    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
                    <h4 class="page-title">{{trans('main.home')}}</h4>
                    <div class="d-flex align-items-center">

                    </div>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.dashboard')}}">{{trans('main.home')}}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">الاعضاء</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- basic table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center m-b-30">
                                <h4 class="card-title">الاعضاء</h4>
                                <div class="ml-auto">
                                    <div class="btn-group">
                                        <button type="button" id="showmenu" class="btn btn-dark fillterNew">
                                            <i class="fas fa-filter"></i>
                                        </button>
                                        <button  class="btn btn-dark " data-toggle="modal" onclick="addFunction()">
                                            اضافة عضو جديد
                                        </button>
                                        &nbsp;
                                        <button  class="btn btn-danger " data-toggle="modal" onclick="deleteFunction(0,2)">
                                            {{trans('main.deleteSpecified')}}
                                        </button>

                                    </div>

                                </div>

                            </div>
                            <h6 class="card-subtitle"></h6>
                            <div class="menuFilter" style="display: none;">
                                <form id="seachForm">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="status" class="custom-select mr-sm-2"  id="inline">
                                                    <option value="">حالة التفعيل</option>
                                                    <option value="1">مفعل</option>
                                                    <option value="0">غير مفعل</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="city_id" class="custom-select mr-sm-2"  id="inlineFormCustomSelect">
                                                    <option value="">المدينة</option>
                                                    @foreach($city as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if(!$user_type)
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="user_type" class="custom-select mr-sm-2"  id="user_type">
                                                    <option value="">النوع</option>
                                                    <option value="1">عضو</option>
                                                    <option value="2">متجر</option>
                                                    <option value="3">مندوب</option>
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="dataFilter" class="custom-select mr-sm-2"  id="dateF">
                                                    <option value="">الوقت</option>
                                                    <option value="1">اليوم</option>
                                                    <option value="2">الشهر</option>
                                                    <option value="3">السنة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-1">
                                            <div class="form-actions">
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-info">{{trans('main.search')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive" style="overflow: hidden;">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="sorting_asc" tabindex="0" aria-controls="file_export" rowspan="1" colspan="1" aria-sort="ascending" aria-label=" : activate to sort column descending" style="width: 0px;"> </th>
                                        <th>#</th>
                                        <th>الصورة</th>
                                        <th>الاسم</th>
                                        <th>نوع العضو</th>
                                        <th>المدينة</th>
                                        <th> المنطقة</th>
                                        <th>حالة التفعيل </th>
                                        <th>الاختيارات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>

        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
    @include('manage.User.form')
    <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#showmenu').click(function() {
                $('.menuFilter').toggle("slide");
            });
        });
    </script>
    <script src="/manage/assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="/manage/dist/js/pages/datatable/datatable-basic.init.js"></script>
    @include('manage.User.script')

@endsection
