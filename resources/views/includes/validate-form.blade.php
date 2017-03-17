@if( Session::has('success') )
    @if( Session::get('success') )
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <p> {!! Session::get('message') !!} </p>
            @if( Session::has('id'))
                <p>
                    <a href="{{ route( Session::get('route'), ['id' => Session::get('id')]) }}"
                       class="btn btn-default">
                        Clique aqui para visualizar
                    </a>
                </p>
            @endif
        </div>
    @else
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <p> {!! Session::get('message') !!} </p>
        </div>
    @endif
@endif


@if( isset($errors) && count($errors) > 0)
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif