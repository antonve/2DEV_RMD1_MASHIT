$(document).ready(function(){
    // remove ajax
    $('.remove').on('click', function(ev){
        ev.preventDefault();
        var event = $(this);

        $.ajax({
            type: "GET",
            url: event.attr('href'),
            success: function(data) {
                if (jQuery.inArray(true, data)) {
                    event.after('<span class="remove">Removed</span>');
                    var parent = event.parent();
                    event.remove();
                    parent.delay(1000).fadeOut();
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });


    // add ajax
    $('.add').on('click', function(ev){
        ev.preventDefault();
        var event = $(this);

        $.ajax({
            type: "GET",
            url: event.attr('href'),
            success: function(data) {
                if (jQuery.inArray(true, data)) {
                    event.after('<span class="add">Added</span>');
                    event.remove();
                }
            }
        });
    });

    // http://webdesign.tutsplus.com/tutorials/htmlcss-tutorials/super-simple-lightbox-with-css-and-jquery/
    $('.trigger').click(function(e) {
        //prevent default action (hyperlink)
        e.preventDefault();
        //Get clicked link href
        var image_href = $(this).attr("href");
        /*
         If the lightbox window HTML already exists in document,
         change the img src to to match the href of whatever link was clicked
         If the lightbox window HTML doesn't exists, create it and insert it.
         (This will only happen the first time around)
         */
        if ($('#lightbox').length > 0) { // #lightbox exists
            //place href as img src value
            $('#lb_content').html('<img src="' + image_href + '" />');

            // center
            $('<img/>')
                .attr("src", $('#lightbox img').attr("src"))
                .load(function() {
                    $('#lb_content').css('margin-left', this.width / -2 + 'px')
                        .css('margin-top', this.height / -2 + 'px');
                });

            //show lightbox window - you could use .show('fast') for a transition
            $('#lightbox').fadeIn('fast');
            $('iframe').fadeOut('fast');
        }
        else { //#lightbox does not exist - create and insert (runs 1st time only)
            //create HTML markup for lightbox window
            var lightbox =
                '<div id="lightbox" style="display: none;">' +
                    '<p>Click to close</p>' +
                    '<div id="lb_content">' + //insert clicked link's href into img src
                    '<img src="' + image_href +'" />' +
                    '</div>' +
                    '</div>';
            //insert lightbox HTML into page
            $('body').append(lightbox);

            // center
            $('<img/>')
                .attr("src", $('#lightbox img').attr("src"))
                .load(function() {
                    $('#lb_content').css('margin-left', this.width / -2 + 'px')
                        .css('margin-top', this.height / -2 + 'px');
                });
            $('#lightbox').fadeIn('fast');
            $('iframe').fadeOut('fast');
        }
    });
    //Click anywhere on the page to get rid of lightbox window
    $('#lightbox').live('click', function() { //must use live, as the lightbox element is inserted into the DOM
        $('#lightbox').fadeOut('fast');
        $('iframe').fadeIn('fast');
    });
    $(document).keydown(function(e){
        if (e.keyCode == 27) { // escape
            $('#lightbox').fadeOut('fast');
            $('iframe').fadeIn('fast');
        }
    });

    // show wait on long load
    $('a').click(function(e){
        if (!$(this).hasClass('noload')) {
            $(this).delay(1000, "myQueue").queue("myQueue", function(){
                $('body').append('<div class="loader" style="display: none;"></div>');
                $('.loader').fadeIn('fast');
            }).dequeue("myQueue");
        }
    });

    // crossbrowser placeholder
    if(!Modernizr.input.placeholder){

        $('[placeholder]').focus(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).blur();
        $('[placeholder]').parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    }

    // TODO: validate
});