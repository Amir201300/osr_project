<div class="row">
    <!-- column -->
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">اخر المنتجات</h4>
                <div class="feed-widget scrollable" style="height:450px;">
                    <ul class="list-style-none feed-body m-0 p-b-20">
                        @foreach(getProducts(2,7) as $row)
                        <li class="feed-item">
                            <div class="feed-icon">
                                <img src="{{getImageUrl('Product_images',productImage($row))}}" width="30" height="30">
                            </div>
                            <a href="">{{$row->name}}.</a>
                            <span class="ml-auto font-12 text-muted">{{ $row->created_at->format('d M') }}</span>
                        </li>
                            @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- column -->
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">اخر الاعضاء المسجلين</h4>
                <div class="feed-widget scrollable" style="height:450px;">
                    <ul class="list-style-none feed-body m-0 p-b-20">
                        @foreach(get_user(1,7) as $row)
                            <li class="feed-item">
                                <div class="feed-icon">
                                    <img src="{{getImageUrl('Users',$row->image)}}" width="30" height="30">
                                </div>
                                <a style=" cursor: pointer" onclick="UserInfo('{{$row->id}}')">{{$row->name}}.</a>
                                <span class="ml-auto font-12 text-muted">{{ $row->created_at->format('d M') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
