<div class="card-main main-border">
    <div class="card-header">
        <h2>فرم ویرایش نظر</h2>
    </div>
    <div class="card-body">
        <form method="post" action="<?php $this->url('admin/update-comment/'.$comment['id']); ?>">
            <?php if (isset($comment['comment'])) { ?>
            <div class="form-horizontal no-wrap-md">
                <label for="comment">ویرایش نظر</label>
                <textarea class="form-control resizable" id="comment" name="comment" placeholder="نظر خود را وارد کنید"><?php echo $comment['comment'] ; ?></textarea>
            </div>
            <div class="form-horizontal">
                <input type="submit" class="btn btn-success offset-form" value="ذخیره اطلاعات">
            </div>
            <?php } else { ?>
                <div class="form-horizontal no-wrap-md">
                    <label for="disabled">ویرایش نظر</label>
                    <textarea class="form-control" id="disabled" rows="1" disabled>نظر ناخواناست!!</textarea>
                </div>
            <?php } ?>
        </form>
    </div>
</div>