<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="#">Cicles Formatius</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" datatarget="#navbarNav" aria-controls="navbarNav" aria-expanded="false" arialabel="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav">

<li class="nav-item">
    <a class="nav-link" href="{{ route('ciclosFormativos.index') }}">Llistar Cicles formatius</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('ciclosFormativos.create') }}">Crear Cicles formatius</a>
</li>

</ul>
</div>
</nav>