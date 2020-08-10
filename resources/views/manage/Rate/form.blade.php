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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">اسم المنتج</label>
                                            <input type="text" id="name" required name="name"  class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">السعر</label>
                                            <input type="text" id="price" required name="price"  class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">القسم</label>
                                            <select  id="cat_id" name="cat_id"  required class="form-control"   >
                                                @foreach($cat as $row)
                                                <option value="{{$row->id}}"> {{$row->name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">المتجر</label>
                                            <select  id="user_id" name="user_id"  required class="form-control"   >
                                                @foreach($users as $row)
                                                    <option value="{{$row->id}}"> {{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">الصور (الحد الاقصى هو ثلاث صور)</label>
                                            <input type="file" id="image"  name="image[]" multiple  class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">توصيل الطلبات</label>
                                            <select  id="delivery" name="delivery"  class="form-control"   >
                                                <option value="1"> يوصل</option>
                                                <option value="0"> لا يوصل</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">حالة التمييز</label>
                                            <select  id="special" name="special"  class="form-control"   >
                                                <option value="1"> مميز</option>
                                                <option value="0"> غير مميز</option>
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

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-email">عن المنتج</label>
                                            <textarea  id="desc"  name="desc"  class="form-control"   >
                                            </textarea>
                                        </div>
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
