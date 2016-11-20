<div class="col-sm-12" id="shared-table">
    <div id="shared-toggle" onclick="toggleSharedTable()">
        <button class="btn btn-default toggle-button">Sharing Table of This File
            <br>        
            <span class="glyphicon glyphicon-chevron-down" id="shared-arrow"></span>
        </button>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
        <th >Shared with</th>
        <th class="text-right hidden-xs">Permission type</th>
        <th class="text-right hidden-xs">Expiring</th>
        <th class="text-right">Options</th>
        </tr>
        </thead>
        <tbody id="shareTableBody">
        
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    function onLoadFunctions() {
        $("table").hide();
    }
    function toggleSharedTable() {
        $( "#shared-table>table" ).fadeToggle("slow");
        $( "#shared-arrow").toggleClass('glyphicon glyphicon-chevron-down').toggleClass('glyphicon glyphicon-chevron-up');
    }

    window.onload = onLoadFunctions;

    </script>
@endpush
