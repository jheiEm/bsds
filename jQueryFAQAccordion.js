// jQuery script 
$(document).ready(function() {
    // When <h4> tag is clicked
    $(".question h4").click(function() {
        // Check to see if there is a toggled question and close it.
        if ($('.faqAnswer').is(':visible')) {
            $(".faqAnswer").slideUp(300);
            $('.question').removeClass("open");
            $('h4').removeClass("open");
        }

        if ($(this).next(".faqAnswer").is(':visible')) {
            // If user clicks on an open question, closed it. Remove css classes.
            $(this).next(".faqAnswer").slideUp(300);
            $(this).parent().removeClass("open");
            $(this).removeClass("open");
        } 
        else { 
            // If user clicks on a question with an hidden answer, slideDown the answer and apply css classes.
            $(this).next(".faqAnswer").slideDown(300);
            $(this).parent().addClass('open');
            $(this).addClass('open');
        }
    });
  });