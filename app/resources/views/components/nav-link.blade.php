@props(["active" => false, "img" => "", "href" => ""])

<a class="nav-link {{$active ? "nav-link-active" : ""}}" href="{{$href}}">
    <img class="nav-link-img" src="{{$img}}"/>
    <p class="nav-link-a">{{$slot}}</p>
</a>
