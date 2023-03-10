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
      <li id="step_3_button" class="{{(empty($party_data)) ? 'locked': ''}}" {{(!empty($party_data)) ? 'onclick=navigate_to(3)': ''}}>
        <div class="p-3 text-center text-nowrap">Step 3: Invitation
          @if (empty($party_data))
            <i class="fa-solid fa-lock"></i>
          @endif
        </div>
      </li>
      <li id="step_4_button" class="{{(empty($party_data)) ? 'locked': ''}}" {{(!empty($party_data)) ? 'onclick=navigate_to(4)': ''}}>
        <div class="p-3 text-center text-nowrap">Step 4: Guests
          @if (empty($party_data))
            <i class="fa-solid fa-lock"></i>
          @endif
        </div>
      </li>
    </ul>
</aside>
