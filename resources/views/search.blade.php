<!DOCTYPE html>
<html>
<head>
    <title>Category Search</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>

  </div>
</nav>
    <div class="container" >
    <h1>Search Category</h1>

    <form method="GET" action="{{ route('search') }}">
        <input type="text" name="query" value="{{ request('query') }}" placeholder="Type something...">
        <button type="submit" class="btn btn-success">Search</button>
    </form>

    <hr>

         @if(isset($result) && $result  == true)
            <p><strong>Category:</strong> {{ $category }}</p>
            <p> <strong>Sub category</strong> {{ $sub_category }} </p>
            <p> <strong>Service</strong>  {{ $service }}</p>
            <p> <strong>Keywords</strong> {{ $keywords }}</p>
            <p> <strong>score </strong> {{ $score }}</p>
          @endif  
       
</div>
</body>
</html>
