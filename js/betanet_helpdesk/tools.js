// function setLocation(url){
//     window.location.href = encodeURI(url);
// }
var oldSetLocation = setLocation.prototype.constructor;
setLocation = function (url) {
    if (url.indexOf('delete') !== -1 && typeof setLocationForm === 'undefined') {
        var form = document.createElement('form');
        form.setAttribute('id', 'setLocationForm');
        form.setAttribute('method', 'POST');
        form.setAttribute('action', url);
        var hidden = document.createElement('input');
        hidden.setAttribute('type', 'hidden');
        hidden.setAttribute('name', 'form_key');
        hidden.setAttribute('value', window.FORM_KEY);
        form.appendChild(hidden);
        document.body.appendChild(form);
        setLocationForm = new varienForm('setLocationForm');
    }

    if (typeof setLocationForm !== 'undefined') {
        setLocationForm.submit(url);
        return false;
    }

    oldSetLocation(url);
};