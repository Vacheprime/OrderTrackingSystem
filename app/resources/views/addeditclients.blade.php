@extends("layouts.default")

@section("main")
<div class="main-content">
    <h2>Edit Client</h2>
    <hr/>
    <div class="flex-input-div">
        @if($isEdits)
            @foreach($clientproperties as $property)
                <div class="property-div">
                    <label id="{{$property}}-label" for="{{$property}}-input">{{$property}}</label>
                    <input id="{{$property}}-input" name="{{$property}}-input" placeholder="{{$property}}"/>
                </div>

            @endforeach
        @elseif(!$isEdit)
            @foreach($clientproperties as $property)

            @endforeach
        @endif

    </div>
</div>
@endsection
