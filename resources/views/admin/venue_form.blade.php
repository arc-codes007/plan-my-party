@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-title display-5 text-center">Venue Form</div>
            <form>
                <div class="row gap-4 justify-content-around">
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Contact Phone Number</label>
                        <input type="number" class="form-control" id="contact_phone" name="contact_phone">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" placeholder="Enter Address" id="address"></textarea>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Google Maps Link</label>
                        <input type="text" class="form-control" id="gmap_location" name="gmap_location">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Total Capacity</label>
                        <input type="number" class="form-control" id="total_capacity" name="total_capacity">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Parking Capacity</label>
                        <input type="number" class="form-control" id="parking_capacity" name="parking_capacity">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Cuisines</label>
                        <select name="cuisines" id="cuisines" class="form-control select2-tags" multiple>
                            <option value="Indian">Indian</option>
                            <option value="Thai">Thai</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Additional Features</label>
                        <select name="additional_features" id="additional_features" class="form-control select2-tags" multiple>
                            <option value="Take Away">Take Away</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label class="form-label">Rating</label>
                        <input type="number" class="form-control" id="venue_rating" name="venue_rating">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection