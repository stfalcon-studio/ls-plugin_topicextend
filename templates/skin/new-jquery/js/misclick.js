$(document).ready(function(){

    var warning = {
        basic: 'Для того, что бы вернуться и сохранить топик как черновик – нажмите Отмена, в противном случае набранный вами текст будет потерян.',
        extend: 'Для того, что бы вернуться и сохранить/опубликовать топик – нажмите "Остаться на странице", в противном случае набранный вами текст будет потерян.'
    };

    jQuery.each(jQuery('textarea'),function(){
        jQuery(this).keydown(function(){
            addCheck(warning);
        });
    });

    jQuery.each(jQuery('input[type=submit]'),function(){
        jQuery(this).click(function(){
            removeCheck();
        });
    });
});

function removeCheck() {
    window.onbeforeunload = null;
};

function addCheck (warning){
    window.onbeforeunload = function(evt) {
        if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
            return warning.extend;
        } else if (navigator.userAgent.toLowerCase().indexOf('firefox/4') > -1) {
            evt = evt || window.event;
            evt.returnValue = warning.extend;
        } else {
            evt = evt || window.event;
            evt.returnValue = warning.basic;
        }
    }
};