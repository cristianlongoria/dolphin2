<form method="post" action="{{ route('panel.category.update', $category->id) }}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    {{ method_field('PUT') }}
    <input type="text"  name="name" value="{{ $category->name }}" placeholder="name">
    <input type="file" name="image" value="{{ $category->path_image }}">
    <input type="submit" value="Enviar">
</form>