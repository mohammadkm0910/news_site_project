<nav class="navbar">
    <ul class="navbar-nav">
        <li><a id="btn-open-sidebar"><i class="fas fa-bars"></i></a></li>
        <li><a href="#" class="brand">پنل داشبورد</a></li>
    </ul>
    <form class="nav-search" method="post" action="<?php $this->url('admin/search'); ?>">
        <div class="container">
            <span class="close fas fa-times"></span>
            <input type="text" placeholder="جست و جو..." name="q">
            <input type="hidden" name="url" value="<?php echo $url; ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <ul class="navbar-nav">
        <li class="search"><a id="btn-open-search"><i class="fas fa-search"></i></a></li>
        <li><a id="btn-switch-theme"><i class="moon"></i></a>
        </li>
        <li class="navigation">
            <a><i class="fas fa-bell"></i></a>
            <span id="unseen-label"><?php echo \App\Database\AdminQuery::unseenCommentCount(); ?></span>
        </li>
        <li class="navbar-dropdown">
            <a id="btn-open-user"><i class="fas fa-user-alt"></i></a>
            <ul id="user-content">
                <?php if (\Core\Service::loginUser()) { ?>
                    <li><a><i class="fas fa-user-tie"></i><?php echo \Core\Service::loginUser()['username']; ?></a></li>
                    <li><a href="<?php $this->url('logout'); ?>"><i class="fas fa-sign-out-alt"></i>خروج</a></li>
                <?php } else { ?>
                    <li><a href="<?php $this->url('register'); ?>"><i class="fas fa-user-tie"></i>ثبت نام</a></li>
                    <li><a href="<?php $this->url('login'); ?>"><i class="fas fa-sign-out-alt"></i>ورود</a></li>
                <?php } ?>
            </ul>
        </li>
    </ul>
</nav>
<footer class="footer">
    <nav>
        <address><?php echo formattedDateSql(time(), true); ?></address>
    </nav>
</footer>
