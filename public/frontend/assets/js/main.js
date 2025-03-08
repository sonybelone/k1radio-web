(function ($) {
  "user strict";

  // preloader
  $(window).on('load', function () {
    $('.preloader').fadeOut(1000);
    var img = $('.bg_img');
    img.css('background-image', function () {
      var bg = ('url(' + $(this).data('background') + ')');
      return bg;
    });
  });

//Create Background Image
(function background() {
  let img = $('.bg_img');
  img.css('background-image', function () {
    var bg = ('url(' + $(this).data('background') + ')');
    return bg;
  });
})();


// nice-select
$(".nice-select").niceSelect()

// header-fixed
var fixed_top = $(".header-section");
$(window).on("scroll", function(){
    if( $(window).scrollTop() > 100){
        fixed_top.addClass("animated fadeInDown header-fixed");
    }
    else{
        fixed_top.removeClass("animated fadeInDown header-fixed");
    }
});

// slider
var swiper = new Swiper('.testimonial-slider', {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
  centeredSlides: true,
  navigation: {
    nextEl: '.slider-next',
    prevEl: '.slider-prev',
  },
  autoplay: {
    speeds: 1000,
    delay: 2000,
  },
  speed: 1000,
  breakpoints: {
    991: {
      slidesPerView: 2,
    },
    767: {
      slidesPerView: 2,
    },
    575: {
      slidesPerView: 1,
    },
  }
});

// banner-sidebar
var swiper = new Swiper(".banner-slider", {
  slidesPerView: 1,
  spaceBetween: 0,
  loop: true,
  autoplay: {
    speed: 1000,
    delay: 4000,
  },
  speed: 1000,
  navigation: {
    nextEl: '.slider-next',
    prevEl: '.slider-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});


// team-sidebar
var swiper = new Swiper(".team-slider", {
  slidesPerView: 4,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    speed: 1000,
    delay: 4000,
  },
  speed: 1000,
  navigation: {
    nextEl: '.slider-next',
    prevEl: '.slider-prev',
  },
  breakpoints: {
    991: {
      slidesPerView: 3,
    },
    767: {
      slidesPerView: 2,
    },
    575: {
      slidesPerView: 2,
    },
    420: {
      slidesPerView: 1,
    },
  }
});


// video-sidebar
var swiper = new Swiper(".video-slider", {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
//   autoplay: {
//     speed: 1000,
//     delay: 4000,
//   },
    speed: 1000,
    navigation: {
        nextEl: '.slider-next',
        prevEl: '.slider-prev',
      },
  breakpoints: {
    991: {
      slidesPerView: 2,
    },
    767: {
      slidesPerView: 1,
    },
  }
});

//sidebar Menu
$(document).on('click', '.sidebar-collapse-icon', function () {
  $('.page-container').toggleClass('show');
});

// img-up
$('.imgUp').click(function () {
  upload();
});
function upload() {
  $(".upload").change(function () {
    readURL(this);
  });
}
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader(); reader.onload = function (e) {
      var preview = $(input).parents('.profile-thumb-area').find('.image-preview');
      $(preview).css('background-image', 'url(' + e.target.result + ')');
      $(preview).hide();
      $(preview).fadeIn(650);
    }
    reader.readAsDataURL(input.files[0]);
  }
}


$('.logo-btn').on('click', function (e) {
    $(".main-side-menu").toggleClass("show");
    $('.body-overlay').addClass('active');
  });
  $(".main-side-menu-cross").click(function(){
    $(".main-side-menu").removeClass("show");
    $('.body-overlay').removeClass('active');
  });
  $('#body-overlay').on('click', function (e) {
    e.preventDefault();
    $(".main-side-menu").removeClass("show");
    $('.body-overlay').removeClass('active');
});

//sidebar Menu
$(document).on('click', '.push-icon', function () {
    $('.notification-wrapper').toggleClass('active');
    $('.body-overlay').addClass('active');
  });
  $('#body-overlay').on('click', function (e) {
    e.preventDefault();
    $('.notification-wrapper').removeClass('active');
    $('.body-overlay').removeClass('active');
  });


// lightcase
$(window).on('load', function () {
  $("a[data-rel^=lightcase]").lightcase();
})

$('.header-mobile-search-btn').on('click', function (e) {
  e.preventDefault();
  if($('.header-mobile-search-form-area').hasClass('active')) {
    $('.header-mobile-search-form-area').removeClass('active');
    $('.body-overlay').removeClass('active');
  }else {
    $('.header-mobile-search-form-area').addClass('active');
    $('.body-overlay').addClass('active');
    $('.header-section').addClass('active');
  }
});
$('#body-overlay').on('click', function (e) {
  e.preventDefault();
  $('.header-mobile-search-form-area').removeClass('active');
  $('.body-overlay').removeClass('active');
});



})(jQuery);


    function laravelCsrf() {
    return $("head meta[name=csrf-token]").attr("content");
  }
//for popup
function openAlertModal(URL,target,message,actionBtnText = "Remove",method = "DELETE"){
    if(URL == "" || target == "") {
        return false;
    }

    if(message == "") {
        message = "Are you sure to delete ?";
    }
    var method = `<input type="hidden" name="_method" value="${method}">`;
    openModalByContent(
        {
            content: `<div class="card modal-alert border-0">
                        <div class="card-body">
                            <form method="POST" action="${URL}">
                                <input type="hidden" name="_token" value="${laravelCsrf()}">
                                ${method}
                                <div class="head mb-3 text-dark">
                                    ${message}
                                    <input type="hidden" name="target" value="${target}">
                                </div>
                                <div class="foot d-flex align-items-center justify-content-between">
                                    <button type="button" class="modal-close btn btn--info rounded text-light">Close</button>
                                    <button type="submit" class="alert-submit-btn btn btn--danger btn-loading rounded text-light">${actionBtnText}</button>
                                </div>
                            </form>
                        </div>
                    </div>`,
        },

    );
  }
function openModalByContent(data = {
content:"",
animation: "mfp-move-horizontal",
size: "medium",
}) {
$.magnificPopup.open({
    removalDelay: 500,
    items: {
    src: `<div class="white-popup mfp-with-anim ${data.size ?? "medium"}">${data.content}</div>`, // can be a HTML string, jQuery object, or CSS selector
    },
    callbacks: {
    beforeOpen: function() {
        this.st.mainClass = data.animation ?? "mfp-move-horizontal";
    },
    open: function() {
        var modalCloseBtn = this.contentContainer.find(".modal-close");
        $(modalCloseBtn).click(function() {
        $.magnificPopup.close();
        });
    },
    },
    midClick: true,
});
}

/**
 * Function For Get All Country list by AJAX Request
 * @param {HTML DOM} targetElement
 * @param {Error Place Element} errorElement
 * @returns
 */
var allCountries = "";
function getAllCountries(hitUrl,targetElement = $(".country-select"),errorElement = $(".country-select").siblings(".select2")) {
  if(targetElement.length == 0) {
    return false;
  }
  var CSRF = $("meta[name=csrf-token]").attr("content");
  var data = {
    _token      : CSRF,
  };
  $.post(hitUrl,data,function() {
    // success
    $(errorElement).removeClass("is-invalid");
    $(targetElement).siblings(".invalid-feedback").remove();
  }).done(function(response){
    // Place States to States Field
    var options = "<option selected disabled>Select Country</option>";
    var selected_old_data = "";
    if($(targetElement).attr("data-old") != null) {
        selected_old_data = $(targetElement).attr("data-old");
    }
    $.each(response,function(index,item) {
        options += `<option value="${item.name}" data-id="${item.id}" data-mobile-code="${item.mobile_code}" ${selected_old_data == item.name ? "selected" : ""}>${item.name}</option>`;
    });


    allCountries = response;

    $(targetElement).html(options);
  }).fail(function(response) {
    var faildMessage = "Something went wrong! Please try again.";
    var faildElement = `<span class="invalid-feedback" role="alert">
                            <strong>${faildMessage}</strong>
                        </span>`;
    $(errorElement).addClass("is-invalid");
    if($(targetElement).siblings(".invalid-feedback").length != 0) {
        $(targetElement).siblings(".invalid-feedback").text(faildMessage);
    }else {
      errorElement.after(faildElement);
    }
  });
}
// getAllCountries();


/**
 * Function for reload the all countries that already loaded by using getAllCountries() function.
 * @param {string} targetElement
 * @param {string} errorElement
 * @returns
 */
function reloadAllCountries(targetElement,errorElement = $(".country-select").siblings(".select2")) {
  if(allCountries == "" || allCountries == null) {
  // alert();
  return false;
  }
  var options = "<option selected disabled>Select Country</option>";
  var selected_old_data = "";
  if($(targetElement).attr("data-old") != null) {
    selected_old_data = $(targetElement).attr("data-old");
  }
  $.each(allCountries,function(index,item) {
    options += `<option value="${item.name}" data-id="${item.id}" data-currency-name="${item.currency_name}" data-currency-code="${item.currency_code}" data-currency-symbol="${item.currency_symbol}" ${selected_old_data == item.name ? "selected" : ""}>${item.name}</option>`;
  });
  $(targetElement).html(options);
}

function placePhoneCode(code) {
    if(code != undefined) {
        code = code.replace("+","");
        code = "+" + code;
        $("input.phone-code").val(code);
        $("div.phone-code").html(code);
    }
}
