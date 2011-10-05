document.addEvent('domready', function() {
    var warning = {
        basic: 'Для того, что бы вернуться и сохранить топик как черновик – нажмите Отмена, в противном случае набранный вами текст будет потерян.',
        extend: 'Для того, что бы вернуться и сохранить/опубликовать топик – нажмите "Остаться на странице", в противном случае набранный вами текст будет потерян.'
    };
    var textareas = document.getElements('textarea');
    var len = textareas.length;
    for (var i = 0; i < len; i++) {
        textareas[i].addEvent('keydown',function(e){
            addCheck(warning)
        }.bind(textareas[i]));
    }
    var input = document.getElements('input[type=submit]');
    var len = input.length;
    for (var i = 0; i < len; i++) {
        input[i].addEvent('click',function(e) {
            removeCheck()
        }.bind(input[i]));
    }
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