<script>
    const searchInput = document.getElementById('{{$search}}');
    const resultsBox = document.getElementById('{{$result}}');

    searchInput.addEventListener('keyup', function () {
        fetch(`{{ $route }}?search=${this.value}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(res => res.text())
            .then(html => {
                resultsBox.innerHTML = html;
            });
    });
</script>
