@if(session('success'))
<b-alert show dismissible variant="success">
  <strong>Ooopps!</strong> {{session('danger')}}
</b-alert>
@endif
@if(session('danger'))
<b-alert show dismissible variant="danger">
  <strong>Ooopps!</strong> {{session('danger')}}
</b-alert>
@endif