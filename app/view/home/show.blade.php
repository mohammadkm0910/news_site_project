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
    <title><?php echo urldecode($title); ?></title>
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
    <div class="row card-image-post">
        <div class="image-box">
            <img src="<?php $this->asset($mainNews['image']); ?>" alt="<?php echo $mainNews['title'][0]; ?>">
        </div>
        <div class="info-box">
            <p>
                <i class="fas fa-user"></i>
                نوشته: <?php echo $mainNews['username']; ?>
            </p>
            <p><?php echo formattedDateSql($mainNews['created_at'][0]); ?></p>
            <p>تعداد نظرات:<?php echo AppQuery::commentNewsCountByNewsId($mainNews['id'][0]); ?></p>
            <p>
                <i class="fas fa-list-alt"></i>
                گروه:<?php echo $mainNews['title'][1]; ?>
            </p>
        </div>
        <div class="title-box"><h5><?php echo $mainNews['title'][0]; ?></h5></div>
    </div>
    <div class="row mt-2 reverse-md">
        @include('partial.app.sidebar')
        <div class="col-md-8 col-9 p-0">
            <div class="card-main-large">
                <img src="<?php $this->asset($mainNews['image']); ?>" alt="<?php echo $mainNews['title'][0]; ?>">
                <div class="p-4">
                    <?php echo $mainNews['body']; ?>
                </div>
            </div>
            <div class="card-main-large mt-2 p-0">
                <?php if (\Core\Service::loginUser()) { ?>
                <form  method="post" action="<?php $this->url('Home/comment-store/'.$mainNews['id'][0]); ?>" class="col-12 main-form fix-show-form" id="form-comment">
                    <header>
                        <h5>فرم ثبت نظر کاربر</h5>
                    </header>
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo \Core\Service::loginUser()['id']; ?>">
                    <div class="form-group">
                        <label for="comment" class="label-text">نام کاربری</label>
                        <textarea class="input-text" placeholder="دیدگاه خود را وارد کنید" name="comment" id="comment"></textarea>
                    </div>
                    <div class="form-group checkbox-row">
                        <label>قوانین ارسال دیدگاه در سایت را مطالعه کرده ام.
                            <input type="checkbox" name="accept" id="accept">
                            <span class="checkbox-mark"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="button" class="btn btn-block" id="insert-comment" value="ثبت نظر">
                    </div>
                </form>
                <?php } else { ?>
                <div class="col-12 main-form fix-show-form" id="form-comment">
                    <header>
                        <h5>شما هنوز وارد سایت نشده اید!</h5>
                    </header>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php $this->url('register'); ?>" class="btn btn-success btn-block">ثبت نام</a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?php $this->url('login'); ?>" class="btn btn-block">ورود</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php ?>
            <?php if ($comments) { ?>
                <div class="card-main-large mt-2 p-0">
                    <?php foreach ($comments as $comment) { ?>
                        <div class="row comments">
                            <div class="avatar">
                                <span class="fas fa-users"></span>
                            </div>
                            <div class="comment-info">
                                <h4><?php echo $comment['username']; ?></h4>
                                <p><?php echo formattedDateSql($comment['created_at'][0]); ?></p>
                            </div>
                            <div class="col-12 text">
                                <p><?php echo $comment['comment']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="card-main-large mt-2 p-0">
                    <div class="comment-no">نظری برای نمایش وجود ندارد</div>
                </div>
            <?php } ?>
        </div>
    </div>
</article>
@include('partial.app.bottom-footer')
<script src="<?php $this->asset('plugin/vibrant.js-master/Vibrant.min.js'); ?>"></script>
<script src="<?php $this->asset('plugin/alertifyjs/alertify.min.js'); ?>"></script>
<script src="<?php $this->asset('app/js/script.js'); ?>"></script>
<?php if (\Core\Service::isInternetExplore()) { ?>
<script>
    function autosize(textarea) {
        $(textarea).height(1);
        $(textarea).height($(textarea).prop("scrollHeight"));
    }
    $(document).ready(function () {
        $(document).on("input", "textarea", function() {
            autosize(this);
        });
        $("textarea").each(function () {
            autosize(this);
        });
    });
</script>
<?php } ?>
<script>
    $("#insert-comment").on('click', function () {
        let comment = $("#comment");
        let accept = $("#accept");
        $.ajax({
            type: "post",
            url: $("#form-comment").prop("action"),
            data: "user_id=" + $("#user_id").val() + "&comment=" + comment.val() + "&accept=" + accept.prop("checked"),
            success: function (result) {
                comment.val("");
                accept.prop("checked", false);
                if (result.toString().trim() !== "") {
                    alertify.set('notifier','position', 'top-left');
                    alertify.error(result);
                }
            }
        });
    });
</script>
</body>
</html>
