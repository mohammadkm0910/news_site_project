$(function (){
    $("#admin-news").validate({
        rules: {
            title: {
                required: true,
                minlength: 4,
                maxlength: 150
            },
            summary: {
                required: true,
                minlength: 25
            }
        },
        messages: {
            title: {
                required: "لطفا عنوان خبر را وارد کنید",
                minlength: "عنوان خبر نمی تواند کمتر از 4 کارکتر باشد",
                maxlength: "عنوان خبر نمی تواند بیشتر از 150 کارکتر باشد"
            },
            summary: {
                required: "لطفا توضیح مختصر خبر را وارد کنید",
                minlength: "توضیح مختصر خبر نمی تواند کمتر از 25 کارکتر باشد"
            }
        },
        submitHandler:function (form) {
            form.submit();
        }
    });
});