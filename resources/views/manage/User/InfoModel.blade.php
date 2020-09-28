<div class="modal fade bd-example-modal-lg" id="InfoModel" tabindex="-1" role="dialog"
     aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="InfoForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="title"><i class="ti-marker-alt m-r-10"></i> معلومات المتجر </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">الفيسبوك</label>
                                <input type="text" id="facebook"  name="facebook" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">رقم الواتساب</label>
                                <input type="text" id="whatsapp"  name="whatsapp" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">اليوتيوب</label>
                                <input type="text" id="youtube"  name="youtube" class="form-control">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">تويتر</label>
                                <input type="text" id="twitter"  name="twitter" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">سناب شات</label>
                                <input type="text" id="snap"  name="snap" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">انستجرام</label>
                                <input type="text" id="instagram"  name="instagram" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-email">صورة الغلاف</label>
                                <input type="file" id="cover_photo"  name="cover_photo" class="form-control">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <a href="" target="_blank" id="coverLink">
                            <img  id="cover_photoImage" width="60" height="50" style="margin-top: 20px">
                            </a>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-email">عن المتجر</label>
                                <textarea  id="about_info"  name="about_info" class="form-control">
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
                    <div id="errInfo" style="color: red"></div>
                    <input type="hidden" name="id" id="idUser">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{trans('main.close')}}</button>
                        <button type="submit" id="saveInfo" class="btn btn-success"><i
                                class="ti-save"></i> تعديل</button>
                    </div>
            </form>
        </div>
    </div>
</div>

