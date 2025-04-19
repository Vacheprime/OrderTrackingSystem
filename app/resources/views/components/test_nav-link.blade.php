@props(["active" => false, "img" => ""])

<a class="nav-link {{$active ? "nav-link-active" : ""}}">
    <img src="{{$img}}"/>
    <p>{{$slot}}</p>
</a>
