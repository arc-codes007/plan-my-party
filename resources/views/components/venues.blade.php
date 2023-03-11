<div class="container p-2">
    <div class="row">
        <h1 class="text-danger">Venues</h1>
    </div>
</div>

<div id="carouselExampleDarkPkg" class="carousel carousel-dark slide" data-bs-ride="carousel">
    <div class="carousel-inner" id="venues_carousel_items">
        {{-- venues are dynamically loaded here through ajax --}}
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDarkPkg" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDarkPkg" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('fetch_all_venues_data') }}",
            type: "GET",
            success: function(response) {
                let venues = response.venues;
                let item_count = Math.ceil(venues.length / 2);
                let venue_index = 0;

                let venue_html_str = '';

                for (let i = 0; i < item_count; ++i) {
                    venue_html_str += `<div class="carousel-item ${(i == 0) ? 'active' : ''}" data-bs-interval="10000">` +
                        `<div class="container pb-5">` +
                        `<div class="row">`;

                    for (let j = 0; j < 2; ++j) {
                        if (venues[venue_index]) {
                            let features = '<div class="row">';
                            let feature_count = 0;

                            let total_features = 4;
                            let additional_features = venues[venue_index].additional_features;
                            if (additional_features.length < 4) {
                                total_features = additional_features.length;
                            }

                            if (venues[venue_index].parking_available) {
                                features += `<div class="col-6"><i class="text-warning fa-solid fa-square-parking"></i> Parking Available</div>`;
                                feature_count = 1;
                                total_features += 1;
                            }

                            if (additional_features.length > 0) {
                                let additional_features_index = 0;
                                while (feature_count < total_features) {
                                    features += `<div class="col-6"><i class="text-warning fa-solid fa-bolt"></i> ${additional_features[additional_features_index]}</div>`;
                                    additional_features_index++;
                                    feature_count++;
                                }
                            }
                            features += `</div>`;

                            let map_link = '';
                            if (venues[venue_index].gmap_link) {
                                map_link = `<a href="${venues[venue_index].gmap_link}" target="_BLANK"><i class="text-success fa-solid fa-map-location-dot"></i></a>`;
                            }
                            venue_html_str += `<div class="col-6" onclick="redirect_to_venue_view(${venues[venue_index].venue_id})">
                                                    <div class="card h-100">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <img src="${venues[venue_index].image_src}" class="img-thumbnail">
                                                                </div>
                                                                <div class="col-9">
                                                                    <div class="card-title">${venues[venue_index].name}</div>
                                                                    <div class="card-subtitle"><i class="fa-solid fa-location-dot"></i> ${venues[venue_index].address} ${map_link}</div>
                                                                    <div class="card-text mt-3">
                                                                        ${features}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                        }

                        venue_index++;
                    }

                    venue_html_str += `</div></div></div>`;

                }

                $("#venues_carousel_items").html(venue_html_str);
            },
            error: function(res_data) {}
        });
    });

function redirect_to_venue_view(venue_id)
{
    window.location.href = '{{route('venue_details')}}'+'/'+venue_id;
}
</script>