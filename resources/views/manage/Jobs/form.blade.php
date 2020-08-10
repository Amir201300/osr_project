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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">الوظيفه</label>
                                            <input type="text" id="name" name="name" required class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">صورة الوظيفه</label>
                                            <input type="file" id="image" name="image"  class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">رابط الوظيفه</label>
                                            <input type="text" id="link" name="link" required class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">البريد الالكتروني</label>
                                            <input type="text" id="email" name="email"  class="form-control"   >
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">الهاتف</label>
                                            <input type="text" id="phone" name="phone" class="form-control"   >
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">الراتب</label>
                                            <input type="text" id="salary" name="salary" required class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">المدينه</label>
                                            <select  id="city_id" name="city_id"  class="form-control"   required>
                                                @foreach($cities as $row)
                                                    <option value="{{$row->id}}"> {{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                     </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-email">نوع الوظيفه</label>
                                            <select  id="job_type" name="job_type"  class="form-control"   >
                                                <option value="1"> دوام كلي</option>
                                                <option value="2">دوام جزئي</option>
                                                <option value="3">تدريب</option>
                                                <option value="4">عمل تطوعي</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-email">الوصف</label>
                                            <textarea id="desc" name="desc" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div id="err"></div>
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
