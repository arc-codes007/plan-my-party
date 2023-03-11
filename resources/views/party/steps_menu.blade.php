<aside id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li id="step_1_button" class="{{(empty($party_data)) ? 'active': 'locked'}}">
        <div class="p-3 text-center text-nowrap" id="step_1_search_button">Step 1: Search
          @if (!empty($party_data))
            <i class="fa-solid fa-lock"></i>
          @endif
        </div>
      </li>
      <li id="step_2_button" class="{{(empty($party_data)) ? 'locked': 'active'}}" {{(!empty($party_data)) ? 'onclick=navigate_to(2)': ''}}>
        <div class="p-3 text-center text-nowrap">Step 2: Plan The Party
          @if (empty($party_data))
            <i class="fa-solid fa-lock"></i>
          @endif
        </div>
      </li>
      @if ( ! $is_planned)
        <li id="step_3_button" class="{{(empty($party_data)) ? 'locked': ''}}" {{(!empty($party_data)) ? 'onclick=navigate_to(3)': ''}}>
          <div class="p-3 text-center text-nowrap">Step 3: Invitation
            @if (empty($party_data))
              <i class="fa-solid fa-lock"></i>
            @endif
          </div>
        </li>        
      @endif
      <li id="step_4_button" class="{{(empty($party_data)) ? 'locked': ''}}" {{(!empty($party_data)) ? 'onclick=navigate_to(4)': ''}}>
        <div class="p-3 text-center text-nowrap">Step 4: Guests
          @if (empty($party_data))
            <i class="fa-solid fa-lock"></i>
          @endif
        </div>
      </li>
      @if (!empty($party_data))    
        <div class="m-3 d-grid">
          @if ($is_planned)
            <div class="btn text-white badge bg-primary p-2 fs-6 my-2 fw-normal" style="cursor: default !important">Planned</div>
          @else
            <button onclick="set_to_planned()" class="btn btn-primary text-white">Set Party to Planned</button>
          @endif
        </div>  
      @endif
    </ul>
    

</aside>
