<form action="/">
    <div class="flex justify-end text-xs">
        <input type="hidden" value="{{request('search')}}" name="search"/>
        <select name="column" id="column" onchange="checkValues()">
            <option value="">Select Value</option>
            <option value="author" {{request('column') == 'author' ? 'selected' : ''}}>Author</option>
            <option value="title" {{request('column') == 'title' ? 'selected' : ''}}>Title</option>
        </select>
        <select name="direction" id="direction" onchange="checkValues()">
            <option value="">Select Order</option>
            <option value="asc" {{request('direction') == 'asc' ? 'selected' : ''}}>Ascending</option>
            <option value="desc" {{request('direction') == 'desc' ? 'selected' : ''}}>Descending</option>
        </select>
        <button type="submit" class="text-zinc-900 border border-zinc-800 hover:bg-zinc-600 hover:text-white active:bg-zinc-700 font-bold text-xs px-4 py-2 rounded-full outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 disabled:opacity-60" id="sortButton" disabled>
        Sort
        </button>
    </div>
</form>

<script>
    function checkValues() {
        const columnValue = document.getElementById('column').value;
        const directionValue = document.getElementById('direction').value;
        const sortButton = document.getElementById('sortButton');

        if (columnValue && directionValue) {
            sortButton.disabled = false;
        } else {
            sortButton.disabled = true;
        }
    }
</script>