@vite("resources/js/tables.js")
<x-layout>
    <div class="main-content">
        <div id="employees-table-div" class="table-div">
            <div id="employees-table-header" class="table-header-div">
                <form action="" method="POST">
                    <x-input-property :label="false" property="Enter Field" propertyName="search-input"/>
                    <x-select selectId="search-by"  :properties="{{["Employee ID", "First Name", "Last Name"]}}"/>
                    <x-select selectId="filter-by" :properties="{{["Newest", "Oldest", "Status"]}}"/>
                    <input type="submit" value="Search" onclick="searchTable()"/>
                </form>
            </div>
            <div id="clients-table-content" class="table-content-div">
                <x-client-table/>
                {{-- Component not added yet --}}
            </div>
        </div>
    </div>

    <div class="side-content">

    </div>
</x-layout>
