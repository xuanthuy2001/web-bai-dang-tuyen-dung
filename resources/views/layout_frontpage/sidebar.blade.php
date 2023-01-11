
<div class="col-md-3">
    <div class="card card-refine card-plain">
        <div class="card-content">
            <h4 class="card-title">
              {{__('frontpage.reset')}}
                <button class="btn btn-default btn-fab btn-fab-mini btn-simple pull-right" rel="tooltip" title="Reset Filter">
                    <i class="material-icons">cached</i>
                </button>
            </h4>
            <div class="panel panel-default panel-rose">
                <div class="panel-heading" role="tab" id="headingOne">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <h4 class="panel-title">{{__('frontpage.salary')}}</h4>
                        <i class="material-icons">keyboard_arrow_down</i>
                    </a>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body panel-refine">
                        <span id="price-left" class="price-left pull-left" data-currency="&euro;">100</span>
                        <span id="price-right" class="price-right pull-right" data-currency="&euro;">850</span>
                        <div class="clearfix"></div>
                        <div id="sliderRefine" class="slider slider-rose"></div>
                    </div>
                </div>
            </div>


            <div class="panel panel-default panel-rose">
                <div class="panel-heading" role="tab" id="headingThree">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4 class="panel-title">Designer</h4>
                        <i class="material-icons">keyboard_arrow_down</i>
                    </a>
                </div>
                <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="" data-toggle="checkbox" checked="">
                                All
                            </label>
                        </div>

                    </div>
                </div>
            </div>
  </div>
    </div><!-- end card -->
</div>
