<h1>Upload a Chat</h1>
<form action="" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="file"> <br> <br>
    <button type="submit">Upload</button>
</form>
