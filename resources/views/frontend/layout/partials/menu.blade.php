  <!-- BEGIN: MEGA MENU -->
  <!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
  <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">

      @if( count($pagesTopLevel) > 0)
      <ul class="nav navbar-nav c-theme-nav">
          @foreach($pagesTopLevel as $value)
          <li>
              <a href="{{ route('pages.show', ['page' => $value->id, 'slug'=> Str::slug($value->title, '-') ] ) }}" class="c-link dropdown-toggle">{{ $value->title }}
                  <span class="c-arrow c-toggler"></span>
              </a>
              @if(count($value->pages) > 0)
              <ul class="dropdown-menu c-menu-type-inline">
                  @foreach($value->pages as $value2)
                  <li>
                      <a href="{{ route('pages.show', ['page' => $value2->id, 'slug'=> Str::slug($value2->title, '-') ] ) }}" class="c-link dropdown-toggle">{{ $value2->title }}
                      </a>
                  </li>
                  @endforeach
              </ul>
              @endif
          </li>
          @endforeach
      </ul>
      @endif
  </nav>
  <!-- END: MEGA MENU -->