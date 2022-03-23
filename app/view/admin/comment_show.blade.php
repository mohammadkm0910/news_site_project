<div class="card-main main-border">
    <div class="card-header">
        <h2>جزیئات صفحه</h2>
    </div>
    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>نام کاربری نظر دهنده:</dt>
            <dd><?php echo $comment['username']; ?></dd>
            <dt>کدام خبر:</dt>
            <dd><?php echo $comment['title']; ?></dd>
            <dt>وضعیت نظر:</dt>
            <dd><?php echo $comment['status'][0]; ?></dd>
            <dt>متن نظر:</dt>
            <dd class="text-justify"><?php echo $comment['status'][0] == "unseen" ? "خبر ناخوانا است!!" : $comment['comment']; ?></dd>
            <dt>تاریخ ثبت نظر:</dt>
            <dd><?php echo formattedDateSql($comment['created_at'][0]); ?></dd>
            <dt>تاریخ ویرایش نظر:</dt>
            <dd><?php echo formattedDateSql($comment['updated_at'][0]); ?></dd>
        </dl>
    </div>
</div>