var dfreeTitleConfig = {
    selector: '.dfree-title',
    placeholder: "Ajouter un titre",
    menubar: false,
    inline: true,
    toolbar: false,
    plugins: [ 'quickbars' ],
    quickbars_insert_toolbar: false,
    quickbars_selection_toolbar: false
};

var dfreeDescConfig = {
    selector: '.dfree-desc',
    placeholder: "Ajouter une description",
    menubar: false,
    inline: true,
    toolbar: false,
    plugins: [ 'quickbars' ],
    quickbars_insert_toolbar: false,
    quickbars_selection_toolbar: false
};

var dfreeSlugConfig = {
    selector: '.dfree-slug',
    placeholder: "Ajouter un slug",
    menubar: false,
    inline: true,
    toolbar: false,
    plugins: [ 'quickbars' ],
    quickbars_insert_toolbar: false,
    quickbars_selection_toolbar: false
};

var dfreeContentConfig = {
    selector: '.dfree-content',
    placeholder: "Ajouter du contenu",
    menubar: false,
    inline: true,
    plugins: [
        'autolink',
        'codesample',
        'link',
        'lists',
        'media',
        'powerpaste',
        'table',
        'image',
        'quickbars',
        'codesample',
        'help'
    ],
    toolbar: false,
    quickbars_insert_toolbar: 'quicktable image media codesample',
    quickbars_selection_toolbar: 'bold italic underline | formatselect | blockquote quicklink',
    contextmenu: 'undo redo | inserttable | cell row column deletetable | help',
    powerpaste_word_import: 'clean',
    powerpaste_html_import: 'clean',
};

tinymce.init(dfreeTitleConfig);
tinymce.init(dfreeDescConfig);
tinymce.init(dfreeSlugConfig);
tinymce.init(dfreeContentConfig);