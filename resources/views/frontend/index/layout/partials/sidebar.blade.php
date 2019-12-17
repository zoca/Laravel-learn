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
    @if( count($categories) > 0 )
    <ul class="c-menu c-arrow-dot1 c-theme">
        @foreach( $categories as $category )
        <li>
            <a href="#">{{ $category->name }}( {{ count($category->posts) }} )</a>
        </li>
        @endforeach
    </ul>
    @endif
</div>
<div class="c-content-tab-1 c-theme c-margin-t-30">
    <div class="nav-justified">
        <ul class="nav nav-tabs nav-justified">
            <li class="active">
                <a href="#blog_recent_posts" data-toggle="tab">Recent Posts</a>
            </li>
            <li>
                <a href="#blog_popular_posts" data-toggle="tab">Popular Posts</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="blog_recent_posts">
                <ul class="c-content-recent-posts-1">
                    <li>
                        <div class="c-image">
                            <img src="/frontend/assets/base/img/content/stock/09.jpg" alt="" class="img-responsive"> </div>
                        <div class="c-post">
                            <a href="" class="c-title"> UX Design Expo 2015... </a>
                            <div class="c-date">27 Jan 2015</div>
                        </div>
                    </li>
                    <li>
                        <div class="c-image">
                            <img src="/frontend/assets/base/img/content/stock/08.jpg" alt="" class="img-responsive"> </div>
                        <div class="c-post">
                            <a href="" class="c-title"> UX Design Expo 2015... </a>
                            <div class="c-date">27 Jan 2015</div>
                        </div>
                    </li>
                    <li>
                        <div class="c-image">
                            <img src="/frontend/assets/base/img/content/stock/07.jpg" alt="" class="img-responsive"> </div>
                        <div class="c-post">
                            <a href="" class="c-title"> UX Design Expo 2015... </a>
                            <div class="c-date">27 Jan 2015</div>
                        </div>
                    </li>
                    <li>
                        <div class="c-image">
                            <img src="/frontend/assets/base/img/content/stock/32.jpg" alt="" class="img-responsive"> </div>
                        <div class="c-post">
                            <a href="" class="c-title"> UX Design Expo 2015... </a>
                            <div class="c-date">27 Jan 2015</div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tab-pane" id="blog_popular_posts">
                <ul class="c-content-recent-posts-1">
                    <li>
                        <div class="c-image">
                            <img src="/frontend/assets/base/img/content/stock/34.jpg" class="img-responsive" alt="" /> </div>
                        <div class="c-post">
                            <a href="" class="c-title"> UX Design Expo 2015... </a>
                            <div class="c-date">27 Jan 2015</div>
                        </div>
                    </li>
                    <li>
                        <div class="c-image">
                            <img src="/frontend/assets/base/img/content/stock/37.jpg" class="img-responsive" alt="" /> </div>
                        <div class="c-post">
                            <a href="" class="c-title"> UX Design Expo 2015... </a>
                            <div class="c-date">27 Jan 2015</div>
                        </div>
                    </li>
                    <li>
                        <div class="c-image">
                            <img src="/frontend/assets/base/img/content/stock/32.jpg" class="img-responsive" alt="" /> </div>
                        <div class="c-post">
                            <a href="" class="c-title"> UX Design Expo 2015... </a>
                            <div class="c-date">27 Jan 2015</div>
                        </div>
                    </li>
                    <li>
                        <div class="c-image">
                            <img src="/frontend/assets/base/img/content/stock/54.jpg" class="img-responsive" alt="" /> </div>
                        <div class="c-post">
                            <a href="" class="c-title"> UX Design Expo 2015... </a>
                            <div class="c-date">27 Jan 2015</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/BLOG/BLOG-SIDEBAR-1 -->