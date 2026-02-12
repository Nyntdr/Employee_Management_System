<div class="row mb-3 import-export-row">
    <div class="col-md-6">
        <div class="d-flex gap-2 btn-gap">
            <form action="{{ $import }}" method="POST" enctype="multipart/form-data"
                  class="d-inline">
                @csrf
                <input type="file" name="file" id="importFile" class="d-none" accept=".csv,.xlsx,.xls" required
                       onchange="this.form.submit()">
                <button type="button" onclick="document.getElementById('importFile').click()"
                        class="btn btn-midnight">
                    Import
                </button>
            </form>
            <a href="{{$export}}" class="btn btn-success">Export</a>
        </div>
    </div>
</div>
