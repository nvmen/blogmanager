
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./"><img src="{{ URL::asset('images/logo.png') }}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{ URL::asset('images/logo2.png') }}" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="index.html"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>
                <h3 class="menu-title">System Blog</h3><!-- /.menu-title -->
                <li>
                    <a href="{{route('social.network')}}"> <i class="menu-icon fa fa-dribbble"></i>Social Network </a>
                </li>
                <li>
                    <a href="{{route('user.blog')}}"> <i class="menu-icon fa fa-users"></i>Blog Users </a>
                </li>
                <li>
                    <a href="{{route('user.blog')}}"> <i class="menu-icon fa fa-users"></i>Blog Post </a>
                </li>
                <li>
                    <a href="{{route('blog.user.share')}}"> <i class="menu-icon fa fa-users"></i>Sharing Post </a>
                </li>
                <h3 class="menu-title">Payment</h3><!-- /.menu-title -->
                <li>
                    <a href="{{route('user.blog')}}"> <i class="menu-icon fa fa-users"></i>Payment </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>