<div class="modal" tabindex="-1" id="package_view_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header m-0 p-0">
          <div class="image_with_bottom_shadow w-100 text-center" style="max-height: 18rem; overflow-y:hidden">
            <img alt="img" class="img-fluid" id="pkg_modal_package_image"/>
            <div class="image_with_bottom_shadow__text" id="pkg_modal_package_name"></div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="top: 5%;right: 5%;position: absolute; z-index:3"></button>
          </div>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-7">
                <div class="mt-3 h4"><span id="pkg_modal_venue_name"></span> (<span id="venue_rating"></span> <i class="text-warning fa-solid fa-star"></i>)</div>
                <div class="h5"><i class="fa-solid fa-location-dot"></i> <span id="pkg_modal_address"></span></div>
                <div class="mt-5 h5">Pricing - <span id="pkg_modal_pricing"></span> <i class="fa-solid fa-tags"></i></div>
                <div class="mt-3 h5"><span class="me-3">Min Person(s) - <span id="pkg_modal_min_persons"></span></span><span class="ms-3">Max Persons - <span id="pkg_modal_max_persons"></span></span></div>
                <div class="mt-3 h5">Sitting Type - <span id="pkg_modal_sitting_type"></span></div>
                <div class="mt-3">
                  <span class="h5 fw-bold" style="cursor: pointer" id="pkg_modal_timming_info" data-bs-trigger="hover" data-bs-toggle="popover" title="Timmings Information" data-bs-html="true" data-bs-content="">Timmings Info <i class="fa-solid fa-clock"></i></span>
                </div>

                <div class="mt-3 h5" id="pkg_modal_additional_feature"></div>
              </div>
              <div class="col-5" id="pkg_modal_menu_area" style="display: none">
                <div class="menu_background h-100">
                  <div class="text-center text-decoration-underline h2">MENU</div>
                  <div id="pkg_modal_menu_content" class="mt-3 text-center">

                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
          @guest
            <a href="{{route('login')}}" class="btn btn-lg btn-primary text-white">Book Now</a>          
          @else
            <a href="javascript:void()" id="pkg_modal_book_party" package_id="" class="btn btn-lg btn-primary text-white">Book Now</a>          
          @endguest
        </div>
      </div>
    </div>
</div>

<script>
  $(document).ready(function(){
    $("#pkg_modal_book_party").click(function(){
        create_party($("#pkg_modal_book_party").attr('package_id'), 'package', "{{route('create_party')}}");
    });
  });
</script>