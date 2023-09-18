@extends('layouts.app')

@section('content')
<style>
    .col-md-2 .card-body {
        padding:0;
    }
    .col-md-2 ul {
    padding: 0;
    position: relative;
    }

    .col-md-2 ul li {
    line-height: 1.8;
    padding: 0.5em 0.5em 0.5em 0.7em;
    list-style-type: none!important;
    background: -webkit-linear-gradient(top, #whitesmoke 0%, whitesmoke 100%);
    background: linear-gradient(to bottom, whitesmoke 0%, #dadada 100%);
    text-shadow: 1px 1px 1px whitesmoke;
    color: black;
    }
</style>
<div class="col-md-2">
    <div class="card">
        <div class="card-header"><i class="fas fa-th-list"></i></i> MENU</div>
        <div class="card-body">
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-stacked" style="display:block;">
                    <li><i class="fas fa-user-alt"></i> <a href="#">XXXXXXXX</a></li>
                    <li><i class="fas fa-user-alt"></i> <a href="#">XXXXXXXX</a></li>
                    <li><i class="fas fa-user-alt"></i> <a href="#">XXXXXXXX</a></li>
              </ul>
            </div>
        </div>
    </div>
</div>
@endsection
