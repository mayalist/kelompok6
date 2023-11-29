function convertFile() {
    var formData = new FormData(document.getElementById('converterForm'));

    fetch('converter.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('output').innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
