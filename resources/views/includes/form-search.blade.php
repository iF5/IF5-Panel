<form action="{{ route($route) }}" method="get">
    <div class="input-group">
        @if($keyword)
            <span class="input-group-addon">
                                <a href="{{ route($route) }}" title="Limpar busca">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </span>
        @endif
        <input class="form-control" type="text" id="keyword" name="keyword" placeholder="Buscar por"
               value="{{ $keyword }}" required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
    </div>
</form>