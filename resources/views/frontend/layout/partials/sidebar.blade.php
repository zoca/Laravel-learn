<!-- BEGIN: CONTENT/BLOG/BLOG-SIDEBAR-1 -->
<form action="#" method="post">
    <div class="input-group">
        <input type="text" class="form-control c-square c-theme-border" placeholder="Search blog...">
        <span class="input-group-btn">
            <button class="btn c-theme-btn c-theme-border c-btn-square" type="button">Go!</button>
        </span>
    </div>
</form>
<div class="c-content-ver-nav">
    <div class="c-content-title-1 c-theme c-title-md c-margin-t-40">
        <h3 class="c-font-bold c-font-uppercase">Categories</h3>
        <div class="c-line-left c-theme-bg"></div>
    </div>
         @if( count($pagesTopLevel) > 0)
      <ul class="c-menu c-arrow-dot1 c-theme">
            @foreach($pagesTopLevel as $value)
        <li>
            <a href="{{ route('pages.show', ['page' => $value->id, 'slug'=> Str::slug($value->title, '-') ] ) }}">{{ $value->title }}</a>
        </li>
        @endforeach
    </ul>
    @endif
</div>
<!-- END: CONTENT/BLOG/BLOG-SIDEBAR-1 -->