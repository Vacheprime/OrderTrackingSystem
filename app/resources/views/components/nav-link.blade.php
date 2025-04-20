@props(["active" => false, "img" => ""])

<a {{$attributes}} class="nav-link {{$active ? "nav-link-active" : ""}}">
    <img src="{{$img}}"/>
    <p>{{$slot}}</p>
</a>
