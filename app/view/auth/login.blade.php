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
    <title>ورود کاربر</title>
</head>
<body>
@include('partial.app.top-header')
<article class="p-4">
    <div class="row mt-2 reverse-md">
        @include('partial.app.sidebar')
        <div class="col-md-8 col-9 p-md-2">
            <form  method="post" class="col-7 main-form" id="form-login" action="<?php $this->url('check-login'); ?>">
                <header>
                    <h5>فرم ورد کاربر</h5>
                </header>
                <div class="form-group">
                    <label for="email" class="label-text">ایمیل</label>
                    <input type="email" class="input-text" placeholder="ایمیل خود را وارد کنید" name="email" id="email">
                </div>
                <div class="form-group password-row">
                    <label for="password" class="label-text">پسورد</label>
                    <?php if (!(\Core\Service::isMicrosoftEdge() or \Core\Service::isInternetExplore())) { ?>
                        <span class="password-show fa fa-eye"></span>
                    <?php } ?>
                    <input type="password" class="input-text" placeholder="پسورد خود را وارد کنید" name="password" id="password">
                </div>
                <div class="form-group checkbox-row">
                    <label>مرا به خاطر نگه دار
                        <input type="checkbox" name="remember-me" id="remember-me">
                        <span class="checkbox-mark"></span>
                    </label>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success btn-block" value="ورود کاربر">
                </div>
            </form>
        </div>
    </div>
</article>
@include('partial.app.bottom-footer')
<script src="<?php $this->asset('plugin/jquery/jquery.validate.min.js'); ?>"></script>
<script src="<?php $this->asset('plugin/alertifyjs/alertify.min.js'); ?>"></script>
<script src="<?php $this->asset('app/js/script.js'); ?>"></script>
<script src="<?php $this->asset('app/js/validate.js'); ?>"></script>
<?php if (isset($_SESSION['ERROR_LOGIN'])) { ?>
<script>
    alertify.set('notifier','position', 'top-left');
    alertify.error("<?php echo $_SESSION['ERROR_LOGIN']; ?>");
    <?php unset($_SESSION['ERROR_LOGIN']); ?>
</script>
<?php } ?>
</body>
</html>
