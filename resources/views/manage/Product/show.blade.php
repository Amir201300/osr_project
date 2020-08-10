<div class="modal fade" id="showData" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt m-r-10"></i> {{trans('main.ShowData')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6 showDetilse">
                            <h5><i class="fa fa-check"></i>الاسم</h5>
                            <p class="name_ar valueModal" id="nameShow"></p>
                        </div>
                        <div class="col-md-6 showDetilse">
                            <h5><span class="btn-label"><i class="fas fa-dollar-sign"></i></span> السعر</h5>
                            <p class="name_en valueModal" id="priceShow"></p>
                        </div>
                        <div class="col-md-6 showDetilse">
                            <h5><i class="fas fa-star"></i>عدد التقييمات</h5>
                            <p class="main valueModal" id="rateNum"></p>
                        </div>
                        <div class="col-md-6 showDetilse">
                            <h5><i class="fas fa-image"></i>عدد الصور</h5>
                            <p class="status valueModal" id="imageNum"></p>
                        </div>

                        <div class="col-md-6 showDetilse">
                            <h5><i class="fas fa-check"></i>حالة التوصيل</h5>
                            <p class="status valueModal" id="deliveryShow"></p>
                        </div>

                        <div class="col-md-6 showDetilse">
                            <h5><i class="fas fa-check"></i>التمييز</h5>
                            <p class="status valueModal" id="specialShow"></p>
                        </div>

                        <div class="col-md-6 showDetilse">
                            <h5><i class="fas fa-eye"></i>عدد المشاهدات</h5>
                            <p class="city_id valueModal" id="view"></p>
                        </div>

                        <div class="col-md-6 showDetilse">
                            <h5><i class="fas fa-calendar"></i>تم الانشاء في :</h5>
                            <p class="valueModal" id="created_at"></p>
                        </div>

                        <div class="col-md-12 showDetilse">
                            <h5><i class="fas fa-pencil-alt"></i>الوصف</h5>
                            <textarea class="updated_by valueModal" readonly id="descShow" style="width: 100%"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('main.close')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

