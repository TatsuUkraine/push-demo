self.addEventListener('sync', function(event) {
    console.log(event.tag);
});