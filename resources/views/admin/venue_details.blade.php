@extends('layouts.app')

@section('content')
<div id="wrapper">
    @if (!empty($venue_id))
    <input type="hidden" name="venue_id" value="{{$venue_id}}">
    @endif
    <div id="content-wrapper">

        <aside id="sidebar-wrapper">
            <div class="image_with_bottom_shadow  text-center m-3" style="max-height: 18rem; overflow-y:hidden">
                <img alt="img" class="img-fluid" id="venue_image1"/>                                
                <div class="mt-3 h4 fw-bold"><span id="venue_name1"></span></div>                                
            </div>
            <ul class="sidebar-nav" id="myTab" role="tablist">
                <li class="active nav-item" id="details-tab" data-bs-toggle="tab" data-bs-target="#details">
                    <div class="p-3 text-center text-nowrap">Details</div>
                </li>
                <li class="nav-item" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos">
                    <div class="p-3 text-center text-nowrap">Photos</div>
                </li>
                <li class="nav-item" id="packages-tab" data-bs-toggle="tab" data-bs-target="#packages">
                    <div class="p-3 text-center text-nowrap">Packages</div>
                </li>
                <li class="nav-item" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews">
                    <div class="p-3 text-center text-nowrap">Reviews</div>
                </li>
            </ul>
        </aside>

        <section id="content-wrapper">
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="home-tab">
                    <div id="details">
                        <div class="image_with_bottom_shadow w-100 text-center" style="max-height: 18rem; overflow-y:hidden">
                            <img alt="img" class="img-fluid" id="venue_image"/>        
                            <div class=" image_with_bottom_shadow__text"><span id="venue_name"></span> (<span id="venue_rating"></span> <i class="text-warning fa-solid fa-star"></i>)</div>                                
                        </div>
                    
                          <div class="venue-detail-body">
                            <div class="row">
                              <div class="col-6">
                                <br>
                                <div class="h5"><i class="fa-solid fa-location-dot"> </i> <span id="address"></span></div>            
                                <div class="mt-3 h5">Type - <span id="type"></span></div>
                                <div class="mt-3 h5">Email - <span id="email"></span> <i class="fa-solid fa-envelope"></i> </div>            
                                <div class="mt-3 h5">Phone - <span id="phone"></span> <i class="fa-solid fa-phone"></i> </div>
                                <div class="mt-3 h5">Total Capacity - <span id="total_capacity"><i class="fas fa-user"></i></span></div>                                                                    
                              </div>  
                    
                                <div class="col-6">
                                  {{-- <div class="col-7"> --}}
                                    <div class="mt-3 h5">Parking Capacity - <span id="parking_capacity"></span> <i class="fa-solid fa-car"></i> </div>            
                                    <div class="mt-3 h5 fw-bold">Cuisines  </span><i class="fas fa-utensils"></i> <span id="cuisines"></div>              
                                    <div class="mt-3">
                                        <span class="h5 fw-bold" style="cursor: pointer" id="timming_info" data-bs-trigger="hover" data-bs-toggle="popover" title="Timmings Information" data-bs-html="true" data-bs-content="">Timmings Info <i class="fa-solid fa-clock"></i></span>
                                    </div>                                          
                                    <div class="mt-3 h5 col-12" id="additional_feature"></div>
                                  {{-- </div>                                          --}}
                                </div>
                                
                            </div>
                          </div>
                    </div>
                </div>
               
                <div class="tab-pane fade " id="photos" role="tabpanel" aria-labelledby="profile-tab">
                    <div id="secondary_image" class="row"> 
                        {{-- add image dynamically using ajax --}}
                    </div>                    
                </div>

                <div class="tab-pane fade " id="packages" role="tabpanel" aria-labelledby="contact-tab">                    
                    @include('components.venue_packages', ['venue_id' => $venue_id]) 
                </div>

                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="contact-tab">Reviews</div>
            </div>
        </section>
    </div>
</div>
<script>

$(document).ready(function() {

//  let venue_id="2";
 @if(!empty($venue_id))

        let venue_id = "{{$venue_id}}";
        $.ajax({
            url: "{{ route('fetch_venue_details_page') }}",
            type: "GET",
            data: { venue_id },
            success: function(res_data) {
                let venue_data=res_data;
                $("#venue_image").attr('src', venue_data.image_src);
                $("#venue_image1").attr('src', venue_data.image_src);
                $("#venue_name").html(venue_data.name);
                $("#venue_name1").html(venue_data.name);
                $("#venue_rating").html(venue_data.venue_rating);
                let address = venue_data.address;
                if(venue_data.gmap_location)
            {
                address += ` <a href="${venue_data.gmap_location}" data-bs-toggle="tooltip" title="Open in Google Maps" target="_BLANK"><i class="text-success fa-solid fa-map-location-dot"></i></a>`;
            }                
            $("#address").html(address);            

                $("#type").html(venue_data.type);
                $("#email").html(venue_data.contact_email);
                $("#phone").html(venue_data.contact_phone);
                $("#total_capacity").html(venue_data.total_capacity);
                $("#parking_capacity").html(venue_data.parking_capacity);
                
            let cuisines = venue_data.cuisines;
            if(Object.keys(cuisines).length > 0)
            {
                let cuisines_details = '';

                    for(let dish of cuisines)
                    {
                        cuisines_details += `<div class="mb-1 h5">${dish}</div>`;
                    }                

                $("#cuisines").html(cuisines_details);
            }                            
                        
            
                
            let timming_info_str = '<div class="row">';            
            for(let day in venue_data.timmings)
            {
                timming_info_str += `<div class="col-4 text-center text-nowrap">${toTitleCase(day)}</div><div class="col-1">-</div><div class="col-6">${venue_data.timmings[day]['from']} to ${venue_data.timmings[day]['to']}</div>`;
            }
            timming_info_str += '</div>';

            $("#timming_info").attr("data-bs-content", timming_info_str);
            initialize_all_tooltips_popovers();


                
            let features = '<div class="row">';
            let additional_details = venue_data.additional_features;
            if(additional_details.length > 0)
                {
                   for(let index = 0;index < additional_details.length; index++)
                       {
                           features += `<div class="col-6"><i class="text-warning fa-solid fa-bolt"></i> ${additional_details[index]}</div>`;
                        }
                }
            features += `</div>`;
            $("#additional_feature").html(features);                                                        

            
            
            var path1 = '';
            for (let sec_img of venue_data.secondary_pictures) {
                    path1 += `<div class="col-6 mt-3" style="width: 18rem;"><img alt="img"  style="height: 30vh;" class="card-img-top img-fluid" src="${sec_img.path}"/> </div>`;                                                                                
                    console.log(sec_img.path);                    
                }                
            $('#secondary_image').html(path1);


            
            },
            error: function(res_data) {}
        });
    });
    @endif   
    
</script>      
@endsection