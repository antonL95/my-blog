import $ from 'jquery';

export default class ScrollOnClick {
    init() {
        // Select all links with hashes
        $('a[href*="#"]')
        // Remove links that don't actually link to anything
            .not('[href="#"]')
            .not('[href="#0"]')
            .click((event) => {
                // On-page links
                if (location.pathname.replace(/^\//, '') == event.currentTarget.pathname.replace(/^\//, '') && location.hostname == event.currentTarget.hostname) {
                    // Figure out element to scroll to
                    let target = $(event.currentTarget.hash);
                    target = target.length ? target : $('[name=' + event.currentTarget.hash.slice(1) + ']');
                    // Does a scroll target exist?
                    if (target.length) {
                        // Only prevent default if animation is actually gonna happen
                        event.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top + 40
                        }, 100, () => {
                            // Callback after animation
                            // Must change focus!
                            let $target = $(target);
                            $target.focus();
                            if ($target.is(":focus")) { // Checking if the target was focused
                                return false;
                            } else {
                                $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                                $target.focus(); // Set focus again
                            }
                        });
                    }
                }
            });
    }
}

