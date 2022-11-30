function confirmUserModal(username, plugins, themes) {
    const table = document.getElementById('users')
    if(table) {
        var pattern;
        if(plugins || themes) {
            pattern = table.dataset.contributor
                .replace('#username#', username)
                .replace('#plugins#', plugins)
                .replace('#themes#', themes)
                .replaceAll('\\n', "\n");
        } else {
            pattern = table.dataset.user
                .replace('#username#', username);
        }
        return confirm(pattern);
    }

    return false;
}

// for zooming previews of themes
(function() {
    'use strict';
    const THE_CLASS = 'zoom';
    const page = document.getElementById('themes-list');
    if(page != null) {
        page.addEventListener('click', function(event) {
            if(event.target.tagName == 'IMG') {
                const classList1 = event.target.parentElement.classList;
                if(classList1.contains('preview')) {
                    classList1.toggle(THE_CLASS);
                }
            }
        });
    }
})();
