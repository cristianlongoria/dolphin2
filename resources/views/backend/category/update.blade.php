@if($errors->has())
    @foreach($errors->all() as $error)
        <ul>
            <li>{{ $error }}</li>
        </ul>
    @endforeach
@endif
@if(Session::has('error'))
    <h1>{{ Session::get('error') }}</h1>
@endif
@include('backend.category.forms.update-category')