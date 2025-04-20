@props(["active" => false, "img" => "", "href" => ""])

<a class="nav-link {{$active ? "nav-link-active" : ""}}" href="{{$href}}">
    <img src="{{$img}}"/>
    <p class="title">{{$slot}}</p>
</a>
