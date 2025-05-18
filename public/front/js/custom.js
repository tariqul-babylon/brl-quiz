$(document).ready(function () {
    const loginBtn = $('#login-btn');
    const regBtn = $('#reg-btn');
    const loginForm = $('#login-form');
    const regForm = $('#reg-form');
    loginBtn.click(function () {
        $(this).addClass('active');
        regBtn.removeClass('active');
        loginForm.removeClass('d-none');
        regForm.addClass('d-none');
        $('#header .error').html('');
    });
    regBtn.click(function () {
        $(this).addClass('active');
        loginBtn.removeClass('active');
        loginForm.addClass('d-none');
        regForm.removeClass('d-none');
        $('#header .error').html('');
    });

    $('.password .eye').click(function () {
        const icon = $(this).html().trim();
        if (icon == 'visibility') {
            $(this).html('visibility_off');
            $(this).parent().children('input').attr('type', 'text');
        } else {
            $(this).parent().children('input').attr('type', 'password');
            $(this).html('visibility');
        }
        console.log(icon)
    });

    $(window).scroll(function (event) {
        var scroll = $(this).scrollTop();
        // console.log(scroll)
        // Do something
    });


    //Sticky Nav
    var prevScrollpos = $(window).scrollTop();

    function stickyMenu() {
        var currentScrollPos = $(window).scrollTop();
        if (currentScrollPos > prevScrollpos) {
            $("#header.sticky").removeClass('fixed');
            // User is scrolling down (scrolling towards the bottom)
        } else if ((currentScrollPos < prevScrollpos) && currentScrollPos > 85) {
            $("#header.sticky").addClass('fixed');
            // User is scrolling up (scrolling towards the top)
        } else {
            $("#header.sticky").removeClass('fixed');
        }
        // Save the current scroll position for the next iteration
        prevScrollpos = currentScrollPos;
    }
    stickyMenu();
    $(window).scroll(function (e) {
        stickyMenu();
    });



    function menuIconChange(element) {


        if ($(element).hasClass('collapsed')) {
            $(element).children('span').html('menu');
            $('body').css('overflow', 'auto')
            $(element).parent().parent().parent().parent('.home').removeClass('regular');
        } else {
            $(element).children('span').html('close');
            $('body').css('overflow', 'hidden');
            if (!$(element).parent().parent().parent().parent().hasClass('sticky')) {
                $(element).parent().parent().parent().parent('.home').addClass('regular');
            } else {
                $(element).parent().parent().parent().parent('.home').removeClass('regular');
            }
        }
    }
    $(".navbar-toggler").click(function () {
        menuIconChange($(this));
    });

});