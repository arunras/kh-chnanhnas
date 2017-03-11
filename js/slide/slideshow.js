$slideshow = {
    prepareSlideshow: function() {
        $('div.slides > ul').cycle({
            fx: 'scrollHorz',
            timeout: 2000,
            speed: 2000,
            fastOnEvent: 500,
            pauseOnPagerHover: true,
            next: '#stripNavR0',
            prev: '#stripNavL0',
            pause: true
        });
    }
};

$(function() {
    // initialise the slideshow when the DOM is ready
    $slideshow.prepareSlideshow();
});  