$(document).ready(function() {

    $('.totop').on('click',function(){
        $('html,body').animate({
            scrollTop:0
        },1000)
        })

    new WOW().init();

    $('.ph').each(function(){
        gsap.to($(this), {
            xPercent: -20,
            ease: "power1.inOut",
            scrollTrigger: {
            trigger:$(this),
            start: "top bottom", // the default values
            end: "bottom top",
            scrub: true
            }
        });
    })
    $('.pv').each(function(){
        gsap.to($(this), {
            yPercent: -20,
            ease: "power1.inOut",
            scrollTrigger: {
            trigger:$(this),
            start: "top bottom", // the default values
            end: "bottom top",
            scrub: true
            }
        });
    })

    $('.pv2').each(function(){
        gsap.to($(this), {
            yPercent: 10,
            ease: "power1.inOut",
            scrollTrigger: {
            trigger:$(this),
            start: "top bottom", // the default values
            end: "bottom top",
            scrub: true
            }
        });
    })

});
