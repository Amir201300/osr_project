<div class="modal fade bd-example-modal-lg" id="formModel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="formSubmit">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="title"><i class="ti-marker-alt m-r-10"></i> Add new </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">

<<<<<<< HEAD
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">اسم العضو</label>
                                            <input type="text" id="name" required name="name"  class="form-control"   >
=======
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">اسم العضو</label>
                                            <input type="text" id="name" required name="name"  class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">البريد الالكتروني</label>
                                            <input type="text" id="price" required name="price"  class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">المدينة</label>
                                            <select  id="cat_id" name="cat_id"  required class="form-control"   >
                                                @foreach($city as $row)
                                                <option value="{{$row->id}}"> {{$row->name}}</option>
                                                    @endforeach
                                            </select>
>>>>>>> c6bb89442de12201368e2167143ad35aea917b15
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
<<<<<<< HEAD
                                            <label for="example-email">الهاتف</label>
                                            <input type="text" id="phone" required name="phone"  class="form-control"   >
=======
                                            <label for="example-email">المنطقة</label>
                                            <select  id="user_id" name="user_id"  required class="form-control"   >
                                                @foreach($users as $row)
                                                    <option value="{{$row->id}}"> {{$row->name}}</option>
                                                @endforeach
                                            </select>
>>>>>>> c6bb89442de12201368e2167143ad35aea917b15
                                        </div>
                                    </div>

                                    <div class="col-md-4">
<<<<<<< HEAD
                                            <div class="form-group">
                                                <label for="example-email">البريد الالكتروني</label>
                                                <input type="text" id="email" required name="email"  class="form-control"   >
                                            </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">المدينه</label>
                                            <select  id="city_id" name="city_id"  required class="form-control"   >
                                                @foreach($city as $row)
                                                <option value="{{$row->id}}"> {{$row->name}}</option>
                                                    @endforeach
=======
                                        <div class="form-group">
                                            <label for="example-email">الصورة </label>
                                            <input type="file" id="image"  name="image"  class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">نوع العضو</label>
                                            <select  id="delivery" name="delivery"  class="form-control"   >
                                                <option value="1"> عضو</option>
                                                <option value="2"> متجر</option>
                                                <option value="3"> مندوب</option>
>>>>>>> c6bb89442de12201368e2167143ad35aea917b15
                                            </select>
                                        </div>
                                    </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="example-email">المنطقه</label>
                                                <select  id="area_id" name="area_id"  required class="form-control"   >
                                                    @foreach($area as $row)
                                                        <option value="{{$row->id}}"> {{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="example-email">حالة التفعيل</label>
                                                <select  id="status" name="status"  class="form-control"   >
                                                    <option value="1"> مفعل</option>
                                                    <option value="0"> غير مفعل</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="example-email">نوع العضو</label>
                                                <select  id="user_type" name="user_type"  class="form-control"   >
                                                    <option value="1">عضو</option>
                                                    <option value="2">متجر</option>
                                                    <option value="3">مندوب</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="example-email">صورة العضو</label>
                                                <input type="file" id="image" name="image"  class="form-control"   >
                                            </div>

                                </div>
                            </div>
                            <div id="errorText" style="color: red"></div>
                            <input type="hidden" name="id" id="id">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"  data-dismiss="modal">{{trans('main.close')}}</button>
                                <button type="submit" id="save" class="btn btn-success"><i class="ti-save"></i> {{trans('main.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



























            <div class="modal fade bd-example-modal-lg" id="FacilityModel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="faSubmit">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="title"><i class="ti-marker-alt m-r-10"></i> Add new </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row" id="fa">
               
                            
                                </div>
                            </div>
                            <div id="err"></div>
                            <input type="hidden" name="shop_id" id="shop_id2">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('main.close')}}</button>
                                <button type="submit" class="btn btn-success"><i class="ti-save"></i> {{trans('main.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
