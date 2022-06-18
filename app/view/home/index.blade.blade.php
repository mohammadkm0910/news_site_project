<?php use App\Database\AppQuery; ?>
<!doctype html>
<html lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="<?php $this->asset('plugin/jquery/jquery.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php $this->asset('plugin/fontawesome-pro-5.7.2/all.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('app/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php $this->asset('plugin/alertifyjs/alertify.rtl.min.css'); ?>">
    @include('partial.app.favicon')
    <title>صفحه اصلی</title>
</head>
<body>
@include('partial.app.top-header')
<article class="p-4">
    <div class="row">
        <div class="col-md-6 first-ad">
            <a href="#">
                <img src="<?php $this->asset('app/image/Mahak.gif'); ?>" alt="">
            </a>
        </div>
        <div class="col-md-6 first-ad">
            <a href="#">
                <img src="<?php $this->asset('app/image/Toranji-Ad.gif'); ?>" alt="">
            </a>
        </div>
    </div>
    <?php if ($mainPageCount == 6) { ?>
    <div class="row mt-2">
        <?php for ($i=0;$i<4;$i++) { ?>
        <div class="col-md-6 gallery-large-item">
            <a href="<?php $this->url('home/show/'.$mainPage[$i]['id'][0].'/'.$mainPage[$i]['title']); ?>">
                <div class="gallery-large-content">
                    <p><?php echo $mainPage[$i]['title']; ?></p>
                    <p><?php echo $mainPage[$i]['username']; ?></p>
                    <p>
                        <span><?php echo AppQuery::commentNewsCountByNewsId($mainPage[$i]['id'][0]); ?></span>
                        <span class="fas fa-comment"></span>
                    </p>
                </div>
                <img src="<?php $this->asset($mainPage[$i]['image']); ?>" alt="<?php echo $mainPage[$i]['title']; ?>" class="gallery-large-image">
            </a>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <?php for ($i=4;$i<6;$i++) { ?>
        <a href="<?php $this->url('home/show/'.$mainPage[$i]['id'][0].'/'.$mainPage[$i]['title']); ?>" class="col-md-6 main-item-gradient">
            <div class="clip">
                <img src="<?php $this->asset($mainPage[$i]['image']); ?>" alt="<?php echo $mainPage[$i]['title']; ?>">
                <h6><?php echo $mainPage[$i]['title']; ?></h6>
            </div>
        </a>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="row mt-2 reverse-md">
        @include('partial.app.sidebar')
        <div class="col-md-8 col-9 p-0">
            <?php foreach ($allNews as $an) { ?>
                <div class="row card-mini-post">
                    <a href="<?php $this->url('home/show/'.$an['id'][0].'/'.$an['title'][0]); ?>" class="shine">
                        <img src="<?php $this->asset($an['image']); ?>" alt="<?php echo $an['title'][0]; ?>">
                    </a>
                    <div>
                        <a href="<?php $this->url('home/group/'.$an['id'][2].'/'.$an['title'][1]); ?>" class="group">
                            <?php echo $an['title'][1]; ?>
                        </a>
                        <a href="<?php $this->url('home/show/'.$an['id'][0].'/'.$an['title'][0]); ?>" class="title"><h6><?php echo $an['title'][0]; ?></h6></a>
                        <p class="info">
                            <span>نام نویسنده: </span>
                            <span><?php echo $an['username']; ?></span>
                            <span> | </span>
                            <span><?php echo timeAgo($an['created_at'][0]); ?></span>
                            <span> | </span>
                            <span>تعداد دیدگاه: </span>
                            <span><?php echo AppQuery::commentNewsCountByNewsId($an['id'][0]); ?> دیدگاه</span>
                        </p>
                        <p class="content"><?php echo $an['summary']; ?></p>
                    </div>
                </div>
            <?php } ?>
            <ul class="paging">
                <?php for ($i=1; $i <= $pages; $i++) {
                    ?>
                    <li class="<?php echo activePage('home?page='.$i); ?>">
                        <a href="<?php $this->url('home?page='.$i); ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</article>
@include('partial.app.bottom-footer')
<script src="<?php $this->asset('plugin/vibrant.js-master/Vibrant.min.js'); ?>"></script>
<script src="<?php $this->asset('plugin/alertifyjs/alertify.min.js'); ?>"></script>
<script src="<?php $this->asset('app/js/script.js'); ?>"></script>
<?php if (isset($_SESSION['WELCOME'])) { ?>
<script>
    alertify.set('notifier','position', 'top-left');
    alertify.success("<?php echo $_SESSION['WELCOME']; ?>");
    <?php unset($_SESSION['WELCOME']); ?>
</script>
<?php } ?>
</body>
</html>