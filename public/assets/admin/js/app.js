$(function() {
    "use strict";

    // Tooltops

    $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    })



    $(".nav-toggle-icon").on("click", function() {
        $(".wrapper").toggleClass("toggled")
    })

    $(".mobile-toggle-icon").on("click", function() {
        $(".wrapper").addClass("toggled")
    })

    //Menu Active
    
    $(function() {
        for (var e = window.location, o = $(".sidebar-menu li a").filter(function() {
                return this.href == e
            }).addClass("").parent().addClass("mm-active"); o.is("li");) o = o.parent("").addClass("mm-show").parent("").addClass("mm-active")
    })


    $(".toggle-icon").click(function() {
        $(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function() {
            $(".wrapper").addClass("sidebar-hovered")
        }, function() {
            $(".wrapper").removeClass("sidebar-hovered")
        }))
    })



    $(function() {
        $("#menu").metisMenu()
    })


    $(".search-toggle-icon").on("click", function() {
        $(".top-header .navbar form").addClass("full-searchbar")
    })
    $(".search-close-icon").on("click", function() {
        $(".top-header .navbar form").removeClass("full-searchbar")
    })


    $(".chat-toggle-btn").on("click", function() {
        $(".chat-wrapper").toggleClass("chat-toggled")
    }), $(".chat-toggle-btn-mobile").on("click", function() {
        $(".chat-wrapper").removeClass("chat-toggled")
    }), $(".email-toggle-btn").on("click", function() {
        $(".email-wrapper").toggleClass("email-toggled")
    }), $(".email-toggle-btn-mobile").on("click", function() {
        $(".email-wrapper").removeClass("email-toggled")
    }), $(".compose-mail-btn").on("click", function() {
        $(".compose-mail-popup").show()
    }), $(".compose-mail-close").on("click", function() {
        $(".compose-mail-popup").hide()
    })


    $(document).ready(function() {
        $(window).on("scroll", function() {
            $(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
        }), $(".back-to-top").on("click", function() {
            return $("html, body").animate({
                scrollTop: 0
            }, 600), !1
        })
    })


    // switcher 

    $("#LightTheme").on("click", function() {
        $("html").attr("class", "light-theme")
    }),

    $("#DarkTheme").on("click", function() {
        $("html").attr("class", "dark-theme")
    }),

    $("#SemiDarkTheme").on("click", function() {
        $("html").attr("class", "semi-dark")
    }),

    $("#MinimalTheme").on("click", function() {
        $("html").attr("class", "minimal-theme")
    })

    //image upload preview
    
    function readURL(input,thisElement) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        var parentElement = thisElement.closest('.image-upload-area');
        var previewElement = parentElement.find('#preview');
        reader.onload = function(e) {
          previewElement.attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }

    $(".upload-image").on('change',function() {
        var thisElement = $(this);
      readURL(this,thisElement);
    });

    //summerNote
    $('.summerNote').summernote({
        placeholder: 'Write Description',
        tabsize: 2,
        height: 150,
        minHeight: null,// set minimum height of editor
        maxHeight: null,// set maximum height of editor
        lang: true,
        focus: true,
        toolbar: [
          ['style', ['style']],
          ['fontname', ['fontname']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    //select 2
    $('.select2').select2();
    $(".select2-auto-tokenize").select2({
        tags: true,
        tokenSeparators: [',']
    });
    $(".select2-auto-tokenize1").select2({
        closeOnSelect: false
    });

    $('.copyBtn').on('click',function(){
        /* Get the text field */
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");
        $(this).text('Copied');
    });


    // // user banner image

    // const bannerChange = document.getElementById("image-upload")
    // bannerChange.addEventListener("change", function(){
    //     readURL(this)
    // })
    // function readURL(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader();

    //         reader.onload = function (e) {
    //             $('#blah')
    //                 .attr('src', e.target.result);
    //         };

    //         reader.readAsDataURL(input.files[0]);
    //     }
    // }


});