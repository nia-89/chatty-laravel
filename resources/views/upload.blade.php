<h1>Upload a Chat</h1>
<form action="" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="file" accept=".txt"> <br> <br>
    <button type="submit">Upload</button>
</form>
