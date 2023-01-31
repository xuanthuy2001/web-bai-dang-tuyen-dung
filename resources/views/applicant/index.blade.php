@extends('layout_frontpage.master')
@section('content')
    <div class="col-md-9">
        <div class="row">
            @foreach($posts as $post)
                <x-post :post="$post"/>
            @endforeach
        </div>
        <div class="col-md-3" style="float: right">
            <ul class="pagination pagination-info">
                {{ $posts ->links()}}
            </ul>
        </div>
    </div>
@endsection
 