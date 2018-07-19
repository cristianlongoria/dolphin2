@if($errors->has())
    @foreach($errors->all() as $error)
        <ul>
            <li>{{ $error }}</li>
        </ul>
    @endforeach
@endif
@include('backend.category.forms.create-category')