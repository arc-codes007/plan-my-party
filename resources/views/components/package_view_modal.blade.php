<div class="modal" tabindex="-1" id="package_view_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header m-0 p-0">
          <div class="image_with_bottom_shadow w-100 text-center" style="max-height: 18rem; overflow-y:hidden">
            <img alt="img" class="img-fluid" id="pkg_modal_package_image"/>
            <div class="image_with_bottom_shadow__text"><span id="pkg_modal_package_name"></span> <span class="h4" id="pkg_modal_package_rating"></span></div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="top: 5%;right: 5%;position: absolute; z-index:3"></button>
          </div>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-7">
                <div class="mt-3 h4"><span id="pkg_modal_venue_name"></span> (<span id="pkg_modal_venue_rating"></span> <i class="text-warning fa-solid fa-star"></i>)</div>
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

<div class="modal" tabindex="-1" id="pkg_modal_package_reviews">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reviews</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="row" id="pkg_modal_package_reviews_container">

          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

  function open_package_reviews_modal(package_id)
  {
      $.ajax({
        url: "{{ route('fetch_package_reviews') }}",
        type: "GET",
        data: {package_id},
        success: function(res_data) {
          let package_reviews = res_data.package_reviews;
          for(let review_html of package_reviews)
          {
            $("#pkg_modal_package_reviews_container").append("<div class='col-12 my-2'>"+review_html+"</div>");
          }

          var pkg_modal_package_reviews = new bootstrap.Modal(document.getElementById('pkg_modal_package_reviews'));
          pkg_modal_package_reviews.show();

        },
        error: function(res_data) {
        }
    });
  }

  $(document).ready(function(){
    $("#pkg_modal_book_party").click(function(){
        create_party($("#pkg_modal_book_party").attr('package_id'), 'package', "{{route('create_party')}}");
    });
  });
</script>