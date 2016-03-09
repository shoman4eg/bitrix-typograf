if (window.BXHtmlEditor && window.BXHtmlEditor.editors) {
    for (var id in window.BXHtmlEditor.editors) {
        if (window.BXHtmlEditor.editors.hasOwnProperty(id)) {
            applyForEditor(window.BXHtmlEditor.Get(id));
        }
    }
}
function applyForEditor(editor) {
    editor.AddButton({
        id: 'typograf',
        src: '/bitrix/images/newkaliningrad.typografru/typograf.gif',
        name: 'Типограф',
        codeEditorMode: true,
        disabledForTextarea: false,
        title: 'Типограф',
        toolbarSort: 310,
        compact: true,
        handler: function () {
            var text = editor.GetContent();
            BX.ajax({
                method: 'POST',
                url: '/bitrix/tools/newkaliningrad.typografru/typograf.php',
                data: {
                    text: text
                },
                onsuccess: function (res) {
                    editor.SetContent(res, true);
                    editor.ReInitIframe();
                }
            });
        }
    });
}
BX.addCustomEvent("OnEditorInitedBefore", applyForEditor);