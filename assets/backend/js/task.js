$('#Task_class').change(function () {
    setDefaultData($(this).val());
});

function setDefaultData(value) {
    let newValue = '';

    switch (value) {
        case 'App\\Message\\SaveLog':
            newValue = '{"text":"your text log"}';
            break;
        case 'App\\Message\\SendTextInMessenger':
            newValue = '{"login":"your login","password":"your password","text":["text1","text2","text3"],"userUrl":"https:\\/\\/www.messenger.com\\/t\\/userlink"}';
            break;
    }

    document.querySelector('.CodeMirror').CodeMirror.setValue(newValue);
}
