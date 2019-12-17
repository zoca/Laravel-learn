  <!-- BEGIN: MEGA MENU -->
  <!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
  <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">

  @if( count($categories) > 0)
      <ul class="nav navbar-nav c-theme-nav">
            @foreach($categories as $category)
          <li>
              <a href="{{ route('posts.category', ['category' => $category->id] ) }}" class="c-link dropdown-toggle">{{ $category->name }}
                  <span class="c-arrow c-toggler"></span>
              </a>
          </li>
          @endforeach
      </ul>
      @endif
  </nav>
  <!-- END: MEGA MENU -->