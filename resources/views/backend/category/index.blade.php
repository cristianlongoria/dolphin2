@if($errors->has())
    @foreach($errors->all() as $error)
        <ul>
            <li>{{ $error }}</li>
        </ul>
    @endforeach
@endif
@if(Session::has('message'))
    <h1>{{ Session::get('message') }}</h1>
@endif
@foreach($categories as $category)
    <ul>
        <li>{{ $category->name }}</li>
    </ul>
@endforeach