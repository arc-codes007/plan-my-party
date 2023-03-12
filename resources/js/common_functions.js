initialize_all_tooltips_popovers = function()
{
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
    })

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
}

toTitleCase = function(str) {
    return str.toLowerCase().split(' ').map(function (word) {
      return (word.charAt(0).toUpperCase() + word.slice(1));
    }).join(' ');
  }

toggle_package_view_modal = function(package_id, api_url)
{
    $.ajax({
        url: api_url,
        type: "GET",
        data: {package_id},
        success: function(response) {
            let package_data = response.package_data;

            $("#pkg_modal_book_party").attr('package_id',package_id);
            $("#pkg_modal_package_image").attr('src', package_data.image_src);
            $("#pkg_modal_package_name").html(package_data.name);
            $("#pkg_modal_venue_name").html(package_data.venue_name);
            $("#pkg_modal_venue_rating").html(package_data.venue_rating);

            let package_rating = "(Not Rated Yet!)";
            if(package_data.package_rating)
            {
                package_rating = `<span style='cursor:pointer' data-bs-toggle="tooltip" title="View Reviews" onclick='open_package_reviews_modal(${package_id})'>(${package_data.package_rating} <i class='text-warning fa-solid fa-star'></i>)</span>`;
            }
            $("#pkg_modal_package_rating").html(package_rating);

            let address = package_data.address;
            if(package_data.gmap_link)
            {
                address += ` <a href="${package_data.gmap_link}" data-bs-toggle="tooltip" title="Open in Google Maps" target="_BLANK"><i class="text-success fa-solid fa-map-location-dot"></i></a>`;
            }
            $("#pkg_modal_address").html(address);
            
            let pricing = package_data.pricing;
            let pricing_str = '';
            if(pricing.type = 'per_person')
            {
                pricing_str += `&#8377 ${pricing.cost}/- Per ${(pricing.amount > 1) ? pricing.amount+' Persons' : 'Person'}`;
            }
            $("#pkg_modal_pricing").html(pricing_str);
            $("#pkg_modal_min_persons").html(package_data.min_person);
            $("#pkg_modal_max_persons").html(package_data.max_person);
            $("#pkg_modal_sitting_type").html(package_data.sitting_type);

            let timming_info_str = '<div class="row">';            
            for(let day in package_data.timmings)
            {
                timming_info_str += `<div class="col-4 text-center text-nowrap">${toTitleCase(day)}</div><div class="col-1">-</div><div class="col-6">${package_data.timmings[day]['from']} to ${package_data.timmings[day]['to']}</div>`;
            }
            timming_info_str += '</div>';

            $("#pkg_modal_timming_info").attr("data-bs-content", timming_info_str);
            initialize_all_tooltips_popovers();
            
            let features = '<div class="row">';

            let additional_details = package_data.additional_details;
            if(package_data.parking_available)
            {
                features += `<div class="col-6"><i class="text-warning fa-solid fa-square-parking"></i> Parking Available</div>`;
            }

            if(additional_details.length > 0)
            {
                for(let index = 0;index < additional_details.length; index++)
                {
                    features += `<div class="col-6"><i class="text-warning fa-solid fa-bolt"></i> ${additional_details[index]}</div>`;
                }
            }
            features += `</div>`;
            $("#pkg_modal_additional_feature").html(features);

            let menu = package_data.menu;
            if(Object.keys(menu).length > 0)
            {
                let menu_content_str = '';
                for(let category in menu)
                {
                    menu_content_str += `<div class="mt-4 h4"><strong>${category}</strong></div>`;
                    
                    for(let dish of menu[category])
                    {
                        menu_content_str += `<div class="mb-1 h5">${dish}</div>`;
                    }
                }

                $("#pkg_modal_menu_content").html(menu_content_str);
                $("#pkg_modal_menu_area").show();
            }

            var package_view_modal = new bootstrap.Modal(document.getElementById('package_view_modal'));
            package_view_modal.toggle();
        },
        error: function(res_data) {
        }
    });
}

create_party = function(entity_id, belongs_to, route)
{
    let params = {
        entity_id,
        belongs_to
    };

    if($("#person_count").val())
    {
        params['person_count'] = $("#person_count").val();
    }

    $.ajax({
        url: route,
        type: "POST",
        data: params,
        success: function(response) {
        },
        error: function(res_data) {
        }
    });
}