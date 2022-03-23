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
    <title>ثبت نام کاربر</title>
</head>
<body>
<?php $this->partial("app.top-header"); ?>
<article class="p-4">
    <div class="row mt-2 reverse-md">
        <?php $this->partial("app.sidebar"); ?>
        <div class="col-md-8 col-9 p-md-2">
            <form  method="post" class="col-7 main-form" id="form-register" action="<?php $this->url('register/store'); ?>">
                <header>
                    <h5>فرم ثبت نام کاربر</h5>
                </header>
                <div class="form-group">
                    <label for="username" class="label-text">نام کاربری</label>
                    <input type="text" class="input-text" placeholder="نام کاربری را وارد کنید" name="username" id="username">
                </div>
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
                <div class="form-group">
                    <input type="submit" class="btn btn-success btn-block" value="ثبت نام">
                </div>
            </form>
        </div>
    </div>
</article>
<?php $this->partial("app.bottom-footer"); ?>
<script src="<?php $this->asset('plugin/jquery/jquery.validate.min.js'); ?>"></script>
<script src="<?php $this->asset('plugin/alertifyjs/alertify.min.js'); ?>"></script>
<script src="<?php $this->asset('app/js/script.js'); ?>"></script>
<script src="<?php $this->asset('app/js/validate.js'); ?>"></script>
</body>
</html>