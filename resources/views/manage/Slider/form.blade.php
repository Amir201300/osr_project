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
                                            <label for="example-email">الرابط</label>
                                            <input type="text" id="link" name="link" required class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">صورة الاعلان</label>
                                            <input type="file" id="image" name="image"  class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">ترتيب عرض الاعلان</label>
                                            <input type="number" id="order" name="order"  class="form-control"   >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">تاريخ البداية</label>
                                            <input type="date" id="start_date" name="start_date" required class="form-control"   >
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-email">تاريخ الانتهاء</label>
                                            <input type="date" id="expire_date" name="expire_date" required class="form-control"   >
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
