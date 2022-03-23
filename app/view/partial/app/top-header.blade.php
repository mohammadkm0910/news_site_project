<header>
    <section class="header-register">
        <div class="row">
            <div class="col-sm-6">
                <h4>حساب کاربری</h4>
            </div>
            <div class="col-sm-6">
                <?php if (\Core\Service::loginUser()) { ?>
                    <h5><?php echo \Core\Service::loginUser()['email']; ?></h5>
                <?php } else { ?>
                    <h5>شما ثبت نام نکرده اید</h5>
                <?php } ?>
            </div>
        </div>
    </section>
    <nav class="navbar">
        <div class="nav-segment first">
            <div class="nav-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a href="<?php $this->url('/'); ?>" class="nav-brand"></a>
        </div>
        <div class="nav-segment" id="nav-content">
            <ul>
                <li><a href="<?php $this->url('home/news'); ?>">اخبار</a></li>
                <li><a href="#">تست</a></li>
                <li><a href="#">اختصاصی ترنجی</a></li>
                <li><a href="#">تبلیغات</a></li>
                <li><a href="#">درباره ما</a></li>
            </ul>
        </div>
        <div class="nav-segment left">
            <ul>
                <li><span class="fas fa-search" id="open-navbar-search"></span></li>
                <li class="sub-navbar">
                    <span class="fas fa-user"></span>
                    <ul class="navbar-register">
                        <?php if (\Core\Service::loginUser()) { ?>
                            <li>
                                <i class="fas fa-user-alt"></i>
                                <a><?php echo \Core\Service::loginUser()['username']; ?></a>
                            </li>
                            <li>
                                <i class="fas fa-sign-out-alt"></i>
                                <a href="<?php $this->url('logout'); ?>">خروج</a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <i class="fas fa-user-alt"></i>
                                <a href="<?php $this->url('register'); ?>">ثبت نام</a>
                            </li>
                            <li>
                                <i class="fas fa-user-check"></i>
                                <a href="<?php $this->url('login'); ?>">ورود</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
        <form class="navbar-search" method="get" action="<?php $this->url('home/search') ?>">
            <button class="close"><i class="fas fa-times"></i></button>
            <input type="text" placeholder="جست و جو" name="q">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </nav>
    <nav class="navbar-shortcut">
        <div class="navbar-shortcut-drawer row space-between-center p-2">
            <p>میانبر ها</p>
            <span class="fas fa-bars"></span>
        </div>
        <div class="navbar-shortcut-link">
            <a href="#">ces</a>
            <a href="#">آیفون 12</a>
            <a href="#">گلکسی اس 21</a>
            <a href="#">آپدیت اندروید 11</a>
            <a href="#">آپدیت ios 14</a>
            <a href="#">رمز پویا</a>
        </div>
    </nav>
</header>
