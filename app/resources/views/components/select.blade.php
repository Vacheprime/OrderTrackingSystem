@props(["properties" => ["default"], 'selectId'])

<select name="{{$selectId}}" id="{{$selectId}}" class="select-input">
    @foreach($properties as $property)
        @if($loop->first)
            <option autofocus value="{{strtolower(trim($porperty))}}">{{$property}}</option>
        @else
            <option value="{{strtolower(trim($porperty))}}">{{$property}}</option>
        @endif
    @endforeach
</select>
