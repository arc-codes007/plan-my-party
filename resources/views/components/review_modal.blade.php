<div class="modal" tabindex="-1" id="add_review_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Please Rate and Review the Party</h3>
                @if (isset($open_review_modal) && ! $open_review_modal)
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @endif
            </div>
            <form id="review_form">
                <input type="hidden" id="review_for_party_id" value="">
                <div class="modal-body">
                    <div class="rating-box">
                        <h3>How was your experience?</h3>
                        <div class="rating_stars">
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                          <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="form-label h3">Review</label>
                        <textarea class="form-control" name="review" id="review" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (isset($open_review_modal) && ! $open_review_modal)
                        <button type="reset" id="review_form_close_btn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    @endif
                    <button type="submit" id="review_form_save_btn" class="btn btn-primary text-white">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

// ---- ---- Const ---- ---- //
const stars = document.querySelectorAll('.rating_stars i');
const starsNone = document.querySelector('.rating-box');

// ---- ---- Stars ---- ---- //
stars.forEach((star, index1) => {
  star.addEventListener('click', () => {
    stars.forEach((star, index2) => {
      // ---- ---- Active Star ---- ---- //
      index1 >= index2
        ? star.classList.add('active')
        : star.classList.remove('active');
    });
  });
});

$(document).ready(function(){

    @if (isset($open_review_modal) && $open_review_modal)
        var add_review_modal = new bootstrap.Modal(document.getElementById('add_review_modal'));
        add_review_modal.show();
    @endif

    var myModalEl = document.getElementById('add_review_modal')
    myModalEl.addEventListener('hidden.bs.modal', function (event) 
    {
        stars.forEach((star, index1) => {
            star.classList.remove('active');
        });

        $("#review").val('');
    })

    $("#review_form").submit((e) => {
        e.preventDefault();
        $("#review_form_save_btn").prop('disabled', true);
        let data = {
            'rating' : $(".rating_stars .active").length,
            'review' : $("#review").val(),
        };

        @guest
            data['user_type'] = 'guest';
            data['user_id'] = {{(isset($guest_id)) ? $guest_id : ''}};
        @else
            data['user_type'] = 'user';
            data['user_id'] = {{Auth::user()->id}};
            data['party_id'] = $("#review_for_party_id").val();
        @endguest

        $.ajax({
            url: "{{ route('save_review') }}",
            type: "POST",
            data: data,
            success: function(res_data) {

                alertify.alert('Notification', res_data.message, function()
                {
                    window.location.reload();
                });
                $("#review_form_save_btn").prop('disabled', false);
            },
            error: function(res_data) {
                $("#review_form_save_btn").prop('disabled', false);
            }
        });
    });
});

</script>