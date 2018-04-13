<div class="row">
    <div class="col-md-12" style="text-align: center; margin-top: 1.5em;">
        <p>
            <strong>{{ $letter->fieldForCollection($collection) }}</strong>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <Upload target="{{route('letters.scans.upload', $letter)}}?collection={{ $collection }}"></Upload>
    </div>
</div>

@foreach($letter->getMedia('letters.scans.' . $collection) as $index => $media)
    <div class="row">
        <div class="col-md-12" style="margin-top: 1.5em;">
            <p style="text-align: center; font-size: 18px;">
                <strong>Seite {{ $media->order_column }}</strong>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <img src="{{ $media->getFullUrl() }}" class="img-responsive">
        </div>
    </div>
    <div class="row" style="margin-top: 1.5em;">
        <div class="col-md-12" style="text-align: center;">
            <div class="btn-group">
                <form action="{{ route('letters.scans.update', [$letter, $media]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}

                    @unless($media->order_column == 1)
                        <button class="btn btn-default" type="submit" name="left" value="1">
                            <span class="fa fa-arrow-up"></span>
                        </button>
                    @endunless

                    @unless($media->order_column == $letter->getMedia('letters.scans.' . $collection)->count())
                        <button class="btn btn-default" type="submit" name="right" value="1">
                            <span class="fa fa-arrow-down"></span>
                        </button>
                    @endunless
                </form>
            </div>

            <div class="btn-group">
                <form onsubmit="return confirm('Soll der Scan wirklich gelöscht werden?');" action="{{ route('letters.scans.destroy', [$letter, $media]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}

                    <button class="btn btn-danger">
                        <span class="fa fa-trash"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endforeach
