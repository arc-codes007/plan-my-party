<div class="container">
    <div class="row">
        <h1 class="text-danger">Packages</h1>
    </div>
</div>

<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-inner" id="packages_carousel_items">
        {{-- packages are dynamically loaded here through ajax --}}
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>

<script>

$(document).ready(function()
{
    $.ajax({
            url: "{{ route('fetch_all_packages_data') }}",
            type: "GET",
            success: function(response) {
                let packages = response.packages;
                let item_count = Math.ceil(packages.length/2);
                let package_index = 0;

                let package_html_str = '';

                for(let i = 0; i < item_count; ++i)
                {
                    package_html_str += `<div class="carousel-item ${(i == 0) ? 'active' : ''}" data-bs-interval="10000">`
                                        + `<div class="container pb-5">`
                                            + `<div class="row">`;
                    
                    for(let j = 0; j < 2; ++j)
                    {
                        if(packages[package_index])
                        {
                            let features = '<div class="row">';

                            let total_features = 4;
                            let additional_features = packages[package_index].additional_features;
                            if(additional_features.length < 4)
                            {
                                total_features = additional_features.length;
                            }
                            
                            if(packages[package_index].parking_available)
                            {
                                features += `<div class="col-6"><i class="text-warning fa-solid fa-square-parking"></i> Parking Available</div>`;

                                if(total_features >= 4)
                                {
                                    total_features = 3;
                                }
                            }

                            if(additional_features.length > 0)
                            {
                                for(let additional_features_index = 0;additional_features_index < total_features; additional_features_index++)
                                {
                                    features += `<div class="col-6"><i class="text-warning fa-solid fa-bolt"></i> ${additional_features[additional_features_index]}</div>`;
                                }
                            }
                            features += `</div>`;

                            let map_link = '';
                            if(packages[package_index].gmap_link)
                            {
                                map_link = `<a href="${packages[package_index].gmap_link}" target="_BLANK"><i class="text-success fa-solid fa-map-location-dot"></i></a>`;
                            }
                            package_html_str += `<div class="col-6" onclick="toggle_package_view_modal(${packages[package_index].package_id},'{{ route('get_package_data') }}')">
                                                    <div class="card h-100">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <img src="${packages[package_index].image_src}" class="img-thumbnail">
                                                                </div>
                                                                <div class="col-9">
                                                                    <div class="card-title">${packages[package_index].name} (${packages[package_index].venue_name})</div>
                                                                    <div class="card-subtitle"><i class="fa-solid fa-location-dot"></i> ${packages[package_index].address} ${map_link}</div>
                                                                    <div class="card-text mt-3">
                                                                        ${features}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                        }

                        package_index++;
                    }

                    package_html_str += `</div></div></div>`;
                    
                }

                $("#packages_carousel_items").html(package_html_str);
            },
            error: function(res_data) {
            }
        });
});

</script>