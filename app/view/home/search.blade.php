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
    <?php $this->partial('app.favicon'); ?>
    <title>جست و جو</title>
</head>
<body>
<?php $this->partial("app.top-header"); ?>
<article class="p-4">
    <div class="card-group">
        <h1><q><?php echo $title; ?></q></h1>
    </div>
    <div class="row mt-2 reverse-md">
        <?php $this->partial("app.sidebar"); ?>
        <div class="col-md-8 col-9 p-0">
            <?php foreach ($news as $an) { ?>
                <div class="row card-mini-post">
                    <a href="<?php $this->url('home/show/'.$an['id'][0].'/'.$an['title'][0]); ?>" class="shine">
                        <img src="<?php $this->asset($an['image']); ?>" alt="<?php echo $an['title'][0]; ?>">
                    </a>
                    <div>
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
        </div>
    </div>
</article>
<?php $this->partial("app.bottom-footer"); ?>
<script src="<?php $this->asset('plugin/vibrant.js-master/Vibrant.min.js'); ?>"></script>
<script src="<?php $this->asset('plugin/jquery/jquery.timeago.js'); ?>"></script>
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