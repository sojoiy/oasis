// Class definition

var KTIONRangeSlider = function () {
    
    // Private functions
    var demos = function () {
        // basic demo

        // min & max values
        $('#kt_slider_1').ionRangeSlider({
            min: 1,
            max: 30
        });

    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

jQuery(document).ready(function() {
    KTIONRangeSlider.init();
});