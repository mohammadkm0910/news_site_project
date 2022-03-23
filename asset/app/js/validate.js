jQuery.validator.addMethod("noneSpace", function (value, element) {
    return this.optional(element) || value.match(/^\S*$/);
},"Cannot contain empty space");
$(function () {
    $("#form-register").validate({
        rules: {
            username: {
                noneSpace: true,
                required: true,
                minlength: 4,
                maxlength: 80
            },
            email: {
                required: true,
                maxlength: 120
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
          username: {
              noneSpace: "نام کاربری نمی تواند شامل فضای خالی باشد.",
              required: "لطفا نام کاربری خود را وارد کنید.",
              minlength: "نام کاربری نمی تواند کمتر از 4 کارکتر باشد",
              maxlength: "نام کاربری نمی تواند بیش از 80 کارکتر باشد"
          },
          email: {
              required: "لطفا ایمیل خود را وارد کنید.",
              maxlength: "ایمیل نمی تواند بیش از 120 کارکتر باشد"
          },
          password: {
              required: "وارد کردن پسورد اجباری است",
              minlength: "پسورد کاربر نمی تواند کمتر از 5 کارکتر باشد."

          }
        },
        submitHandler:function (form) {
            form.submit();
        }
    });
});
