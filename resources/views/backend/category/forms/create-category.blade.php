<form method="post" action="{{ route('panel.category.store') }}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <input type="text"  name="name" placeholder="name">
    <input type="file" name="image">
    <input type="submit" value="Enviar">
</form>