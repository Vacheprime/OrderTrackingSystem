@extends("layouts.default")

@section("main")
<div class="main-content">
    @if($isCreate)
        <h2>Create Employee</h2>
    @else
        <h2>Update Employee</h2>
    @endif
    @foreach($employeeproperties as $property)
            <div class="property-div">
                <label id="{{$property}}-label" for="{{$property}}-input">{{$property}}</label>
                <input id="{{$property}}-input" name="{{$property}}-input" placeholder="{{$property}}" value=""/>
            </div>
    @endforeach
    @if($isCreate)

    @endif
</div>
@endsection
