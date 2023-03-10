<aside id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="{{(empty($party_data)) ? 'active': 'locked'}}">
        <div class="p-3 text-center text-nowrap" id="step_1_search_button">Step 1: Search
          @if (!empty($party_data))
            <i class="fa-solid fa-lock"></i>
          @endif
        </div>
      </li>
      <li class="{{(empty($party_data)) ? '': 'active'}}">
        <div class="p-3 text-center text-nowrap">Step 2: Plan The Party</div>
      </li>
      <li>
        <div class="p-3 text-center text-nowrap">Step 3: Create Invite</div>
      </li>
      <li>
        <div class="p-3 text-center text-nowrap">Step 4: Maintain Guests</div>
      </li>
    </ul>
  </aside>
