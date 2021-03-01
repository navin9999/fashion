<ul>
@foreach($childs as $child)
	<li>
	    {{ $child->name }}
	    <a href="{{ $child->id }}" class="btn btn-warning">Edit</a>
				                     <a href="{{ $child->id }}" class="btn btn-danger">Delete</a>
	@if(count($child->childs))
            @include('Admin.manageChild',['childs' => $child->childs])
        @endif
	</li>
@endforeach
</ul>