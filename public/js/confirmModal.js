function confirmModal(name, request, item) {
    if (confirm('Are you sure to remove ' + name + ' ' + item + ' ?')) {
        fetch(request).then(response => document.location.reload(true));
    }
}
