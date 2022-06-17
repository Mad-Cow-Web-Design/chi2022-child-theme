//jQuery start
jQuery(document).ready(function($) {
    $('form.cart').on('click', 'button.plus, button.minus', function() {

        // Get current quantity values
        var qty = $(this).closest('form.cart').find('.qty');
        var val = parseFloat(qty.val());
        var max = parseFloat(qty.attr('max'));
        var min = parseFloat(qty.attr('min'));
        var step = parseFloat(qty.attr('step'));
        console.log(qty);
        // Change the value if plus or minus
        if ($(this).is('.plus')) {
            if (max && (max <= val)) {
                qty.val(max);
            } else {
                qty.val(val + step);
            }


        } else {
            if (min && (min >= val)) {
                qty.val(min);
            } else if (val > 1) {
                qty.val(val - step);
            }
        }

    })

    $('.race-number').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).data('value')
        }, {
            duration: 1000,
            easing: 'swing',
            step: function(now) {
                $(this).text(this.Counter.toFixed(0));
            }
        });
    });
});

//jQuery end

function openDetails(evt, detailName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(detailName).style.display = "block";
    evt.currentTarget.className += " active";
}

// function animateValue(obj, start, end, duration) {
//     let startTimestamp = null;
//     const step = (timestamp) => {
//         if (!startTimestamp) startTimestamp = timestamp;
//         const progress = Math.min((timestamp - startTimestamp) / duration, 1);
//         obj.innerHTML = Math.floor(progress * (end - start) + start);
//         if (progress < 1) {
//             window.requestAnimationFrame(step);
//         }
//     };
//     window.requestAnimationFrame(step);
// }

// const obj = document.getElementById("value");
// animateValue(obj, 3, 0, 5000);

function show() {
    document.getElementById("phone-popup-link").style.display = "inline-block";
    document.getElementById("phone-popup-content").style.display = "inline-block";
}

function hide() {
    document.getElementById("phone-popup-link").style.display = "none";
    document.getElementById("phone-popup-content").style.display = "none";
}

// selecting the element
// let button = document.getElementById('show-update-form');
// let formDiv = document.getElementById('workshop-update')
//     // Add class to the element
// button.addEventListener('click', function() {
//     formDiv.classList.add('.show-update-form');
// });

document.addEventListener("DOMContentLoaded", function() {
    var button = document.getElementById('show-update-form');
    var formDiv = document.getElementById('workshop-update')
        // var faqContainers = document.getElementsByClassName('faq-container');
        // var faqToggle = document.getElementsByTagName('body')[0];
        // for (var i = 0; i < faqContainers.length; i++) {

    button.addEventListener('click', function() {
        formDiv.classList.add('show-update-form');
    });

});