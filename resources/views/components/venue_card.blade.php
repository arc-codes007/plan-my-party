<div class="m-2" onclick="window.location.href = '{{route('venue_details',$id)}}'">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <img src="{{$primary_image_src}}" class="img-thumbnail">
                </div>
                <div class="col-9">
                    <div class="card-title">{{$name}}</div>
                    <div class="card-subtitle"><i class="fa-solid fa-location-dot"></i> {{$address}} 
                        @if (!empty($gmap_location))
                            <a href="{{$gmap_location}}" target="_BLANK"><i class="text-success fa-solid fa-map-location-dot"></i></a>
                        @endif
                    </div>
                    <div class="card-text mt-3">
                        @if ($parking_available || count($additional_features) > 0)
                            @php
                                $feature_count = 0;
                                $total_features = 4;

                                if(count($additional_features) < 4)
                                {
                                    $total_features = count($additional_features);
                                }
                            @endphp
                            <div class="row">
                                @if ($parking_available)
                                    <div class="col-6"><i class="text-warning fa-solid fa-square-parking"></i> Parking Available</div>
                                    @php
                                        if($total_features >= 4)
                                        {
                                            $total_features = 3;
                                        }
                                    @endphp
                                @endif
                                @if (count($additional_features) > 0)
                                    @for ($additional_features_index = 0; $additional_features_index < $total_features; $additional_features_index++)
                                        <div class="col-6"><i class="text-warning fa-solid fa-bolt"></i> {{$additional_features[$additional_features_index]}}</div>
                                    @endfor
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>