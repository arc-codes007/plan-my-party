<div class="row h5">
    <div class="col-7">
        <form id="party_search_form">
            <div class="mx-2">
                <div class="my-3">
                    <label for="type" class="mb-2 form-label">Celebration type:</label>
                    <select name="type" id="type" class="form-control">
                        <option value="" selected>All</option>
                        @foreach (config("pmp.package_types") as $type)
                            <option value="{{$type}}">{{$type}}</option>                
                        @endforeach
                    </select>
                </div>
                <div class="my-3">
                    <label for="person_count" class="mb-2 form-label">Person Count:</label>
                    <input type="number" name="person_count" id="person_count" class="form-control">
                </div>
                <div class="my-3">
                    <label for="price_range" class="mb-2 form-label">Price Range</label>
                    <div class="row justify-content-start ms-2">
                        <div class="col-6 form-check">
                            <input class="form-check-input" value="all" type="radio" name="price_range">
                            <label class="form-check-label mt-1">
                                All
                            </label>
                        </div> 
                        <div class="col-6 form-check">
                            <input class="form-check-input" value="0-500" type="radio" name="price_range">
                            <label class="form-check-label mt-1">
                                Upto &#8377 500
                            </label>
                        </div>   
                        <div class="col-6 form-check">
                            <input class="form-check-input" value="500-1500" type="radio" name="price_range">
                            <label class="form-check-label mt-1">
                                &#8377 500 to &#8377 1500
                            </label>
                        </div>   
                        <div class="col-6 form-check">
                            <input class="form-check-input" value="1500-3000" type="radio" name="price_range">
                            <label class="form-check-label mt-1">
                                &#8377 1500 to &#8377 3000
                            </label>
                        </div>   
                        <div class="col-6 form-check">
                            <input class="form-check-input" value="3000-5000" type="radio" name="price_range">
                            <label class="form-check-label mt-1">
                                &#8377 3000 to &#8377 5000
                            </label>
                        </div>    
                        <div class="col-6 form-check">
                            <input class="form-check-input" value="5000-10000" type="radio" name="price_range">
                            <label class="form-check-label mt-1">
                                &#8377 5000 to &#8377 10000
                            </label>
                        </div>  
                        <div class="col-6 form-check">
                            <input class="form-check-input" value="10000+" type="radio" name="price_range">
                            <label class="form-check-label mt-1">
                                &#8377 10000+
                            </label>
                        </div>                  
                    </div>
                </div>
                <div class="my-3">
                    <label for="venue_type" class="mb-2 form-label">Venue type:</label>
                    <select name="venue_type" id="venue_type" class="form-control">
                        <option value="" selected>All</option>
                        @foreach (config("pmp.venue_types") as $type)
                            <option value="{{$type}}">{{$type}}</option>                
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="advance_filters" class="mb-2 form-label">Advance Filters :-</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="parking_compulsory">
                        <label class="form-check-label mt-1" for="parking_compulsory">Parking Facility Compulsory</label>
                    </div>
                    <div class="my-3">
                        <label for="sorting" class="mb-2 form-label">Sort by:</label>
                        <select name="sorting" id="sorting" class="form-control">
                            <option value="rating" selected>Rating</option>
                            <option value="price_high_to_low">Price: High to Low</option>
                            <option value="price_low_to_high">Price: Low to High</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-5 border-start border-4 h-100">
        <div class="m-2">
            <label for="packages" class="form-label fw-bold h4">Recommended Packages for you: -</label>
            <div style="height: 40vh; overflow-y:scroll">
                <div id="packages_container_loader">
                    <div class="d-flex align-items-center" style="display: none">
                        <span>Loading...</span>
                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>
                <div id="packages_container">

                </div>
            </div>
            <label for="venues" class="mt-2 form-label fw-bold h4">Recommended Venues for you: -</label>
            <div style="height: 40vh; overflow-y:scroll">
                <div id="venues_container_loader">
                    <div class="d-flex align-items-center">
                        <span>Loading...</span>
                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>
                <div id="venues_container">

                </div>
            </div>
        </div>
    </div>

</div>

<script>

    $(document).ready(() => {fetch_package_venue();});

    function fetch_package_venue()
    {
        let params = {};

        if($("#type").val())
        {
            params['type'] = $("#type").val();
        }
        if($("#person_count").val())
        {
            params['person_count'] = $("#person_count").val();
        }

        if($("#party_search_form input[type='radio']:checked").val())
        {
            if($("#party_search_form input[type='radio']:checked").val() != 'all')
                params['price_range'] = $("#party_search_form input[type='radio']:checked").val();
        }
        if($("#venue_type").val())
        {
            params['venue_type'] = $("#venue_type").val();
        }

        if($("#parking_compulsory").is(":checked"))
        {
            params['parking_compulsory'] = true;
        }
        if($("#sorting").val())
        {
            params['sorting'] = $("#sorting").val();
        }

        if(Object.keys(params).length > 0)
        {
            $("#packages_container_loader").show();
            $("#venues_container_loader").show();
            $.ajax({
                url: "{{ route('fetch_party_recommendations') }}",
                type: "GET",
                data:params,
                success: function(response) {
                    let packages = response.packages;
                    let venues = response.venues;

                    if(packages.length > 0)
                    {
                        $("#packages_container").html('');
                        for(let package_html of packages)
                        {
                            $("#packages_container").append(package_html);
                        }
                    }
                    else
                    {
                        $("#packages_container").html('No Packages Found!');
                    }

                    if(venues.length > 0)
                    {
                        $("#venues_container").html('');
                        for(let venue_html of venues)
                        {
                            $("#venues_container").append(venue_html);
                        }
                    }
                    else
                    {
                        $("#venues_container").html('No Packages Found!');
                    }

                    $("#packages_container_loader").hide();
                    $("#venues_container_loader").hide();
                },
                error: function(res_data) {
                }
            });
        }
    }


    $("#type").change(() => fetch_package_venue());
    $("#person_count").change(() => fetch_package_venue());
    $('input[type=radio][name=price_range]').change(() => fetch_package_venue());
    $("#venue_type").change(() => fetch_package_venue());
    $("#parking_compulsory").change(() => fetch_package_venue());
    $("#sorting").change(() => fetch_package_venue());

</script>