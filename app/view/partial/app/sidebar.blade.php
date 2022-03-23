<div class="col-md-4 col-3 p-0">
    <div class="card">
        <header class="card-header">
            <h6>از سرار وب</h6>
            <i class="fas fa-spinner fa-pulse"></i>
        </header>
        <div class="card-body">
            <ul class="text-list">
                <li><a href="#">یه راه مقرون به صرفه و خوب برای پیاده سازی ایده</a></li>
                <li><a href="#">برو به سرزمین آواره‌ها و رایگان پای بهترین فیلم ۲۰۲۱ بشین.</a></li>
                <li><a href="#">خرید باکس 5عددی ماسک سه بعدی 5لایه - 17,900 تومان</a></li>
                <li><a href="#">با یک کرم در سریعترین زمان لک های پوستی را درمان کنید</a></li>
                <li><a href="#">بازی آنلاین رو با سرعت بالای اینترنت برنده شو :)</a></li>
                <li><a href="#">صحنه های مخفی GTA 5 که احتمالا متوجه شان نشدید!</a></li>
            </ul>
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <h6>پربحث ترین ها</h6>
            <i class="fas fa-comment-alt"></i>
        </header>
        <div class="card-body">
            <ul class="card-list">
                <?php use App\Database\AppQuery;
                foreach (AppQuery::mostCommentedNewsSidebar() as $mn ) {
                    ?>
                    <li>
                        <a href="<?php $this->url('home/show/'.$mn[0]['id'].'/'.$mn[0]['title']); ?>">
                            <img src="<?php $this->asset($mn[0]['image']); ?>" alt="<?php echo $mn[0]['title']; ?>">
                            <p><?php echo $mn[0]['title']; ?></p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <h6>پربازدیدترن ها</h6>
            <i class="fas fa-eye"></i>
        </header>
        <div class="card-body">
            <ul class="card-list">
                <?php foreach (AppQuery::mostViewNewsSidebar() as $vn) { ?>
                    <li>
                        <a href="<?php $this->url('home/show/'.$vn['id'].'/'.$vn['title']); ?>">
                            <img src="<?php $this->asset($vn['image']); ?>" alt="<?php echo $vn['title']; ?>">
                            <p><?php echo $vn['title']; ?></p>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
